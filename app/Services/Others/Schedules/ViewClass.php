<?php

namespace App\Services\Others\Schedules;

use App\Models\Tsr;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Resources\Others\Schedules\EventResource;

class ViewClass
{
    public function events($request){
        $data = Schedule::with('user','event')
        ->with('users.user:id','users.user.profile')
        ->with('information.customer.customer_name','information.customer.address','information.conforme')->get();
        return EventResource::collection($data);
    }

    public function dues($request){
        $start = Carbon::now()->startOfMonth();

        $tsrs = Tsr::select(
                DB::raw('DATE(due_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->whereDate('due_at', '>=', $start)
            ->groupBy('date')
            ->get();



        $events = $tsrs->map(function ($item) {
            if($item->total > 5 && $item->total < 9){
                $class = 'bg-warning-subtle text-warning';
            }else if($item->total > 10 && $item->total < 20){
                $class = 'bg-danger-subtle text-danger';
            }else if($item->total > 20){
                $class = 'bg-dark-subtle text-dark';
            }else {
                $class = 'bg-info-subtle text-info';
            }

            return [
                'title' => $item->total . ' due(s)',
                'start' => $item->date,
                'allDay' => true,
                'className' => $class,
            ];
        });

        return $events;
    }
}
