<?php

namespace App\Services\Major\Tsr;

use App\Models\Tsr;
use App\Models\Customer;

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
        $customerId = $request->customer['value'];
        $hasPrevious = Tsr::where('customer_id', $customerId)->exists();
        $tsr = Tsr::create(array_merge(
            $request->tsrData(),
            ['is_first' => $hasPrevious ? 0 : 1]
        ));
        $tsr->createPayment($request->isFreePayment());
        if($request->is_referral){
            $tsr->createReferral($request->referralData());
        }
        $customer = Customer::find($customerId);

        if($hasPrevious){
            $customer->update(['is_new' => 0]);
        }

        $tsr = Tsr::find($tsr->id);
        return [
            'data' => $tsr->reference,
            'message' => 'TS Request creation was successful!', 
            'info' => "You've successfully created the new request."
        ];
    }
}
