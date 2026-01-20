<?php

namespace App\Http\Resources\Common\Testservice;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'code' => $code,
            'id' => $this->id,
            'is_fixed' => $this->is_fixed,
            'is_active' => $this->is_active,
            'testname' => $this->testname->name,
            'method' => $this->method->method->name,
            'method_short' => ($this->method->method->short) ? $this->method->method->short : '',
            'reference' => $this->method->reference->name,
            'fee' => $this->method->fee,
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
