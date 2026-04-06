<?php

namespace App\Services\Others\Schedules;

use App\Models\Schedule;
use App\Http\Resources\Others\Schedules\EventResource;

class ViewClass
{
    public function events($request){
        $data = Schedule::with('user','event')
        ->with('users.user:id','users.user.profile')
        ->with('information.customer.customer_name','information.customer.address','information.conforme')->get();
        return EventResource::collection($data);
    }
}
