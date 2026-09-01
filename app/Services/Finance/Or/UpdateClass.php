<?php

namespace App\Services\Finance\Or;

use App\Models\Tsr;
use App\Models\TsrPayment;
use App\Models\FinanceOp;
use App\Models\FinanceReceipt;
use App\Models\FinanceReceiptDetail;
use App\Models\ListDropdown;

class UpdateClass
{
    public function detail($request){
        $or = FinanceReceiptDetail::where('id',$request->id)->first();
        $or->bank = $request->bank;
        $or->number = $request->number;
        $or->amount = $request->amount;
        $or->date_at = $request->date_at;
        $or->save();

        return [
            'data' => $or,
            'message' => 'Payment Details Updated',
            'info' => 'The payment details were successfully updated.'
        ];
    }

    public function op($request){
        $op = FinanceOp::find($request->op_id);
        $op->payment_id = $request->payment_id;
        $op->collection_id = $request->collection_id;
        $op->save();

        $payment = ListDropdown::find($request->payment_id);
        $needsDetail = $payment && in_array($payment->name, ['Cheque', 'Online Transfer', 'Bank Deposit']);

        if($needsDetail){
            $detail = FinanceReceiptDetail::where('receipt_id', $request->receipt_id)->first();
            if(!$detail){
                $detail = new FinanceReceiptDetail;
                $detail->receipt_id = $request->receipt_id;
            }
            $detail->bank = $request->details_bank;
            $detail->number = $request->details_number;
            $detail->amount = $request->details_amount;
            $detail->date_at = $request->details_date_at;
            $detail->is_cheque = ($payment->name === 'Bank Deposit') ? (bool) $request->details_is_cheque : false;
            $detail->save();
        }

        return [
            'data' => $op,
            'message' => 'Official Receipt Updated',
            'info' => 'The payment type, nature of collection, and payment details have been updated.'
        ];
    }

    public function cancel($request){
        $id = $request->id;
        $data = FinanceReceipt::find($id);
        $data->is_cancelled = 1;
        if($data->save()){
            $cancel = $data->remarkable()->create([
                'reason' => $request->reason,
                'type_id' => 85,
                'user_id' => \Auth::user()->id
            ]);

            $op = FinanceOp::with('items')->where('id',$data->op_id)->first();
            $op->status_id = 6;
            if($op->save()){
                 foreach($op->items as $item){
                    $id = $item['itemable_id'];
                    $payment = TsrPayment::where('tsr_id',$id)->first();
                    $payment->or_number = null;
                    $payment->is_paid = 0;
                    $payment->paid_at = null;
                    $payment->status_id = 6;
                    if($payment->save()){
                        $tsr = Tsr::where('id',$id)->first();
                        $tsr->status_id = 2;
                        $tsr->save();
                    }
                }
            }
        }
        
        return [
            'data' => $data,
            'message' => 'Official Receipt Cancelled', 
            'info' => 'The Official Receipt has been successfully cancelled. The receipt number is now void and cannot be reused. The series will continue sequentially, and no further modifications can be made to this record.',
        ];
    }
}
