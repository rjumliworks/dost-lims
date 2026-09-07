<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateEmpty extends Command
{
    protected $signature = 'migrate:empty {--force : Skip the confirmation prompt}';
    protected $description = 'Empty all tsrs, testservices, customer, and finance tables migrated by migrate:all';

    public function handle()
    {
        $tables = [
            // customers
            'customer_conformes',
            'customer_contacts',
            'customer_addresses',
            'customers',
            'customer_names',
            'wallets',

            // testservices
            'testservice_samples',
            'testservice_addons',
            'testservice_lists',
            'testservice_methods',
            'testservice_names',
            'testservices',

            // tsrs
            'tsr_analyses',
            'tsr_samples',
            'tsr_remarks',
            'tsr_sample_reports',
            'tsr_sample_disposals',
            'tsr_sample_report_lists',
            'tsr_sample_report_signatories',
            'tsr_payments',
            'tsr_payment_deductions',
            'tsr_releases',
            'tsr_referrals',
            'tsr_services',
            'tsr_reports',
            'tsrs',

            // finance
            'finance_orseries',
            'finance_items',
            'finance_ops',
            'finance_op_items',
            'finance_names',
            'finance_receipts',
            'finance_receipt_details',
        ];

        if (! $this->option('force') && ! $this->confirm('This will TRUNCATE '.count($tables).' tables (tsrs, testservices, customers, finance). Continue?')) {
            $this->info('Aborted.');
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Truncated {$table}");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('All tables emptied successfully.');
    }
}
