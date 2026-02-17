<?php

namespace App\Services\Finance\Or;

use App\Models\Wallet;
use App\Models\TsrPayment;
use App\Models\FinanceOp;
use App\Models\FinanceName;
use App\Models\FinanceItem;
use App\Models\FinanceOrseries;
use App\Models\FinanceReceipt;
use App\Models\FinanceReceiptDetail;
use App\Models\FinanceSequence;

class SaveClass
{
    public function or($request){
        if($request->option == 'receipt'){
            return $this->lab($request);
        }else{
            return $this->nonlab($request);
        }
    }

    private function lab($request){
        $result = \DB::transaction(function () use ($request){
            \DB::beginTransaction();
            $data = FinanceReceipt::create([
                'number' => $request->orseries['next'],
                'orseries_id' => $request->orseries['value'],  
                'op_id' => $request->selected['id'],
                // 'payor_id' => $request->selected['customer_id'],
                'deposit_id' => $request->deposit_id,
                'created_by' => \Auth::user()->id,
                'agency_id' => \Auth::user()->myroles[0]->agency_id
            ]);
            if($data){
                $items = $request->selected['items'];
                $op = FinanceOp::where('id',$request->selected['id'])->first();
                $op->status_id = 7;
                if($op->save()){
                    foreach($items as $item){
                        $id = $item['itemable_id'];
                        $payment = TsrPayment::where('tsr_id',$id)->first();
                        $payment->or_number = $request->orseries['next'];
                        $payment->is_paid = 1;
                        $payment->paid_at = now();
                        $payment->status_id = 7;
                        if($payment->save()){
                            $tsr = Tsr::where('id',$id)->first();
                            $tsr->status_id = 3;
                            $tsr->save();
                        }
                    }

                    $or = FinanceOrseries::where('id',$request->orseries['value'])->first();
                    if($or->next == $or->end){
                        $or->is_active = 0;
                        $or->is_finished = 1;
                    }else{
                        $next = $or->next+1;
                        $or->next = $next;
                    }
                    if($or->save()){
                        if($request->type === 'Cheque' || $request->type === 'Online Transfer' || $request->type === 'Bank Deposit'){
                            $cheque = new FinanceReceiptDetail;
                            $cheque->amount = $request->details_amount;
                            $cheque->bank = $request->details_bank;
                            $cheque->date_at = $request->details_date_at;
                            $cheque->is_cheque = ($request->type === 'Bank Deposit') ? $request->details_is_cheque : false;
                            $cheque->receipt_id = $data->id;
                            if($op->payment_id == 22){
                                $cheque->number = $request->details_number.'-DUP-'.uniqid();
                            }else{
                                $cheque->number = $request->details_number;
                            }
                            if($cheque->save()){
                                $amount = trim(str_replace(',','',$request->details_amount),'₱');
                                $total = trim(str_replace(',','',$request->total),'₱');
                                
                                if($amount > $total){
                                    $total = $amount - $total;
                                    $customer_id = $request->selected['customer_id'];
                                    $op->total = (float) str_replace(',', '', trim($op->total, '₱ ')) + (float) str_replace(',', '', trim($total, '₱ ')); 
                                    $op->save();
                                    $wallet = Wallet::where('customer_id',$customer_id)->first();
                                    if($wallet){
                                        $wallet->total = $wallet->total + $total;
                                        $wallet->available = trim(str_replace(',','',$wallet->available),'₱') + $total;
                                        if($wallet->save()){
                                            $data->transaction()->create([
                                                'code' => date('Ymdgia'),
                                                'amount' => $total,
                                                'balance' => trim(str_replace(',','',$wallet->available),'₱'),
                                                'is_credit' => 1,
                                                'wallet_id' => $wallet->id
                                            ]);
                                            \DB::commit();  
                                        }else{
                                            $data = 'error';
                                            \DB::rollback();
                                        }
                                    }else{
                                        $wallet = new Wallet;
                                        $wallet->total = $total;
                                        $wallet->available = $total;
                                        $wallet->customer_id = $customer_id;
                                        if($wallet->save()){
                                            $data->transaction()->create([
                                                'code' => date('Ymdgis'),
                                                'amount' => $total,
                                                'balance' => $total,
                                                'is_credit' => 1,
                                                'wallet_id' => $wallet->id
                                            ]);
                                            \DB::commit();  
                                        }else{
                                            $data = 'error';
                                            \DB::rollback();
                                        }
                                    }
                                }else{
                                    \DB::commit();  
                                }
                            }else{
                                $data = 'error';
                                \DB::rollback();
                            }
                        }else{
                            \DB::commit();  
                        }
                    }else{
                        $data = 'error';
                        \DB::rollback();
                    }
                }else{
                    $data = 'error';
                    \DB::rollback();
                }
            }
            return ['data' => $data];
        });

        return [
            'data' => $result['data'],
            'message' => 'Receipt creation was successful!', 
            'info' => "You've successfully created the new receipt."
        ];
    }

    private function nonlab($request){
      
        $result = \DB::transaction(function () use ($request){
            \DB::beginTransaction();
            $payor = FinanceName::where('id',$request->customer_id)->first();
            $op = $payor->payorable()->create(array_merge($request->all(), [
                'code' => FinanceSequence::getNextCode(),
                'total' => 0,
                'status_id' => 7,
                'created_by' => \Auth::user()->id,
                'agency_id' => \Auth::user()->myroles[0]->agency_id
            ]));
            if($op){
                $items = $request->items;
                $total = 0;
                foreach($items as $item){
                    $i = FinanceItem::create([
                        'name' => $item['name'],
                        'amount' => $item['amount']
                    ]);
                    if($i){
                        $d = $i->itemable()->create([
                            'amount' => $item['amount'],
                            'op_id' => $op->id
                        ]);
                    }
                    $total = $total +  trim(str_replace(',','',$item['amount']),'₱');
                }
                $op->total = $total;
                $op->save();

                $receipt = FinanceReceipt::create(array_merge($request->all(), [
                    'number' => $request->orseries['next'],
                    'orseries_id' => $request->orseries['value'],  
                    'op_id' => $op->id,
                    // 'payor_id' => $request->customer_id,
                    'deposit_id' => $request->deposit_id,
                    'created_by' => \Auth::user()->id,
                    'agency_id' => \Auth::user()->myroles[0]->agency_id
                ]));
                if($receipt){
                    $or = FinanceOrseries::where('id',$request->orseries['value'])->first();
                    if($or->next == $or->end){
                        $or->is_active = 0;
                    }else{
                        $next = $or->next+1;
                        $or->next = $next;
                    }

                    if($or->save()){
                        
                        if($request->type === 'Cheque' || $request->type === 'Online Transfer' || $request->type === 'Bank Deposit'){
                            $details = new FinanceReceiptDetail;
                            $details->number = $request->details_number;
                            $details->amount = $request->details_amount;
                            $details->bank = $request->details_bank;
                            $details->date_at = $request->details_date_at;
                            $details->is_cheque = ($request->type === 'Bank Deposit') ? $request->details_is_cheque : false;
                            $details->receipt_id = $receipt->id;
                            $details->save();
                            \DB::commit();  
                        }else{
                            \DB::commit();  
                        }
                    }
                }else{
                    $data = 'error';
                    \DB::rollback();
                }
                
            }
            return ['data' => $op];
        });

        return [
            'data' => $result['data'],
            'message' => 'Receipt creation was successful!', 
            'info' => "You've successfully created the new receipt."
        ];
    }
}
