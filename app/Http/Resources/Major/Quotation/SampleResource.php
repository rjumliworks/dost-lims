<?php

namespace App\Http\Resources\Major\Quotation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SampleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'name' => $this->name,
            'sample' => $this->sample,
            'customer_description' => $this->customer_description,
            'description' => $this->description,
            'analyses' => AnalysisResource::collection($this->analyses),
            'created_at' => $this->created_at,
            'selected' => false
        ];
    }
}
