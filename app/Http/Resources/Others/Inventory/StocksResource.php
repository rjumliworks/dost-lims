<?php

namespace App\Http\Resources\Others\Inventory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StocksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'old_code' => $this->old_code,
            'name' => $this->item->name,
            'brand' => ($this->brand) ? $this->brand : "Not specified",
            'quantity' => $this->quantity,
            'onhand' => $this->onhand,
            'number' => $this->number,
            'unit' => $this->unit,
            'unit_id' => $this->unit_id,
            'type' => $this->unittype->name,
            'price' => $this->price,
            'supplier' => ($this->supp) ? $this->supp->name : $this->supplier, 
            'supplier_id' => $this->supplier_id,
            'supplier_data' => $this->supp,
            'bought_at' => $this->bought_at,
            'expired_at' => $this->expired_at,
        ];
    }
}
