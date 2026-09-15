<?php

namespace App\Console\Commands;

use App\Models\Tsr;
use Illuminate\Console\Command;
use App\Services\Major\Tsr\ReportGenerateClass;

class GenerateTsrReport extends Command
{
    protected $signature = 'report {id?}';
    protected $description = 'Command description';

    public function __construct(private ReportGenerateClass $reportGenerate)
    {
        parent::__construct();
    }

    public function handle()
    {
        $id = $this->argument('id');

        if ($id) {
            if ($this->reportGenerate->generate($id)) {
                $this->info("TSR {$id} generated.");
            } else {
                $this->error("TSR {$id} not found.");
            }
            return Command::SUCCESS;
        }

        // Generate all TSRs
        Tsr::chunk(100, function ($tsrs) {
            foreach ($tsrs as $tsr) {
                $this->reportGenerate->generate($tsr->id);
                $this->line("Generated TSR {$tsr->id}");
            }
        });

        $this->info('All TSR reports generated.');

        return Command::SUCCESS;
    }
}
