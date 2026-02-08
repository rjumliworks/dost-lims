<?php

namespace App\Services\Major\Tsr;

use App\Models\Tsr;

class SaveClass
{
    public function validation($request){
        return [
            'data' => '-',
            'message' => 'off', 
            'info' => "You've successfully created the new customer."
        ];
    }
    
    public function save($request)
    {
        $tsr = Tsr::create($request->tsrData());
        $tsr->createPayment($request->isFreePayment());
        if($request->is_referral){
            $tsr->createReferral($request->referralData());
        }
        $tsr = Tsr::find($tsr->id);
        return [
            'data' => $tsr->reference,
            'message' => 'TS Request creation was successful!', 
            'info' => "You've successfully created the new request."
        ];
    }
}
