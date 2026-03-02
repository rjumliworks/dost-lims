<?php

namespace App\Services\Major\Tsr;

use Carbon\Carbon;
use App\Models\Tsr;
use Hashids\Hashids;
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

    public function copy($request){
        $old = Tsr::with('payment','referral','services','samples.analyses.addfee')->where('id',$request->id)->first();
        $data = Tsr::create(array_merge($request->all(),[
            'customer_id' =>$old->customer_id,
            'conforme_id' => $old->conforme_id,
            'release_id' => $old->release_id,
            'purpose_id' => $old->purpose_id,
            'status_id' => 1,
            'laboratory_id' => $old->laboratory_id,
            'is_referral' => $old->is_referral,
            'is_onsite' => $old->is_onsite,
            'created_at'  => Carbon::now(),
        ]));
        
        $payment = (in_array($old->payment->discount_id, [5,6,7,10,11,12])) ? [
            'status_id' => 8,
            'is_free' => 1,
            'paid_at' => now()] : ['status_id' => 6];
        $data->payment()->create(array_merge([
            'discount_id' => $old->payment->discount_id,
            'total' => $old->payment->total,
            'subtotal' => $old->payment->subtotal,
            'discount' => $old->payment->discount
        ],$payment));
        if($old->is_referral){  
            $data->referral()->create([
                'is_psto' => $old->referral->is_psto, 
                'province_code' => $old->referral->province_code,
                'agency_id' => $old->referral->agency_id
            ]);
        }

        if(count($old->services) > 0){
            foreach($old->services as $service){
                $data->services()->create([
                    'fee' => $service->fee,
                    'total' => $service->total,
                    'quantity' => $service->quantity,
                    'service_id' => $service->service_id,
                    'is_additional' => $service->is_additional
                ]);
            }
        }

        foreach($old->samples as $sample){
            $s = $data->samples()->create([
                'name' => $sample->name,
                'samplename_id' => $sample->samplename_id,
                'sampletype_id' => $sample->sampletype_id,
                'category_id' => $sample->category_id,
                'customer_description' => $sample->customer_description,
                'description' => $sample->description,
            ]);
            foreach($sample->analyses as $analysis){
                $a = $s->analyses()->create([
                    'fee' => $analysis->fee,
                    'status_id' => 10,
                    'testservice_id' => $analysis->testservice_id
                ]);

               if ($analysis->addfee->isNotEmpty()) {
                    foreach ($analysis->addfee as $addfee) {
                        $a->addfee()->create([
                            'fee' => $addfee->fee,
                            'total' => $addfee->total,
                            'quantity' => $addfee->quantity,
                            'service_id' => $addfee->service_id,
                            'is_additional' => $addfee->is_additional
                        ]);
                    }
                }
            }
        }

        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($data->id);

        return [
            'data' => $code,
            'message' => 'TS Request creation was successful!', 
            'info' => "You've successfully created the new request."
        ];
    }
}
