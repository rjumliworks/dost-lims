<?php

namespace App\Http\Resources\Major\Analysis;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalysisResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_checked' => false,
            'started_by' => $this->started_by,
            'value' => $this->id,
            'name' => $this->testservice->testname->name.' - '.$this->testservice->method->method->name.' ('.$this->testservice->method->reference->name.')',
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->method->name,
            'method_short' => $this->testservice->method->method->short,
            'reference' => $this->testservice->method->reference->name,
            'status' => $this->status,
            'fee' => $this->fee,
            'fee_num' => trim(str_replace(',','',$this->fee),'₱'),
        ];
    }
}
