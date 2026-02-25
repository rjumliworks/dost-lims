<?php

namespace App\Http\Resources\Major\Testreport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'reference' => $this->reference,
            'code' => null,
            'sample_code' => $this->code,
            'tsr_code' => $this->tsr->code,
            'created_at' => null
        ]; 
    }
}
