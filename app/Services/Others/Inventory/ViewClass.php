<?php

namespace App\Services\Others\Inventory;

use Hashids\Hashids;
use App\Models\ListDropdown;
use App\Models\InventoryItem;
use App\Models\InventoryStock;
use App\Models\InventoryWithdrawal;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Others\Inventory\ItemResource;
use App\Http\Resources\Others\Inventory\StockResource;

class ViewClass
{
    public function dashboard($request,$statuses){
        return [
            'counts' => $this->counts($request,$statuses),
            'statuses' => $this->statuses(),
            'stocks' => $this->stocks(),
            'stockouts' => $this->stockouts()
            // 'categories' => $this->categories()
        ];
    }

    public function items($request){
        $data = ItemResource::collection(
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
            ->paginate($request->count)
        )->additional([
            'categories' => $this->categories($request)
        ]);
        return $data;
    }

    public function categories($request){
        $data = ListDropdown::where('classification','Inventory')
        ->where('type','Category')->where('is_active',1)
        ->withCount(['inventory_category' => function ($query) use ($request){
            $query->when($request->laboratory, function ($q, $laboratory) {
                $q->where('laboratory_id', $laboratory);
            });
        }])->get();
        return $data;
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
            [
                'name' => 'Out of Stock',
                'color' => 'text-warning',
                'icon' => 'ri-alert-fill',
                'total' => InventoryItem::withSum('stocks', 'quantity')
                ->havingRaw('COALESCE(stocks_sum_quantity, 0) = 0')
                ->count(),
                'select' => 'outofstock'
            ],
            [
                'name' => 'Expired Items',
                'color' => 'text-danger',
                'icon' => 'ri-alarm-warning-fill',
                'total' => InventoryStock::where('quantity','!=',0)->where('expired_at', '<=', now())->count(),
                'select' => 'expired'
            ],
            [
                'name' => 'For Reorder',
                'color' => 'text-dark',
                'icon' => 'ri-shopping-basket-2-fill',
                'total' => InventoryItem::whereExists(function ($q) {
                    $q->selectRaw(1)
                    ->from('inventory_stocks')
                    ->whereColumn('inventory_stocks.item_id', 'inventory_items.id');
                })
                ->whereRaw('(
                    SELECT COALESCE(SUM(quantity * unit), 0)
                    FROM inventory_stocks
                    WHERE inventory_stocks.item_id = inventory_items.id
                ) <= inventory_items.reorder')
                ->count(),
                'select' => 'reorder'
            ]
        ];
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = new ItemResource(
            InventoryItem::query()
            ->with('category','laboratory','unittype','stocks.withdrawals','stocks.supp')
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
            ->where('id',$id)->first()
        );
        return $data;
    }

    public function stockin($request){
        $data = StockResource::collection(
            InventoryStock::query()
            ->with('withdrawals','supp')
            ->where('item_id',$request->id)->paginate(10)
        );
        return $data;
    }

    public function stockins($request){
        $data = StockResource::collection(
            InventoryStock::query()
            ->with('item','unittype','supp')
            ->orderBy('bought_at','desc')
            ->paginate(10)
        );
        return $data;
    }

    public function stockout($request){
        return [];
    }

    public function stocks(){
        $dates = InventoryStock::query()
            ->selectRaw('DATE(created_at) as date')
            ->distinct()
            ->orderByDesc('date')
            ->take(5)
            ->pluck('date');

        $stocks = InventoryStock::query()
            ->with('unittype', 'supp', 'item')
            ->whereIn(\DB::raw('DATE(created_at)'), $dates)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            });

        return $stocks;
    }

    public function stockouts(){
        $dates = InventoryWithdrawal::query()
            ->selectRaw('DATE(created_at) as date')
            ->distinct()
            ->orderByDesc('date')
            ->take(5)
            ->pluck('date');

        $withdrawals = InventoryWithdrawal::query()
            ->with('stock.item', 'stock.unittype', 'user.profile')
            ->whereIn(\DB::raw('DATE(created_at)'), $dates)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            });

        return $withdrawals;
    }

    public function printLabel($request){
        $stock = InventoryStock::with('item:id,name')->findOrFail($request->id);

        $barcode = new \TCPDFBarcode($stock->code, 'C128');
        $barcodePngString = $barcode->getBarcodePngData(2, 50);
        $base64Image = 'data:image/png;base64,' . base64_encode($barcodePngString);

        $array = [
            'barcodeImage' => $base64Image,
            'name' => $stock->item->name,
            'code' => $stock->code,
        ];

        $width = 6.30 * 28.35;
        $height = 2.40 * 28.35;
        $pdf = \PDF::loadView('qrcodes.inventory-stock', $array)->setPaper([0, 0, $width, $height], 'portrait');
        return $pdf->stream($stock->code.'_barcode.pdf');
    }
}
