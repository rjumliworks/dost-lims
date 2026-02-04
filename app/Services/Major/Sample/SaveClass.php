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
            TsrSample::create($request->all());
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
}
