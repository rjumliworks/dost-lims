<?php

namespace App\Http\Resources\Common\Testservice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'typeable_id' => $this->typeable_id,
            'is_fixed' => $this->is_fixed,
            'is_active' => $this->is_active,
            'testname' => $this->testname,
            'method' => $this->method,
            'reference' => $this->reference,
            'fee' => $this->fee,
            'status' => $this->status,
            'laboratory' => $this->laboratory,
            'samples' => $this->samples,
            'created_at' => $this->created_at
        ];
    }
}
