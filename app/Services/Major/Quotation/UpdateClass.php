<?php

namespace App\Services\Major\Quotation;

use Carbon\Carbon;
use App\Models\Quotation;
use App\Models\TsrSequence;

class UpdateClass
{
    public function save($request){
        $data = Quotation::where('id',$request->id)->first();
        $data->status_id = $request->status_id;
        $data->due_at = $request->due_at;
        $data->code = TsrSequence::getQuoCode(12);
        $data->terms = json_encode($request->terms);
        $data->save();
        return [
            'data' => $data,
            'message' => 'Quotation was successfully confirmed!', 
            'info' => "You've successfully updated the quotation status.",
        ];
    }

    public function cancel($request){
        $data = Quotation::find($request->id);
        $data->status_id = 17;
        $data->save();

        return [
            'data' => $data,
            'message' => 'Quotation Cancelled', 
            'info' => "Request has been cancelled. No further actions can be performed, including adding samples, analyses, or editing any information.",
        ];
    }

    public function quotation($request){
        $data = Quotation::where('id',$request->id)->first();
        $originalTime = Carbon::parse($data->created_at)->format('H:i:s');
        if($data->status_id == 14 || $data->status_id == 15){
            $data->customer_id = $request->customer['value'];
            $data->conforme_id = $request->conforme['value'];
            $data->purpose_id = $request->purpose_id;
            $data->created_at = Carbon::parse($request->created_at . ' ' . $originalTime);
            $data->laboratory_id = $request->laboratory_id;
            $data->release_id = $request->release_id;
            $data->discount_id = $request->discount_id;
            $data->save();
            if($data){
               $total = $this->updateTotal($request->id,$data->subtotal);
            }
            return [
                'data' => true,
                'message' => 'TSR was successfully updated!', 
                'info' => "You've successfully updated the tsr details.",
            ];
        }else{
            return [
                'data' => [],
                'message' => 'Action Not Allowed',
                'status' => false,
                'info' => 'This Quotation has already been processed and can no longer be modified.'
            ];
        }
    }

    private function updateTotal($id,$fee){
        $data = Quotation::with('discounted')->where('id',$id)->first();
        $subtotal = (float) trim(str_replace(',','',$data->subtotal),'₱ ');
        if($data->discount_id === 1){
            $discount = 0;
            $subtotal = $subtotal;
            $total = $subtotal;
        }else{
            $subtotal = $subtotal;
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
