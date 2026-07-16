<?php

namespace App\Services\Others\Inventory;

use App\Models\InventoryItem;
use App\Models\InventoryStock;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Others\Inventory\ItemResource;
class SaveClass
{
    public function item($request){
        $data = InventoryItem::create(array_merge($request->all(),[
            'code' => $this->generateCode($request),
            'img' => 'avatar.jpg'
        ]));
        return [
            'data' => new ItemResource($data),
            'message' => 'Item creation was successful!', 
            'info' => "You've successfully created the new item."
        ];
    }

     public function itemUpdate($request){
        $item = InventoryItem::find($request->id);
        $item->update($request->except(['option', 'onhand']));

        $data = new ItemResource(
            InventoryItem::query()
            ->with('category','unittype','stocks.withdrawals','stocks.supp')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($request->laboratory, function ($query, $laboratory) {
                $query->whereHas('stocks', function ($q) use ($laboratory) {
                    $q->where('laboratory_id', $laboratory);
                });
            })
            ->when($request->status, function ($query, $filter) {
                if($filter == 'Out of Stock'){
                    $query->withSum('stocks', 'quantity')->havingRaw('COALESCE(stocks_sum_quantity, 0) = 0');
                }
                elseif($filter == 'For Reorder'){
                    $query->whereHas('stocks') // ✅ MUST have stock records
            ->whereRaw('(
                SELECT COALESCE(SUM(quantity * unit), 0)
                FROM inventory_stocks
                WHERE inventory_stocks.item_id = inventory_items.id
            ) <= inventory_items.reorder');
                }
                elseif($filter == 'Expired Items'){
                    $query->whereHas('stocks', function ($q) {
                        $q->where('expired_at', '<=', now());
                    });
                }
            })
            ->withCount([
                'stocks as onhand' => function (Builder $query) {
                    $query->select(\DB::raw('SUM(onhand)'));
                }, 
                'stocks as stock' => function (Builder $query) {
                    $query->select(\DB::raw('SUM(
                    CASE
                        WHEN inventory_stocks.unit_id = inventory_items.unit_id THEN inventory_stocks.unit * inventory_stocks.onhand
                        WHEN inventory_stocks.unit_id = 123 AND inventory_items.unit_id = 124 THEN inventory_stocks.unit * inventory_stocks.onhand * 1000
                        WHEN inventory_stocks.unit_id = 124 AND inventory_items.unit_id = 123 THEN inventory_stocks.unit * inventory_stocks.onhand * 0.001
                        WHEN inventory_stocks.unit_id = 125 AND inventory_items.unit_id = 126 THEN inventory_stocks.unit * inventory_stocks.onhand * 0.001
                        WHEN inventory_stocks.unit_id = 126 AND inventory_items.unit_id = 125 THEN inventory_stocks.unit * inventory_stocks.onhand * 1000
                        ELSE inventory_stocks.unit * inventory_stocks.onhand
                    END)'))
                        ->where('onhand', '!=', 0);
                }
            ])
            ->where('id',$request->id)
            ->first()
        );
        return [
            'data' => $data,
            'message' => 'Item creation was successful!', 
            'info' => "You've successfully created the new item."
        ];
    }

    public function stock($request){
        $data = InventoryStock::create(array_merge($request->all(),[
            'code' => date('Ymdhis'),
            'onhand' => $request->quantity,
            'user_id' => \Auth::user()->id
        ]));
   
        $data = InventoryItem::query()
        ->with('category','unittype','stocks.withdrawals')
        ->when($request->keyword, function ($query, $keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        })
        ->withCount([
            'stocks as onhand' => function (Builder $query) {
                $query->select(\DB::raw('SUM(onhand)'));
            }, 
            'stocks as stock' => function (Builder $query) {
                $query->select(\DB::raw('SUM(
                CASE
                    WHEN inventory_stocks.unit_id = inventory_items.unit_id THEN inventory_stocks.unit * inventory_stocks.onhand
                    WHEN inventory_stocks.unit_id = 123 AND inventory_items.unit_id = 124 THEN inventory_stocks.unit * inventory_stocks.onhand * 1000
                    WHEN inventory_stocks.unit_id = 124 AND inventory_items.unit_id = 123 THEN inventory_stocks.unit * inventory_stocks.onhand * 0.001
                    WHEN inventory_stocks.unit_id = 125 AND inventory_items.unit_id = 126 THEN inventory_stocks.unit * inventory_stocks.onhand * 0.001
                    WHEN inventory_stocks.unit_id = 126 AND inventory_items.unit_id = 125 THEN inventory_stocks.unit * inventory_stocks.onhand * 1000
                    ELSE inventory_stocks.unit * inventory_stocks.onhand
                END)'))
                    ->where('onhand', '!=', 0);
            }
        ])
        ->where('id',$request->item_id)->first();

        return [
            'data' => new ItemResource($data),
            'message' => 'Stock was added successful!', 
            'info' => "You've successfully added the new stock."
        ];
    }

    public function stockUpdate($request){
        // $data = InventoryStock::where('id',$request->id)->update($request->except(['name','item_id','option','laboratory_id']));
        $stock = InventoryStock::find($request->id);
        $data = array_merge(
            $request->except(['name', 'item_id', 'option', 'laboratory_id']),
            ['onhand' => $request->quantity]
        );
        $stock->update($data);

        $data = InventoryItem::query()
            ->with('category','unittype','stocks.withdrawals','stocks.supp')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->withCount([
                'stocks as onhand' => function (Builder $query) {
                    $query->select(\DB::raw('SUM(onhand)'));
                }, 
                'stocks as stock' => function (Builder $query) {
                    $query->select(\DB::raw('SUM(
                    CASE
                        WHEN inventory_stocks.unit_id = inventory_items.unit_id THEN inventory_stocks.unit * inventory_stocks.onhand
                        WHEN inventory_stocks.unit_id = 123 AND inventory_items.unit_id = 124 THEN inventory_stocks.unit * inventory_stocks.onhand * 1000
                        WHEN inventory_stocks.unit_id = 124 AND inventory_items.unit_id = 123 THEN inventory_stocks.unit * inventory_stocks.onhand * 0.001
                        WHEN inventory_stocks.unit_id = 125 AND inventory_items.unit_id = 126 THEN inventory_stocks.unit * inventory_stocks.onhand * 0.001
                        WHEN inventory_stocks.unit_id = 126 AND inventory_items.unit_id = 125 THEN inventory_stocks.unit * inventory_stocks.onhand * 1000
                        ELSE inventory_stocks.unit * inventory_stocks.onhand
                    END)'))
                        ->where('onhand', '!=', 0);
                }
            ])
        ->where('id',$stock->item_id)->first();

        return [
            'data' => new ItemResource($data),
            'message' => 'Stock was updated successful!', 
            'info' => "You've successfully added the new stock."
        ];
    }

    public function generateCode($request){
        $c = InventoryItem::count();
        $code = 'R9-INV-'.str_pad(($c+1), 5, '0', STR_PAD_LEFT);  
        return $code;
    }
}
