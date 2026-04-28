<?php

namespace App\Http\Resources\Customer\Quotation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConformeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'value' => $this->id,
            'name' => $this-> name,
            'contact_no' => $this->contact_no
        ];
    }
}
