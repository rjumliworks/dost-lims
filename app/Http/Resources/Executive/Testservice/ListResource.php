<?php

namespace App\Http\Resources\Executive\Testservice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'is_active' => $this->is_active,
            'testname' => $this->testname,
            'laboratory' => $this->laboratory,
            'status' => $this->status,
            'agency' => $this->agency,
            'address' => $this->agency?->address ? [
                'region' => $this->agency->address->region,
                'province' => $this->agency->address->province,
            ] : null,
            'created_at' => $this->created_at,
        ];
    }
}
