<?php

namespace App\Http\Resources\Major\Quotation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalysisResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fee' => $this->fee,
            'selected' => false,
            'status' => $this->status,
            'code' => $this->sample->code,
            'sampletype' => $this->sample?->sampletype->name,
            'samplename' => $this->sample?->samplename->name,
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->method->name,
            'reference' => $this->testservice->method->reference->name,
            'additional' => $this->testservice->fees,
            'addfee' => $this->addfee,
            'is_fixed' => $this->is_fixed,
            'created_at' => $this->created_at
        ];
    }
}
