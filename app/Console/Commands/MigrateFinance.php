<?php

namespace App\Console\Commands;

use App\Models\Tsr;
use App\Models\User;
use App\Models\Customer;
use App\Models\FinanceName;
use App\Models\FinanceItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class MigrateFinance extends Command
{
    protected $signature = 'migrate:finance';
    protected $description = 'Migrate finance records from old DB';

    public function handle()
    {

        $this->info("Starting customer migration...");

        // 1️⃣ Setup old encrypter
        // $this->makeOldEncrypter($oldKey);

        // 2️⃣ Truncate all customer-related tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = [
            'finance_orseries',
            'finance_items',
            'finance_ops',
            'finance_op_items',
            'finance_names',
            'finance_receipts',
            'finance_receipt_details'
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Truncated {$table}");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $series = DB::connection('old_db')
            ->table('finance_orseries')
            ->where('agency_id', 11)
            ->orderBy('id')->get();

        foreach ($series as $ser) {
            DB::table('finance_orseries')->insert([
                'name' => $ser->name,
                'start' => $ser->start,
                'end' => $ser->end,
                'next' => $ser->next,
                'agency_id' => 11,
                'is_active' => $ser->is_active,
                'is_finished' => $ser->is_finished,
                'user_id' => User::where('old_id', $ser->user_id)->value('id') ?? 1,
                'created_at' => $ser->created_at,
                'updated_at' => $ser->updated_at
            ]);

            $this->info("Migrated series ID {$ser->id}");
        }


        $names = DB::connection('old_db')
            ->table('finance_names')
            ->orderBy('id')->get();

        foreach ($names as $name) {
            DB::table('finance_names')->insert([
                'name' => $name->name,
                'is_individual' => $name->is_individual,
                'is_active' => $name->is_active,
                'old_id' => $name->id,
                'created_at' => $name->created_at,
                'updated_at' => $name->updated_at
            ]);

            $this->info("Migrated name ID {$name->id}");
        }


        $itemss = DB::connection('old_db')
            ->table('finance_items')
            ->orderBy('id')->get();

        foreach ($itemss as $item) {
            DB::table('finance_items')->insert([
                'name' => $item->name,
                'old_id' => $item->id,
                'amount' => $item->amount,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ]);

            $this->info("Migrated item ID {$item->id}");
        }


        $finances = DB::connection('old_db')
            ->table('finance_ops')
            ->where('agency_id', 11)
            ->orderBy('id')->get();

        foreach ($finances as $finance) {
            $newOpId = DB::table('finance_ops')->insertGetId([
                'code' => $finance->code,
                'total' => $finance->total,
                'status_id' => $finance->status_id,
                'collection_id' => $finance->collection_id,
                'payment_id' => $finance->payment_id,
                'payorable_id' => ($finance->payorable_type == 'App\Models\Customer') ? Customer::where('old_id', $finance->payorable_id)->value('id') : FinanceName::where('old_id', $finance->payorable_id)->value('id'),
                'payorable_type' => $finance->payorable_type,
                'created_by' => User::where('old_id', $finance->created_by)->value('id') ?? 1,
                'agency_id' => 11, 
                'created_at' => $finance->created_at,
                'updated_at' => $finance->updated_at
            ]);

            $items = DB::connection('old_db')
                ->table('finance_op_items')
                ->where('op_id',$finance->id)
                ->get();

            foreach ($items as $item) {
                DB::table('finance_op_items')->insert([
                    'op_id' => $newOpId,
                    'itemable_type' => $item->itemable_type,
                    'itemable_id' => ($item->itemable_type == 'App\Models\Tsr') ? Tsr::where('old_id', $item->itemable_id)->value('id') : FinanceItem::where('old_id', $item->itemable_id)->value('id'),
                    'amount' => $item->amount,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at
                ]);
            }

            $receipts = DB::connection('old_db')
                ->table('finance_receipts')
                ->where('op_id',$finance->id)
                ->get();

            foreach ($receipts as $receipt) {
                $newReceiptId = DB::table('finance_receipts')->insertGetId([
                    'op_id' => $newOpId,
                    'number' => $receipt->number,
                    'is_deposit' => $receipt->is_deposit,
                    'orseries_id' => $receipt->orseries_id,
                    'deposit_id' => $receipt->deposit_id,
                    'created_by' => User::where('old_id', $receipt->created_by)->value('id') ?? 1,
                    'agency_id' => 11,
                    'created_at' => $receipt->created_at,
                    'updated_at' => $receipt->updated_at
                ]);

                $details = DB::connection('old_db')
                ->table('finance_receipt_details')
                ->where('receipt_id',$receipt->id)
                ->get();


                foreach ($details as $detail) {
                    DB::table('finance_receipt_details')->insert([
                        'receipt_id' => $newReceiptId,
                        'amount' => $detail->amount,
                        'is_cheque' => $detail->is_cheque,
                        'number' => $detail->number,
                        'bank' => $detail->bank,
                        'date_at' => $detail->date_at,
                        'created_at' => $detail->created_at,
                        'updated_at' => $detail->updated_at
                    ]);
                }
            }

            $this->info("Migrated finance ID {$finance->id}");
        }

        $this->info("Finance migration completed successfully.");
    }
}
