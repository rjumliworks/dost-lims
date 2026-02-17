<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TsrNoPaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'code' => $this->code,
            'customer' => new CustomerResource($this->customer),
            'payment' => $this->payment,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
