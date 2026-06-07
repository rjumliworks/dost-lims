<?php

namespace App\Services\Common\Signing;

use App\Models\TsrSampleReport;

class ViewClass
{
    public function reports($request){
        $user_id = \Auth::user()->id;
        $data = TsrSampleReport::with('tsr:id,code,due_at','signatory')
        ->whereHas('signatory', function ($q) use ($user_id) {
            $q->where(function ($query) use ($user_id){
                $query->where('analyzed_by', $user_id)->where('status_id', 38);
            })->orWhere(function ($query) use ($user_id){
                $query->where('certified_by', $user_id)->where('status_id', 39);
            })->orWhere(function ($query) use ($user_id){
                $query->where('approved_by', $user_id)->where('status_id', 40);
            });
        })->get();

        return $data;
    }
}
