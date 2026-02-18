<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NonlabResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $customer = $this->payorable->name;
        $created = $this->createdby->profile->firstname.' '.$this->createdby->profile->middlename[0].'. '.$this->createdby->profile->lastname;
        
        
        if($this->payment->name == 'Cash' || $this->payment->name == 'Wallet'){
            $amount = $this->total;
            $excess = '-';
        }else{
            $amount = $this->activeReceipt->detail->amount;
            if($this->activeReceipt->wallet){
                $excess = $this->activeReceipt->wallet->amount;
            }else{
                $excess = '-';
            }
        }

        return [
            'id' => $this->id,
            'or_id' => $this->activeReceipt->id,
            'date' => $this->created_at,
            'opnumber' => $this->code,
            'customer' => $customer,
            'ornumber' => $this->activeReceipt->number,
            'collection' => $this->collection->name,
            'payment' => $this->payment->name,
            'status' => $this->status,
            'items' => $this->items,
            'detail' => $this->activeReceipt->detail,
            'transaction' => $this->activeReceipt->wallet,
            'excess' => $excess,
            'opamount' => $this->total,
            'oramount' => $amount,
            'created' => $created
        ];
    }
}
