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

        // $data = new TsrResource(
        //     Tsr::with('services.service')
        //     ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.wallet')
        //     ->with('customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name')
        //     ->with('payment:tsr_id,id,total,subtotal,discount,or_number,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others')
        //     ->where('id',$id[0])
        //     ->first()
        // );

        return [
            'data' => $data,
            'message' => 'TS Request Cancelled', 
            'info' => "Request has been cancelled. No further actions can be performed, including adding samples, analyses, or editing any information.",
        ];
    }
}
