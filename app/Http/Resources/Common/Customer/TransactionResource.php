<?php

namespace App\Http\Resources\Common\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'amount' => $this->amount,
            'balance' => '₱'.number_format($this->balance,2,'.',','),
            'transacable' => $this->transacable,
            'is_credit' => $this->is_credit,
            'created_at' => $this->created_at
        ];
    }
}
