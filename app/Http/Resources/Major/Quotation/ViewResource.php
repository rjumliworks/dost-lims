<?php

namespace App\Http\Resources\Major\Quotation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'code' => $this->code,
            'total' => $this->total,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'discounted' => $this->discounted,
            'laboratory' => $this->laboratory,
            'agency' => $this->agency,
            'facility' => $this->facility,
            'status' => $this->status,
            'customer' => new CustomerResource($this->customer),
            'samples' => SampleResource::collection($this->samples),
            'conforme' => $this->conforme->name, 
            'mode' => $this->mode,
            'release' => $this->release,
            'conforme_id' => $this->conforme->id, 
            'conforme_no' => $this->conforme->contact_no, 
            'received' => $this->received->profile->firstname.' '.$this->received->profile->lastname,
            'has_parent' => ($this->parent) ? true : false,
            'payment' => $this->payment,
            'purpose' => $this->purpose,
            'due_at' => $this->due_at,
            'addfee' => $this->addfee,
            'is_onsite' => $this->is_onsite,
            'services' => $this->services,
            'referral' => $this->referral,
            'terms' => json_decode($this->terms,true),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
