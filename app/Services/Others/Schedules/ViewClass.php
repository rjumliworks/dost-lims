<?php

namespace App\Services\Others\Schedules;

use App\Models\Schedule;
use App\Http\Resources\Others\Schedules\EventResource;

class ViewClass
{
    public function events($request){
        $data = Schedule::with('user','event','users','information.customer.customer_name')->get();
        return EventResource::collection($data);
    }
}
