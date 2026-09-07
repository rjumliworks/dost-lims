<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateAll extends Command
{
    protected $signature = 'migrate:all';
    protected $description = 'Run the full old-database migration in order: customers, testservices, tsrs (which also runs finance: OP and OR)';

    public function handle()
    {
        $this->info('=== Step 1/3: Migrating customers ===');
        $this->call('migrate:customers');

        $this->info('=== Step 2/3: Migrating testservices ===');
        $this->call('migrate:testservices-limited');

        $this->info('=== Step 3/3: Migrating TSRs (status 2, 3, 4 only) + finance (OP and OR) ===');
        $this->call('migrate:tsrs');

        $this->info('=== All migrations completed successfully ===');
    }
}
