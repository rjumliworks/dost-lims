<?php

namespace App\Http\Resources\Common\Package;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'code' => $code,
            'id' => $this->id,
            'name' => $this->name,
            'laboratory' => $this->laboratory,
            'testservices' => ListResource::collection($this->testservices),
            'is_active' => $this->is_active,
            'created_at' => $this->created
        ];
    }
}
