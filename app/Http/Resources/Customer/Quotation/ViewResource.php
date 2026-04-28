<?php

namespace App\Http\Resources\Customer\Quotation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
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
            'code' => $this->code,
            'total' => $this->total,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'discounted' => $this->discounted,
            'laboratory' => $this->laboratory,
            'agency' => $this->agency,
            'status' => $this->status,
            'customer' => new CustomerResource($this->customer),
            'samples' => SampleResource::collection($this->samples),
            'conforme' => $this->conforme->name, 
            'conforme_id' => $this->conforme->id, 
            'conforme_no' => $this->conforme->contact_no, 
            'payment' => $this->payment,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
