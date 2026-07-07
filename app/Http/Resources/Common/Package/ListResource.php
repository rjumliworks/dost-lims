<?php

namespace App\Http\Resources\Common\Package;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        //  return parent::toArray($request);
       return [
            'id' => $this->testservice->id,
            'is_checked' => false,
            'is_fixed' => $this->testservice->is_fixed,
            'value' => $this->testservice->id,
            'name' => $this->testservice->testname->name.' - '.$this->testservice->method->method->name.' ('.$this->testservice->method->reference->name.')',
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->method->name,
            'method_short' => $this->testservice->method->method->short,
            'reference' => $this->testservice->method->reference->name,
            'fee' => $this->testservice->method->fee,
            'fee_num' => trim(str_replace(',','',$this->testservice->method->fee),'₱'),
        ];
    }
}
