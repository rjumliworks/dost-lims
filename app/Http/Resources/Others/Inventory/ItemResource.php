<?php

namespace App\Http\Resources\Others\Inventory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $onhand = (int) ($this->onhand ?? 0);
        $img = ($onhand === 0) ? '/images/avatars/outofstock2.jpg' : '/images/avatars/stock.jpg';
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'name' => $this->name,
            'img' => $img,
            'code' => $this->code,
            'old_code' => $this->old_code,
            'reorder' => $this->reorder,
            'unit' => $this->unittype->name,
            'unit_id' => $this->unit_id,
            'is_active' => $this->is_active,
            'onhand' => $onhand,
            'stock' => ($this->stock ) ?  $this->formatNumber($this->stock) : 0,
            'category' => ($this->category) ? $this->category->name : 'Not Specified',
            'category_id' => $this->category_id,
            'laboratory' => ($this->laboratory) ? $this->laboratory->name : 'Not Specified',
            'laboratory_id' => $this->laboratory_id,
            'stocks' => StockResource::collection($this->whenLoaded('stocks')),
            'created_at' => $this->created_at,
        ];
    }

    protected function formatNumber($number)
    {
        return strpos($number, '.') !== false ? rtrim(rtrim(number_format($number, 3, '.', ''), '0'), '.') : $number;
    }
}
