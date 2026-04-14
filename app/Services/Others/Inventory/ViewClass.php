<?php

namespace App\Services\Others\Inventory;

use App\Models\InventoryItem;
use App\Models\InventoryStock;

class ViewClass
{
    public function dashboard($request,$statuses){
        return [
            'counts' => $this->counts($request,$statuses),
            'statuses' => $this->statuses()
        ];
    }

    private function statuses(){
        return [
            InventoryItem::where('is_active',1)->count(), InventoryItem::where('is_active',0)->count(),
        ];
    }

    private function counts($request,$statuses){
        $itemsBelowReorderLevel = InventoryItem::all()->filter(function ($item) {
            return $item->isBelowReorderLevel();
        });
        $count = $itemsBelowReorderLevel->count();
        return [
            // [
            //     'name' => 'All Items',
            //     'color' => 'text-success',
            //     'icon' => 'ri-shopping-basket-2-fill',
            //     'total' => InventoryStock::count(),
            //     'select' => null
            // ],
            [
                'name' => 'Ouf of Stock',
                'color' => 'text-warning',
                'icon' => 'ri-alert-fill',
                'total' => InventoryStock::whereHas('item', function ($query) {
                    $query->whereColumn('reorder', '>', 'quantity');
                })->count(),
                'select' => 'outofstock'
            ],
            [
                'name' => 'Expired Items',
                'color' => 'text-danger',
                'icon' => 'ri-alarm-warning-fill',
                'total' => InventoryStock::where('expired_at', '<=', now())->count(),
                'select' => 'expired'
            ],
            [
                'name' => 'For Reorder',
                'color' => 'text-dark',
                'icon' => 'ri-shopping-basket-2-fill',
                'total' => $count,
                'select' => 'reorder'
            ]
        ];
    }
}
