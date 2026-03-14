<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MigrateTsrs extends Command
{
    protected $signature = 'migrate:tsrs {old_key} {--limit=0}';
    protected $description = 'Migrate tsrs from old DB including encrypted fields';
}
