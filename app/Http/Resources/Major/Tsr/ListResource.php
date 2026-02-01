<?php

namespace App\Http\Resources\Major\Tsr;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'code' => $this->code,
            'is_onsite' => $this->is_onsite,
            'is_referral' => $this->is_referral,
            'laboratory' => $this->laboratory,
            'status' => $this->status,
            'customer' => ($this->customer->customer_name->has_branches) ? ($this->customer->is_main) ? $this->customer->customer_name->name :  $this->customer->customer_name->name.' - '.$this->customer->name : $this->customer->customer_name->name,
            'payment' => $this->payment,
            'due_at' => $this->due_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
