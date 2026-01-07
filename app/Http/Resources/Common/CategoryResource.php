<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type->name,
            'category' => $this->type->category->name,
            'laboratory' => $this->type->category->laboratory->name,
            'is_active' => $this->is_active,
        ];
    }
}
