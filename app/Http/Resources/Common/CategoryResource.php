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
            'type_id' => $this->type->id,
            'category' => $this->type->category->name,
            'category_id' => $this->type->category->id,
            'laboratory' => $this->type->category->laboratory->name,
            'laboratory_id' => $this->type->category->laboratory->id,
            'is_active' => $this->is_active,
        ];
    }
}
