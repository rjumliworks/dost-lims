<?php

namespace App\Http\Resources\Executive;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgencyResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'short' => $this->code,
            'name' => $this->name,
            'member_since' => $this->member_since,
            'contact_no' => $this->contact_no,
            'is_active' => $this->is_active,
            'member' => $this->member,
            'type' => $this->type,
            'fees' => $this->fees,
            'discounts' => $this->discounts,
            'address' => $this->address,
            'facilities' => $this->facilities,
            'configuration' => $this->configuration,
        ];
    }
}
