<?php

namespace App\Http\Resources\Public\Verification;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Major\Tsr\CustomerResource;

class TsrResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'qr' => $this->reference,
            'code' => $this->code,
            'laboratory' => $this->laboratory,
            'laboratory_type' => $this->laboratory_type,
            'status' => $this->status,
            'customer' => new CustomerResource($this->customer),
            'conforme' => $this->conforme->name, 
            'conforme_no' => $this->conforme->contact_no, 
            'received' => $this->received->profile->firstname.' '.$this->received->profile->lastname,
            'payment' => $this->payment,
            'due_at' => $this->due_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
