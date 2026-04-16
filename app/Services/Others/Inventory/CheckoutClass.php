<?php

namespace App\Services\Others\Inventory;

use App\Models\InventoryStock;
use App\Http\Resources\Others\Inventory\StockResource;

class CheckoutClass
{
    public function item($request){
        $keyword = $request->keyword;
        $data = InventoryStock::with('unittype','item:id,name','supp')
            ->withWhereHas('item', function ($query) use ($keyword){
               
            })
            ->where('code',$keyword)
            ->first();
        return new StockResource($data);
    }
}
