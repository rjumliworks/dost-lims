<?php

namespace App\Services\Major\Tsr;

use App\Models\Tsr;

class ViewClass
{
    public function counts($statuses){
        foreach($statuses as $status){
            if ($status['value'] == '2') {
                $counts[] = Tsr::where(function ($query) {
                    $query->where('status_id', 2)
                          ->orWhere(function ($query) {
                              $query->whereIn('status_id', [3, 4])
                                    ->whereHas('payment', function ($query) {
                                        $query->where('status_id', 18);
                                    });
                          });
                })
                // ->when($this->province, function ($query) {
                //     $query->where('received_by', \Auth::user()->id);
                // })
                // ->when($this->configuration->strict_mode == 1, function ($query) {
                //     $facility = \Auth::user()->profile->facility;

                //     if ($facility->is_psto || $facility->is_separated) {
                //         $query->where('facility_id', $facility->id);
                //     }
                // })
                // ->where('agency_id',$this->agency)
                ->count();
            } else {
                $counts[] = Tsr::where('status_id',$status['value'])
                // ->when($this->province, function ($query){
                //     $query->where('received_by', \Auth::user()->id);
                // })
                // ->when($this->configuration->strict_mode == 1, function ($query) {
                //     $facility = \Auth::user()->profile->facility;

                //     if ($facility->is_psto || $facility->is_separated) {
                //         $query->where('facility_id', $facility->id);
                //     }
                // })
                // ->where('agency_id',$this->agency)
                ->count();
            }
        }
        return $counts;
    }

    public function region(){
        return \Auth::user()->profile?->agency?->address?->region_code;
    }
}
