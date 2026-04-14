<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateInventory extends Command
{
    protected $signature = 'migrate:inventory';
    protected $description = 'Migrate inventory from old DB including encrypted fields';

    public function handle()
    {
        $this->info("Starting inventory migration...");

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = [
            'inventory_items',
            'inventory_stocks',
            'inventory_withdrawals'
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Truncated {$table}");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $items = DB::connection('old_db')
            ->table('inventory_items')
            ->orderBy('id')->get();
        foreach ($items as $item) {
            $e = DB::table('inventory_items')->insertGetId([
                'code' => $item->code,
                'old_code' => $item->old_code,
                'old_id' => $item->id,
                'name' => $item->name,
                'img' => $item->img,
                'reorder' => $item->reorder,
                'unit_id' => $item->unit_id,
                'category_id' => $item->category_id,
                'laboratory_id' => $item->laboratory_id,
                'agency_id' => 14,
                'is_active' => $item->is_active,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ]);

            if($e){
                $stocks = DB::connection('old_db')
                ->table('inventory_stocks')
                ->where('item_id',$item->id)
                ->get();
                foreach ($stocks as $stock) {
                    $s = DB::table('inventory_stocks')->insertGetId([
                        'code' => $stock->code,
                        'brand' => $stock->brand,
                        'quantity' => $stock->quantity,
                        'onhand' => $stock->onhand,
                        'number' => $stock->number,
                        'cas_number' => $stock->cas_number,
                        'price' => $stock->price,
                        'unit' => $stock->unit,
                        'notify' => $stock->notify,
                        'unit_id' => $stock->unit_id,
                        'supplier_id' => Supplier::where('id', $stock->supplier_id)->value('id'),
                        'user_id' => User::where('old_id', $stock->user_id)->value('id') ?? 1,
                        'item_id' => $e,
                        'created_at'=>$stock->created_at,
                        'updated_at'=>$stock->updated_at
                    ]);

                     $withdrawals = DB::connection('old_db')
                    ->table('inventory_withdrawals')
                    ->where('stock_id',$stock->id)
                    ->get();

                    foreach ($withdrawals as $withdrawal) {
                        DB::table('inventory_withdrawals')->insert([
                            'quantity' => $withdrawal->quantity,
                            'stock_id' => $s,
                            'user_id' => User::where('old_id', $withdrawal->user_id)->value('id') ?? 1,
                            'created_at' => $withdrawal->created_at,
                            'updated_at' => $withdrawal->updated_at
                        ]);
                    }
                }
            }
            $this->info("Migrated item ID {$item->id}");
        }
        $this->info("Equipment migration completed successfully.");
    }
}
