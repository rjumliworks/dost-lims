<?php

namespace App\Services\Major\Analysis;

use App\Models\Tsr;
use App\Models\TsrService;
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

    public function service($request){
        $data = Tsr::findOrFail($request->id);
        $data->services()->create([
            'service_id' => $request->service['value'],
            'fee' => $request->service['fee'],
            'quantity' => $request->quantity,
            'total' => $request->total,
        ]);
        $total = $this->updateTotal($request->id,$request->total);
        return [
            'data' => $total,
            'message' => 'Additional Service Added Successfully', 
            'info' => "The selected service has been added and linked to this TSR as an add-on."
        ];
    }

     public function removeService($request){
        $data = TsrService::find($request->id);
        $fee = (float) trim(str_replace(',','',$data->total),'₱ ');
        if($data->delete()){
            $payment = TsrPayment::with('discounted')->where('tsr_id',$request->tsr_id)->first();
            $subtotal = (float) trim(str_replace(',','',$payment->subtotal),'₱ ');
            $total = (float) trim(str_replace(',','',$payment->total),'₱ ');
            if($payment->discount_id === 1){
                $discount = 0;
                $subtotal = $subtotal - $fee;
                $total = $total - $fee;
            }else{
                $subtotal = $subtotal - $fee;
                $discount = (float) (($payment->discounted->value/100) * $subtotal);
                $total =  ((float) $subtotal - (float) $discount);
            }
            $payment->subtotal = $subtotal;
            $payment->discount = $discount;
            $payment->total = $total;
            $payment->save();
        }

        return [
            'data' => $total,
            'message' => 'Additional Service Removed Successfully',
            'info' => 'The selected additional service has been removed from this TSR.'
        ];
    }

    public function fee($request){
        $data = TsrAnalysis::findOrFail($request->id);
        $grandTotal = 0;

        foreach($request->services as $service){
            $fee = str_replace(['₱', ','], '', $service['fee']);
            $quantity = $service['quantity'];
            $total = $fee * $quantity;
            $data->addfee()->create([
                'service_id' => $service['id'],
                'fee' => $fee,
                'total' => $total,
                'quantity' => $quantity,
                'is_additional' => 1
            ]);
            $grandTotal += $total;
        }
        $total = $this->updateTotal($request->tsr_id, $grandTotal);
        return [
            'data' => $total,
            'message' => 'Additional Fee Added Successfully', 
            'info' => "Additional fee has been added and linked to this TSR as an add-on."
        ];
    }

    public function removefee($request){
        $data= TsrService::where('id', $request->id)->where('is_additional', 1)->firstOrFail();
        $fee = (float) trim(str_replace(',','',$data->total),'₱ ');
        if($data->delete()){
            $service = TsrService::where('typeable_type','App\Models\TsrAnalysis')->where('typeable_id',$request->id)->first();
            $total_service = ($service) ? (float) trim(str_replace(',','',$service->total),'₱ ') : 0;
            $payment = TsrPayment::with('discounted')->where('tsr_id',$request->tsr_id)->first();
            $subtotal = (float) trim(str_replace(',','',$payment->subtotal),'₱ ');
            $total = (float) trim(str_replace(',','',$payment->total),'₱ ');
            if($payment->discount_id === 1){
                $discount = 0;
                $subtotal = $subtotal - $fee - $total_service;
                $total = $total - $fee - $total_service;
            }else{
                $subtotal = $subtotal - $fee - $total_service;
                $discount = (float) (($payment->discounted->value/100) * $subtotal);
                $total =  ((float) $subtotal - (float) $discount);
            }
            $payment->subtotal = $subtotal;
            $payment->discount = $discount;
            $payment->total = $total;
            $payment->save();
        }

        return [
            'data' => $total,
            'message' => 'Additional Fee removed Successfully', 
            'info' => "Additional fee has been remove and unlinked to this TSR as an add-on."
        ];
    }

    public function delete($request){
        $id = $request->id;
        $tsr_id = $request->tsr_id;
        $data = TsrAnalysis::find($id);
        $fee = (float) trim(str_replace(',','',$data->fee),'₱ ');
        if($data->delete()){
            $service = TsrService::where('typeable_type','App\Models\TsrAnalysis')->where('typeable_id',$id)->first();
            $total_service = ($service) ? (float) trim(str_replace(',','',$service->total),'₱ ') : 0;
            $payment = TsrPayment::with('discounted')->where('tsr_id',$tsr_id)->first();
            $subtotal = (float) trim(str_replace(',','',$payment->subtotal),'₱ ');
            $total = (float) trim(str_replace(',','',$payment->total),'₱ ');
            if($payment->discount_id === 1){
                $discount = 0;
                $subtotal = $subtotal - $fee - $total_service;
                $total = $total - $fee - $total_service;
            }else{
                $subtotal = $subtotal - $fee - $total_service;
                $discount = (float) (($payment->discounted->value/100) * $subtotal);
                $total =  ((float) $subtotal - (float) $discount);
            }
            $payment->subtotal = $subtotal;
            $payment->discount = $discount;
            $payment->total = $total;
            $payment->save();
        }
        return [
            'data' => $payment,
            'message' => 'Test service was removed successful!', 
            'info' => "You've successfully remove the sample."
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
