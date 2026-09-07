<?php

namespace App\Http\Resources\Executive\Customer;

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
            'name' => $this->fullname,
            'is_active' => $this->is_active,
            'agency' => $this->agency,
            'address' => $this->address ? [
                'region' => $this->address->region,
                'province' => $this->address->province,
            ] : null,
            'created_at' => $this->created_at,
        ];
    }
}
