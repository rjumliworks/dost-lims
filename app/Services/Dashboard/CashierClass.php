<?php

namespace App\Services\Dashboard;

use App\Models\FinanceReceipt;
use App\Models\FinanceOrseries;
use App\Http\Resources\Finance\ReceiptResource;

class CashierClass
{
    public function __construct()
    {
        $this->agency = (\Auth::check()) ? (count(\Auth::user()->myroles) > 0) ? \Auth::user()->myroles[0]->agency_id : null : null;
    }
    
    public function orseries(){
        $data = FinanceOrseries::where('is_active',1)
        // ->where('user_id',\Auth::user()->id)
        ->when($this->agency != 14, function ($query) {
            $query->where('user_id', \Auth::user()->id);
        })
        // ->when(true, function ($query) {
            
        // })
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'start' => $item->start,
                'next' => $item->next,
                'end' => $item->end
            ];
        });

        return $data;
    }

    public function receipts(){
        $data = ReceiptResource::collection(
            FinanceReceipt::query()
            ->with('op.items.itemable')
            ->with('createdby:id','createdby.profile:id,firstname,lastname,user_id')
            ->with('op.payorable','op.collection','op.payment')
            ->with('detail','transaction')
            ->orderBy('updated_at','DESC')
            ->where('is_cancelled',0)
            ->limit(5)->get()
        );
        return $data;
    }
}
