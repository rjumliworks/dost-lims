<?php

namespace App\Services\Finance\Op;

use App\Models\Tsr;
use App\Models\TsrPayment;
use App\Models\FinanceOp;
use App\Models\FinanceOpItem;
use App\Http\Resources\Finance\Tsr\ListResource;

class IndexClass
{
    public function __construct()
    {
        $this->facility =(\Auth::check()) ? \Auth::user()->profile?->facility_id : null;
    }

    public function tsrs($request){
        $data = ListResource::collection(
            Tsr::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('payment:tsr_id,id,total,subtotal,discount,or_number,is_paid,paid_at,status_id','payment.status:id,name,color,others')
            ->whereHas('payment',function ($query){
                $query->where('is_paid', 0)->where('payment_id',null)->where('collection_id',null)->whereIn('status_id',[6,18]);
            })
            ->whereIn('status_id',[2,3,4])
            ->whereIn('customer_id',$request->customer_id)
             ->when($this->facility, function ($query) {
                $query->where('facility_id', $this->facility);
            })
            ->orderBy('created_at','DESC')
            ->get()
        );
        return $data;
    }

    public function update($request){
        $id = $request->id;
        $data = FinanceOp::find($id);
        if($data->status_id == 6){
            $data->payment_id = $request->payment_id;
            $data->collection_id = $request->collection_id;
            $data->save();
            $data = FinanceOp::with('collection:id,name','payment:id,name,others')->where('id',$request->id)->first();
            $message ='Op update was successful!';
            $info =  "You've successfully updated the op.";
            $status = true;
        }else{
            $data = null;
            $message = 'OP was already processed';
            $info =  "Please contact administrator";
            $status = 'error';
        }
        return [
            'data' => $data,
            'message' => $message, 
            'info' => $info,
            'status' => $status,
        ];
    }

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
