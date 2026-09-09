<?php

namespace App\Console\Commands;

use App\Models\Agency;
use App\Services\Insights\TargetGenerationService;
use Illuminate\Console\Command;

class GenerateYearlyTargets extends Command
{
    protected $signature = 'targets:generate {--year= : Year to generate targets for (defaults to the current year)}';

    protected $description = "Create each active agency's target/target_breakdowns for a year, carried over from its previous year and its current list of laboratories, if it doesn't have any yet.";

    public function handle(TargetGenerationService $generator): int
    {
        $year = $this->option('year') ? (int) $this->option('year') : now()->year;

        $agencies = Agency::where('is_active', 1)->get();

        if ($agencies->isEmpty()) {
            $this->warn('No active agencies found.');

            return self::SUCCESS;
        }

        foreach ($agencies as $agency) {
            $target = $generator->generateForAgency($agency->id, $year);
            $count = $target->breakdowns()->count();

            $this->info("Agency [{$agency->name}]: target for {$year} ready ({$count} breakdown rows).");
        }

        return self::SUCCESS;
    }
}
