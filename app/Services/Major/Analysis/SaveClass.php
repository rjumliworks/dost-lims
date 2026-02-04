<?php

namespace App\Services\Major\Analysis;

use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrPayment;
use App\Models\TsrAnalysis;

class SaveClass
{
    public function save($request){
        foreach($request->samples as $sample){
            foreach($request->lists as $list){
                $data = TsrAnalysis::create(array_merge($request->all(),[
                    'status_id' => 10,
                    'testservice_id' => $list['id'],
                    'fee' => $list['fee_num'],
                    'sample_id' => $sample
                ]));
                if(!$list['is_fixed']){
                    $id = TsrSample::where('id',$sample)->value('tsr_id');
                    $tsr = Tsr::where('id',$id)->update(['is_shelf' => 1]);
                }
                $data = TsrAnalysis::with('sample','testservice.method.method')->where('id',$data->id)->first();
                $total =  $this->updateTotal($data->sample->tsr_id,$list['fee']);
            }
        }
        return [
            'data' => $total,
            'message' => 'Analysis added was successful!', 
            'info' => "You've successfully created the new analysis."
        ];
    }

    private function updateTotal($id,$fee){
        $data = TsrPayment::with('discounted')->where('tsr_id',$id)->first();
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
        return $data;
    }
}
