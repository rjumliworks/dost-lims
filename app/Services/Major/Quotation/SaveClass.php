<?php

namespace App\Services\Major\Quotation;

use App\Models\Quotation;
use App\Models\QuotationSample;

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
        $quotation = Quotation::create(array_merge(
            $request->quotationData(),
        ));

        if($request->is_referral){
            $quotation->createReferral($request->referralData());
        }
       
        $quotation = Quotation::find($quotation->id);
        return [
            'data' => $quotation->reference,
            'message' => 'Quotation creation was successful!', 
            'info' => "You've successfully created the new quotation."
        ];
    }

    public function sample($request){
        $count = (int) $request->count;
        for ($i = 0; $i < $count; $i++) {
            QuotationSample::create($request->all());
        }
        
        return [
            'data' => true,
            'message' => 'Sample Added Successfully', 
            'info' => "The sample has been added and is now linked to this TSR."
        ];
    }
}
