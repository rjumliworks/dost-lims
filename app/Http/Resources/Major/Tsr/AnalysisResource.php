<?php

namespace App\Http\Resources\Major\Tsr;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalysisResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fee' => $this->fee,
            'is_refunded' => $this->is_refunded,
            'remarkable' => $this->remarkable,
            'selected' => false,
            'status' => $this->status,
            'code' => $this->sample->code,
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->method->name,
            'method_short' => $this->testservice->method->method->short,
            'reference' => $this->testservice->method->reference->name,
            'started' => ($this->started) ? $this->started->profile->firstname.' '.$this->started->profile->lastname : '-',
            'ended' => ($this->ended) ? $this->ended->profile->firstname.' '.$this->ended->profile->lastname : '-',
            'started_id' => ($this->started) ? $this->started->id : null,
            'ended_id' => ($this->ended) ? $this->ended->id : null,
            'additional' => $this->testservice->fees,
            'addfee' => $this->addfee,
            'is_fixed' => $this->is_fixed,
            'start_at' => ($this->start_at != 'Jan 01, 1970') ? $this->start_at : '-',
            'end_at' => ($this->end_at != 'Jan 01, 1970') ? $this->end_at : '-',
            'created_at' => $this->created_at
        ];
    }
}
