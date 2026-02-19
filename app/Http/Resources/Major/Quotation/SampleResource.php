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
            'code' => $this->code,
            'name' => $this->name,
            'sampletype' => $this->sampletype, 
            'samplename' => $this->samplename, 
            'category' => $this->category, 
            'customer_description' => $this->customer_description,
            'description' => $this->description,
            'analyses' => AnalysisResource::collection($this->analyses),
            'selected' => false,
            'quotation_id' => ($this->quotation) ? $this->quotation->id : null,
            'created_at' => ($this->quotation) ? $this->created_at : null
        ];
    }
}
