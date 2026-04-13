<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\Schedule;
use Carbon\Carbon;
use App\Http\Resources\Others\Schedules\EventResource;

class CommonClass
{
    public function calendar($request){
        return [
            'schedules' => $this->schedules($request),
            'personnels' => $this->personnels($request)
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
