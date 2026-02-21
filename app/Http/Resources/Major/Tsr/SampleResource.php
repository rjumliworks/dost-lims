<?php

namespace App\Http\Resources\Major\Tsr;

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
            'is_completed' => $this->is_completed,
            'completed_at' => $this->completed_at,
            'is_disposed' => $this->is_disposed,
            'disposal' => new DisposalResource($this->disposal),
            'analyses' => AnalysisResource::collection($this->analyses),
            'report' => $this->report,
            'selected' => false,
            'tsr_id' => ($this->tsr) ? $this->tsr->id : null,
            'tsr_code' => ($this->tsr) ? $this->tsr->code : null,
            'due_at' => ($this->tsr) ? $this->tsr->due_at : null,
            'created_at' => ($this->tsr) ? $this->created_at : null
        ];
    }
}
