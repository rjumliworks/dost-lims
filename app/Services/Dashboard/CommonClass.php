<?php

namespace App\Services\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Equipment;
use App\Models\InventoryItem;
use App\Models\InventoryStock;
use App\Http\Resources\Others\Schedules\EventResource;

class CommonClass
{
    public function calendar($request){
        return [
            'schedules' => $this->schedules($request),
            'personnels' => $this->personnels($request),
            'equipments' => $this->equipments($request),
            'inventory' => $this->inventory($request)
        ];
    }

    private function inventory($request){
        $start = now()->startOfWeek();
        $end   = now()->startOfWeek()->addDays(4);
        $laboratory = $request->laboratory;

        $outOfStockItems = InventoryItem::when($laboratory, function ($query) use ($laboratory) {
                $query->where('laboratory_id', $laboratory);
            })
            ->withSum('stocks', 'quantity')
            ->havingRaw('COALESCE(stocks_sum_quantity, 0) = 0')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'type' => 'Out of Stock',
                    'icon' => 'ri-alert-fill text-danger',
                    'quantity' => 0
                ];
            });

        $expiredStocks = InventoryStock::with('item')
            ->where('quantity', '!=', 0)
            ->where('expired_at', '<=', $end)
            ->when($laboratory, function ($query) use ($laboratory) {
                $query->whereHas('item', function ($query) use ($laboratory) {
                    $query->where('laboratory_id', $laboratory);
                });
            })
            ->get()
            ->map(function ($stock) {
                return [
                    'name' => $stock->item->name ?? 'N/A',
                    'type' => 'Expired',
                    'icon' => 'ri-error-warning-fill text-warning',
                    'quantity' => $stock->quantity,
                    'expired_at' => $stock->expired_at,
                ];
            });

        return [
            'outofstock' => $outOfStockItems->count(),
            'expired' => $expiredStocks->count(),

            // detailed lists                                                                                                                                                                                                                                
            'outofstock_list' => $outOfStockItems,
            'expired_list' => $expiredStocks,

            // optional: merge all into one list
            'list' => $outOfStockItems->concat($expiredStocks)->values()
        ];
    }

    private function equipments($request){
        $start = now()->startOfWeek();
        $end   = now()->startOfWeek()->addDays(4);
        $laboratory = $request->laboratory;

        $cutoff = now()->startOfWeek()->addDays(4);

        $equipments = Equipment::where(function ($q) use ($cutoff) {
            $q->whereDate('maintenance_due', '<=', $cutoff)
            ->orWhereDate('calibration_due', '<=', $cutoff);
        })
        ->when($laboratory, function ($query) use ($laboratory) {
            $query->where('laboratory_id', $laboratory);
        })
        ->get();

        $data = $equipments->map(function ($item) use ($cutoff) {

            $isMaintenanceDue = $item->maintenance_due && $item->maintenance_due <= $cutoff;
            $isCalibrationDue = $item->calibration_due && $item->calibration_due <= $cutoff;

            // Determine type
            if ($isMaintenanceDue && $isCalibrationDue) {
                $type = 'Maintenance/Calibration';
                $icon = 'ri-tools-fill text-danger'; // example
                $bg = 'bg-danger-subtle';
            } elseif ($isMaintenanceDue) {
                $type = 'Maintenance';
                $icon = 'ri-settings-3-fill text-warning';
                $bg = 'bg-warning-subtle';
            } elseif ($isCalibrationDue) {
                $type = 'Calibration';
                $icon = 'ri-focus-3-fill text-info';
                $bg = 'bg-info-subtle';
            }

            return [
                'name' => $item->name,
                'maintenance_due' => $isMaintenanceDue ? $item->maintenance_due : null,
                'calibration_due' => $isCalibrationDue ? $item->calibration_due : null,
                'type' => $type,
                'icon' => $icon,
                'bg' => $bg
            ];
        });

        return [
            'maintenance' => Equipment::whereNotIn('status_id',[36,37])
                ->whereDate('maintenance_due', '<=', $end)
                ->when($laboratory, function ($query) use ($laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->count(),

            'calibration' => Equipment::whereNotIn('status_id',[36,37])
                ->whereDate('calibration_due', '<=', $end)
                ->where('calibration_program','!=','Not Applicable')
                ->when($laboratory, function ($query) use ($laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->count(),

            'list' => $data
        ];
    }
    
    private function schedules($request){
        $start = now()->startOfWeek();
        $end   = now()->startOfWeek()->addDays(4);

        return [
            'calibration' => Schedule::whereIn('event_id',[1,2])
                ->whereDate('start', '<=', $end)
                ->whereDate('end', '>=', $start)
                ->count(),

            'testing' => Schedule::whereIn('event_id',[3,4])
                ->whereDate('start', '<=', $end)
                ->whereDate('end', '>=', $start)
                ->count(),

            'others' => Schedule::whereNotIn('event_id',[1,2,3,4])
                ->whereDate('start', '<=', $end)
                ->whereDate('end', '>=', $start)
                ->count(),

            'list' => EventResource::collection(
                Schedule::with('users.user:id','users.user.profile')
                    ->with('information.customer.customer_name','information.customer.address','information.conforme')
                    ->whereDate('start', '<=', $end)
                    ->whereDate('end', '>=', $start)
                    ->orderBy('start','ASC')
                    ->get()
            )
        ];
    }

    private function personnels($request)
    {
        // IN (inside laboratory)
        $inCount = Schedule::where(function ($q) {
            $q->whereDate('start', '<=', Carbon::today())
            ->whereDate('end', '>=', Carbon::today());
        })
        ->whereHas('event', fn($q) => $q->where('is_out', 0))
        ->with('users.user:id')
        ->get()
        ->pluck('users')
        ->flatten()
        ->pluck('user')
        ->unique('id')
        ->count();


        $outUsers = User::select('id')->with('profile')->whereHas('schedules.schedule', function ($q) {
            $q->whereDate('start', '<=', Carbon::today())
            ->whereDate('end', '>=', Carbon::today())
            ->whereHas('event', fn($e) => $e->where('is_out', 1));
        })
        ->with([
            'schedules' => function ($q) {
                $q->whereHas('schedule', function ($q) {
                    $q->whereDate('start', '<=', Carbon::today())
                    ->whereDate('end', '>=', Carbon::today())
                    ->whereHas('event', fn($e) => $e->where('is_out', 1));
                });
            },
            'schedules.schedule' => function ($q) {
                $q->select('id','start','event_id');
                $q->whereDate('start', '<=', Carbon::today())
                ->whereDate('end', '>=', Carbon::today())
                ->whereHas('event', fn($e) => $e->where('is_out', 1))
                ->with('event:id,name,type,color,bg');
            }
        ])
        ->get();
        $outUsers = $outUsers->map(function ($user) {
            return [
                'user_id' => $user->id,
                'name'    => $user->profile->full_name ?? null,
                'avatar'    => $user->profile->avatar,

                'schedules' => $user->schedules->map(function ($pivot) {
                    $schedule = $pivot->schedule;

                    return [
                        'schedule_id' => $schedule->id,
                        'start'       => $schedule->start,

                        'event' => [
                            'id'    => $schedule->event->id,
                            'name'  => $schedule->event->name,
                            'type'  => $schedule->event->type,
                            'color' => $schedule->event->color,
                            'bg'    => $schedule->event->bg,
                        ],
                    ];
                })->values(),
            ];
        });

        return [
            'in' => $inCount,
            'out' => $outUsers->count(),
            'list' => $outUsers
        ];
    }

}
