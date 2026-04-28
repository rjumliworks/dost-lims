<?php

namespace App\Services\Customer\Quotation;

use App\Models\CustomerQuotation;
use App\Models\CustomerQuotationSample;
use App\Models\CustomerQuotationSampleAnalysis;

class SaveClass
{
    public function sample($request){
        $count = (int) $request->count;
        for ($i = 0; $i < $count; $i++) {
            CustomerQuotationSample::create($request->all());
        }
        
        return [
            'data' => true,
            'message' => 'Sample Added Successfully', 
            'info' => "The sample has been added and is now linked to this TSR."
        ];
    }

     public function analysis($request){
        foreach($request->samples as $sample){
            foreach($request->lists as $list){
                $data = CustomerQuotationSampleAnalysis::create(array_merge($request->all(),[
                    'testservice_id' => $list['id'],
                    'fee' => $list['fee_num'],
                    'sample_id' => $sample
                ]));
                $data = CustomerQuotationSampleAnalysis::with('sample','testservice.method.method')->where('id',$data->id)->first();
                $total =  $this->updateTotal($data->sample->quotation_id,$list['fee']);
            }
        }
        return [
            'data' => $total,
            'message' => 'Analysis added was successful!', 
            'info' => "You've successfully created the new analysis."
        ];
    }

    private function updateTotal($id,$fee){
        $data = CustomerQuotation::with('discounted')->where('id',1)->first();
        $fee = (float) trim(str_replace(',','',$fee),'₱ ');
        $subtotal = (float) trim(str_replace(',','',$data->subtotal),'₱ ');
        if($data->discount_id === 1){
            $discount = 0;
            $subtotal = $subtotal + $fee;
            $total = $subtotal;
        }else{
            $subtotal = $subtotal + $fee;
            $discount = (float) (($data->discounted->value/100) * $subtotal);
            $total =  ((float) $subtotal - (float) $discount);
        }
        $data->subtotal = $subtotal;
        $data->discount = $discount;
        $data->total = $total;
        $data->save();
        return $data->total;
    }
}
