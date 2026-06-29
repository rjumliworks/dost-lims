<?php

namespace App\Services\Major\Quotation;

use Carbon\Carbon;
use App\Models\UserRole;
use App\Models\Quotation;
use App\Models\QuotationSample;
use App\Models\QuotationReferral;
use App\Models\TsrSequence;

class UpdateClass
{
    public function save($request){
        $data = Quotation::where('id',$request->id)->first();
        $data->status_id = $request->status_id;
        $data->due_at = $request->due_at;
        $data->code = TsrSequence::getQuoCode(12);
        $data->terms = json_encode($request->terms);
        if($data->save()){
            $data->signatory()->create([
                'prepared_by' => \Auth::user()->id,
                'prepared_date' => now(),
                'approved_by' => UserRole::where('laboratory_id',$data->laboratory_id)->whereHas('role',function ($query){
                    $query->where('name','Technical Manager');
                })->where('is_active',1)->value('user_id')
            ]);
        }
        
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

     public function edit($request){
        $data = QuotationSample::findOrFail($request->id);
        $data->name = $request->name;
        $data->samplename_id = (int) $request->samplename_id;
        $data->sampletype_id = (int) $request->sampletype_id;
        $data->category_id = (int) $request->category_id;
        $data->customer_description = $request->customer_description;
        $data->description = $request->description;
        $data->save();
        
        
        return [
            'data' => $data,
            'message' => 'Sample Updated Successfully', 
            'info' => "The sample details have been updated and saved to the TSR."
        ];
    }

    public function referral($request){
        $data = QuotationReferral::where('id',$request->id)->first();
        $data->agency_id = $request->agency_id;
        $data->province_code = $request->province_code;
        $data->is_psto = ($request->province_code) ? 1 : 0; 
        $data->save();

        return [
            'data' => $data,
            'message' => 'Referral Updated Successfully', 
            'info' => "The referral details have been updated and saved to the TSR."
        ];
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
