<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateTestServices extends Command
{
    protected $signature = 'migrate:testservices-limited {--limit=0}';
    protected $description = 'Migrate testservice names, methods, and testservices used in tsr_analyses for specific agency and statuses';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $this->info("Starting selective testservices migration...");

        // Disable FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate target tables
        DB::table('testservice_methods')->truncate();
        DB::table('testservice_names')->truncate();
        DB::table('testservices')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ------------------------
        // Step 1: Get relevant testservice_ids from old tsr_analyses
        // ------------------------
        $testserviceIds = DB::connection('old_db')
            ->table('tsr_analyses as ta')
            ->join('tsr_samples as tsmp', 'tsmp.id', '=', 'ta.sample_id')
            ->join('tsrs as t', 't.id', '=', 'tsmp.tsr_id')
            ->where('t.agency_id', 14)
            ->whereIn('t.status_id', [2,3,4])
            ->distinct()
            ->pluck('ta.testservice_id');

        $this->info("Found ".count($testserviceIds)." unique testservices used in TSR analyses.");

        if ($testserviceIds->isEmpty()) {
            $this->info("No testservices to migrate.");
            return;
        }

        // ------------------------
        // Step 2: Migrate all required testservice_names
        // ------------------------
        $oldNameIds = DB::connection('old_db')
            ->table('testservice_names')
            ->whereIn('id', function($query) use ($testserviceIds) {
                $query->select('testname_id')->from('testservices')
                      ->whereIn('id', $testserviceIds);
            })
            ->orWhereIn('id', function($query) use ($testserviceIds) {
                $query->select('method_id')->from('testservice_methods')
                      ->whereIn('id', function($q) use ($testserviceIds) {
                          $q->select('method_id')->from('testservices')->whereIn('id', $testserviceIds);
                      });
            })
            ->orWhereIn('id', function($query) use ($testserviceIds) {
                $query->select('reference_id')->from('testservice_methods')
                      ->whereIn('id', function($q) use ($testserviceIds) {
                          $q->select('method_id')->from('testservices')->whereIn('id', $testserviceIds);
                      });
            })
            ->pluck('id');

        $oldNames = DB::connection('old_db')
            ->table('testservice_names')
            ->whereIn('id', $oldNameIds)
            ->get();

        $nameMapping = []; // old_name_id => new_name_id
        foreach ($oldNames as $oldName) {
            $newId = DB::table('testservice_names')->insertGetId([
                'name' => $oldName->name,
                'short' => $oldName->short,
                'is_active' => $oldName->is_active,
                'type_id' => $oldName->type_id,
                'laboratory_id' => $oldName->laboratory_id,
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => $oldName->created_at,
                'updated_at' => $oldName->updated_at,
            ]);
            $nameMapping[$oldName->id] = $newId;
        }
        $this->info("Migrated ".count($nameMapping)." testservice_names.");

        // ------------------------
        // Step 3: Migrate testservice_methods
        // ------------------------
        $oldMethods = DB::connection('old_db')
            ->table('testservice_methods as tm')
            ->join('testservices as ts', 'ts.method_id', '=', 'tm.id')
            ->whereIn('ts.id', $testserviceIds)
            ->select('tm.*')
            ->distinct()
            ->get();

        $methodMapping = []; // old_method_id => new_method_id
        foreach ($oldMethods as $oldMethod) {
            // Check mapping exists
            if (!isset($nameMapping[$oldMethod->method_id]) || !isset($nameMapping[$oldMethod->reference_id])) {
                $this->warn("Skipping method ID {$oldMethod->id} due to missing name mapping.");
                continue;
            }

            $newId = DB::table('testservice_methods')->insertGetId([
                'fee' => $oldMethod->fee,
                'is_active' => $oldMethod->is_active,
                'method_id' => $nameMapping[$oldMethod->method_id],
                'reference_id' => $nameMapping[$oldMethod->reference_id],
                'laboratory_id' => $oldMethod->laboratory_id,
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => $oldMethod->created_at,
                'updated_at' => $oldMethod->updated_at,
            ]);
            $methodMapping[$oldMethod->id] = $newId;
        }
        $this->info("Migrated ".count($methodMapping)." testservice_methods.");

        // ------------------------
        // Step 4: Migrate testservices
        // ------------------------
        $oldServices = DB::connection('old_db')
            ->table('testservices')
            ->whereIn('id', $testserviceIds)
            ->get();

        $serviceCount = 0;
        foreach ($oldServices as $oldService) {
            // Skip if method mapping missing
            if (!isset($methodMapping[$oldService->method_id])) {
                $this->warn("Skipping testservice ID {$oldService->id} due to missing method mapping.");
                continue;
            }

            DB::table('testservices')->insert([
                'testname_id' => $nameMapping[$oldService->testname_id] ?? null,
                'method_id' => $methodMapping[$oldService->method_id],
                'status_id' => $oldService->status_id ?? 2,
                'laboratory_id' => $oldService->laboratory_id,
                'agency_id' => 14,
                'added_by' => 1,
                'is_active' => $oldService->is_active ?? 1,
                'is_fixed' => 1,
                'old_id' => $oldService->id,
                'created_at' => $oldService->created_at,
                'updated_at' => $oldService->updated_at,
            ]);
            $serviceCount++;
        }
        $this->info("Migrated {$serviceCount} testservices.");

        $this->info("Selective testservice migration completed successfully.");
    }
}