<?php

namespace App\Http\Resources\Common;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestserviceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'code' => $code,
            'id' => $this->id,
            'typeable_id' => $this->typeable_id,
            'is_fixed' => $this->is_fixed,
            'is_active' => $this->is_active,
            'testname' => $this->testname,
            'method' => $this->method,
            'reference' => $this->reference,
            'fee' => $this->fee,
            'added' => $this->added,
            'status' => $this->status,
            'laboratory' => $this->laboratory,
            'added' => $this->added,
            'fees' => $this->fees,
            'samples' => $this->samples,
            'created_at' => $this->created_at
        ];
    }
}
