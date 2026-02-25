<?php

namespace App\Http\Resources\Major\Testreport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'reference' => $this->reference,
            'code' => $this->code,
            'sample_code' => $this->sample->code,
            'sample_id' => $this->sample->id,
            'tsr_code' => $this->sample->tsr->code,
            'analyses' => $this->sample->analyses,
            'user' => $this->user->profile->fullname,
            'lists' => $this->lists,
            'attachment' => json_decode($this->attachment),
            'signatories' => $this->signatories,
            'created_at' => $this->created_at
        ]; 
    }
}
