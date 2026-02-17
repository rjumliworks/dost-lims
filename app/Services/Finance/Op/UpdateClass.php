<?php

namespace App\Services\Finance\Op;

use App\Models\TsrPayment;
use App\Models\FinanceOp;
use App\Models\FinanceOpItem;

class UpdateClass
{
    public function remove($request){
        $op = FinanceOp::with('items')->where('id',$request->op_id)->first();
        if($op->status_id == 6){
            if(count($op->items) == 1){
                return [
                    'data' => [],
                    'status' => false,
                    'message' => 'Removal Not Allowed',
                    'info' => 'At least one TSR must remain in the Order of Payment. You cannot remove the last item.'
                ];
            }else{
                $data = FinanceOpItem::find($request->id);
                $amount = (float) trim(str_replace(',','',$data->amount),'₱ ');
                // dd($op->total);
                if ($data->delete()) {
                    $op->total = (float) trim(str_replace(',','',$op->total),'₱ ') - $amount;
                    $op->save();
                    
                    $tsrPayment = TsrPayment::where('tsr_id', $request->tsr_id)->first();
                    if ($tsrPayment) {
                        $tsrPayment->payment_id = null;
                        $tsrPayment->collection_id = null;
                        $tsrPayment->save();
                    }
                }

                return [
                    'data' => [],
                    'message' => 'TSR Removed from Order of Payment',
                    'info' => 'The selected TSR has been removed from the Order of Payment, and the total has been adjusted accordingly.'
                ];
            }
        }else{
            return [
                'data' => [],
                'message' => 'Action Not Allowed',
                'status' => false,
                'info' => 'This Order of Payment has already been processed and can no longer be modified.'
            ];
        }
    }
}
