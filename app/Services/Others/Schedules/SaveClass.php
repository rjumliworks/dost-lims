<?php

namespace App\Services\Others\Schedules;

use App\Models\Schedule;
use App\Models\ScheduleUser;
use App\Models\ScheduleCustomer;
class SaveClass
{
   public function save($request){
        if (strpos($request->date, ' to ') !== false) {
            list($start, $end) = explode(' to ', $request->date);
            $startTime = "08:00:00";
            $endTime = "23:00:00";
            $start = substr($start, 0, 10);
            $end = substr($end, 0, 10);
            $start = $start.' '.$startTime;
            $end = $end.' '.$endTime;
        }else{
            if($request->is_allday){
                $startTime = "08:00:00";
                $endTime = "17:00:00";
                $date = substr($request->date, 0, 10);
                $start = $date.' '.$startTime;
                $end = $date.' '.$endTime;
            }else{
                $start = $request->start;
                $end = $request->end;
            }
        }
        
        $data = Schedule::create([
            'start' => $start,
            'end' => $end,
            'is_allday' => $request->is_allday,
            'event_id' => $request->event['value']
        ]);

        $data->information()->create([
            'title' => $request->title,
            'venue' => $request->venue,
            'information' => $request->information,
            'samples' => $request->samples,
            'tsr_id' => $request->tsr_id,
            'quotation_id' => $request->quotation_id,
            'customer_id' => $request->customer ? $request->customer['value'] : null,
            'conforme_id' => $request->conforme ? $request->conforme['value'] : null,
            'schedule_id' => $data->id
        ]);

        if(count($request->users)){
            foreach($request->users as $user){
                ScheduleUser::create([
                    'schedule_id' => $data->id,
                    'user_id' => $user['value']
                ]);
            }
        }

        return [
            'data' => $data,
            'message' => 'Schedule creation was successful!', 
            'info' => "You've successfully created the new event."
        ];
    }
}
