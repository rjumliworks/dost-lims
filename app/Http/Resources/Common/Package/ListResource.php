<?php

namespace App\Http\Resources\Common\Package;

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
            'id' => $this->testservice->id,
            'is_fixed' => $this->testservice->is_fixed,
            'is_active' => $this->testservice->is_active,
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->method->name,
            'method_short' => ($this->testservice->method->method->short) ? $this->testservice->method->method->short : '',
            'reference' => $this->testservice->method->reference->name,
            'fee' => $this->testservice->method->fee,
            'status' => $this->testservice->status,
            'created_at' => $this->testservice->created_at
        ];
    }
}
