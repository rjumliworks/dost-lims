<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateSuppliers extends Command
{
    protected $signature = 'migrate:suppliers';
    protected $description = 'Migrate suppliers from old DB including encrypted fields';

    public function handle()
    {
        $this->info("Starting customer migration...");

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = [
            'suppliers'
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Truncated {$table}");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $suppliers = DB::connection('old_db')
            ->table('inventory_suppliers')
            ->orderBy('id')->get();

        foreach ($suppliers as $supplier) {
            DB::table('suppliers')->insert([
                'name' => $supplier->name,
                'email' => $supplier->email,
                'contact_no' => $supplier->contact_no,
                'address' => $supplier->address,
                'barangay_code' => $supplier->barangay_code,
                'municipality_code' => $supplier->municipality_code,
                'is_active' => $supplier->is_active,
                'user_id' => User::where('old_id', $supplier->user_id)->value('id') ?? 1,
                'agency_id' => 14, 
                'created_at' => $supplier->created_at,
                'updated_at' => $supplier->updated_at
            ]);

            $this->info("Migrated customer ID {$supplier->id}");
        }

        $this->info("Supplier migration completed successfully.");
    }
}
