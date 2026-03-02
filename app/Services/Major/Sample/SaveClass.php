<?php

namespace App\Services\Major\Sample;

use App\Models\TsrSample;
use App\Models\TsrPayment;
use App\Services\Major\Sample\ReportClass;

class SaveClass
{
    public function __construct(ReportClass $report)
    {
        $this->report = $report;
    }

    public function save($request){
        $count = (int) $request->count;
        for ($i = 0; $i < $count; $i++) {
            $sample = TsrSample::create($request->all());
            if($request->include_testservices){
                $old_sample = TsrSample::with('analyses.addfee')->where('id',$request->id)->first();
                foreach($old_sample->analyses as $analysis){
                    $a = $sample->analyses()->create([
                        'fee' => $analysis->fee,
                        'status_id' => 10,
                        'testservice_id' => $analysis->testservice_id
                    ]);
                    $total =  $this->updateTotal($sample->tsr_id,$analysis->fee);
                    if($analysis->addfee->isNotEmpty()) {
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
        }
        
        return [
            'data' => true,
            'message' => 'Sample Added Successfully', 
            'info' => "The sample has been added and is now linked to this TSR."
        ];
    }

    public function update($request){
        $data = TsrSample::findOrFail($request->id);
        $data->name = $request->name;
        $data->samplename_id = (int) $request->samplename_id;
        $data->sampletype_id = (int) $request->sampletype_id;
        $data->category_id = (int) $request->category_id;
        $data->customer_description = $request->customer_description;
        $data->description = $request->description;
        if($data->save()){
            $this->report->update($data->tsr_id);
        }
        return [
            'data' => $data->toArray(),
            'message' => 'Sample Updated Successfully', 
            'info' => "The sample details have been updated and saved to the TSR."
        ];
    }

    public function delete($request){
        $id = $request->id;
        $tsr_id = $request->tsr_id;
        $data = TsrSample::find($id);
        $fee = $data->analyses()->sum('fee');
        if($data->delete()){
            $payment = TsrPayment::with('discounted')->where('tsr_id',$tsr_id)->first();
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
            'data' => $payment,
            'message' => 'Sample Deletion Successful', 
            'info' => "The selected sample has been deleted successfully and is no longer linked to this TSR."
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
