<?php

namespace App\Services\Others\Inventory;

use App\Models\InventoryStock;
use App\Models\InventoryWithdrawal;
use App\Http\Resources\Others\Inventory\StockResource;

class CheckoutClass
{
    public function item($request){
        $keyword = $request->keyword;
        $data = InventoryStock::with('unittype','item:id,name','supp')
            ->where('onhand','>',0)
            ->where(function ($query) use ($keyword) {
                $query->where('code', $keyword)
                    ->orWhereHas('item', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%");
                    })
                    ->orWhereHas('supp', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%");
                    });
            })
            ->limit(10)
            ->get();
        return StockResource::collection($data);
    }

    public function process($request){
        foreach ($request->items as $item) {
            $stock = InventoryStock::with('item:id,name')->lockForUpdate()->findOrFail($item['id']);
            $quantity = (int) $item['quantity'];

            if ($quantity < 1 || $quantity > $stock->onhand) {
                throw new \Exception("Checkout quantity for {$stock->item->name} exceeds available stock on hand.");
            }

            $stock->decrement('onhand', $quantity);

            InventoryWithdrawal::create([
                'quantity' => $quantity,
                'stock_id' => $stock->id,
                'user_id' => \Auth::id(),
            ]);
        }

        return [
            'data' => null,
            'message' => 'Checkout was successful!',
            'info' => "You've successfully checked out the selected items.",
        ];
    }
}
