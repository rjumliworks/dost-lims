<?php

namespace App\Services\Major\Tsr;

use App\Models\Tsr;
use App\Models\TsrPayment;

class UpdateClass
{
    public function cancel($request){
        $tsr_id = $request->id;
        $data = Tsr::find($tsr_id);
        $data->update($request->except(['option']));
        $payment = TsrPayment::where('tsr_id',$tsr_id)->update(['status_id' => 9]);
        
        $cancel = $data->remarkable()->create([
            'amount' => $data->payment->subtotal,
            'reason' => $request->reason,
            'type_id' => 85,
            'user_id' => \Auth::user()->id
        ]);
        
        return [
            'data' => $data,
            'message' => 'TS Request Cancelled', 
            'info' => "Request has been cancelled. No further actions can be performed, including adding samples, analyses, or editing any information.",
        ];
    }
}
