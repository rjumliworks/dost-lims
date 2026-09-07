<?php

namespace App\Http\Resources\Executive\Tsr;

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
            'customer' => $this->customer?->customer_name
                ? (($this->customer->customer_name->has_branches && ! $this->customer->is_main)
                    ? $this->customer->customer_name->name.' - '.$this->customer->name
                    : $this->customer->customer_name->name)
                : null,
            'agency' => $this->agency,
            'facility' => $this->facility ? [
                'id' => $this->facility->id,
                'name' => $this->facility->name,
                'region' => $this->facility->region,
            ] : null,
            'due_at' => $this->due_at,
            'created_at' => $this->created_at,
        ];
    }
}
