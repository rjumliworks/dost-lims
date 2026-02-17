<?php

namespace App\Services\Finance\Op;

use App\Models\Tsr;
use App\Models\TsrPayment;
use App\Models\Customer;
use App\Models\FinanceOp;
use App\Models\FinanceSequence;

class SaveClass
{
    public function op($request){
        $payment_id = $request->payment_id;
        $collection_id = $request->collection_id;

        $code = FinanceSequence::getNextCode();

        $payor = Customer::where('id',$request->customer_id)->first();
        $op = $payor->payorable()->create(array_merge($request->all(), [
            'code' => $code,
            'status_id' => 6
        ]));
        $id = $op->id;
        if($op){
            $items = $request->selected;
            foreach($items as $item){
                $tsr = Tsr::findOrFail($item['id']);
                $opitem = $tsr->itemable()->create([
                    'amount' => $item['payment']['total'],
                    'op_id' => $id
                ]);
                if($opitem){
                    $payment = TsrPayment::where('tsr_id',$item['id'])->first();
                    $payment->collection_id = $collection_id;
                    $payment->payment_id = $payment_id;
                    $payment->save();
                }
            }
        }
        $op = FinanceOp::findOrFail($op->id);

        return [
            'data' => $op,
            'message' => 'Op creation was successful!', 
            'info' => "You've successfully created the new op."
        ];
    }

}
