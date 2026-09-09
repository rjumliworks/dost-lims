<?php

namespace App\Services\Insights;

use App\Models\Agency;
use App\Models\AgencyFacilityLaboratory;
use App\Models\ListObjective;
use App\Models\ListObjectiveItem;
use App\Models\Target;
use App\Models\TargetBreakdown;
use App\Models\TargetItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TargetGenerationService
{
    /**
     * Ensure a target (and its breakdowns) exists for the given agency/year.
     * If breakdowns are missing, they are generated from the agency's previous
     * year target and its current list of laboratories.
     */
    public function generateForAgency(int $agencyId, ?int $year = null): Target
    {
        $year = $year ?? now()->year;

        return DB::transaction(function () use ($agencyId, $year) {
            $target = Target::withoutGlobalScope('agency')
                ->where('agency_id', $agencyId)
                ->where('year', $year)
                ->first();

            if (! $target) {
                $target = Target::withoutGlobalScope('agency')->create([
                    'agency_id' => $agencyId,
                    'year' => $year,
                    'data' => '[]',
                    'is_completed' => 0,
                ]);
            }

            if ($target->breakdowns()->exists()) {
                return $target;
            }

            $laboratoryIds = AgencyFacilityLaboratory::withoutGlobalScope('agency')
                ->whereHas('facility', fn ($query) => $query->where('agency_id', $agencyId))
                ->pluck('laboratory_id')
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            $previousTarget = Target::withoutGlobalScope('agency')
                ->where('agency_id', $agencyId)
                ->where('year', '<', $year)
                ->whereHas('breakdowns')
                ->orderByDesc('year')
                ->with('breakdowns.items')
                ->first();

            $previousBreakdowns = $previousTarget?->breakdowns ?? collect();

            foreach (ListObjective::where('is_active', 1)->get() as $objective) {
                if ($objective->is_consolidated) {
                    $this->createConsolidatedBreakdown($target, $objective, $previousBreakdowns);
                } else {
                    foreach ($laboratoryIds as $laboratoryId) {
                        $this->createLaboratoryBreakdown($target, $objective, $laboratoryId, $previousBreakdowns);
                    }
                }
            }

            return $target->fresh('breakdowns.items');
        });
    }

    /**
     * Generate/backfill targets for every active agency for the given year.
     */
    public function generateForAllAgencies(?int $year = null): Collection
    {
        $year = $year ?? now()->year;

        return Agency::where('is_active', 1)
            ->get()
            ->map(fn (Agency $agency) => $this->generateForAgency($agency->id, $year));
    }

    private function createConsolidatedBreakdown(Target $target, ListObjective $objective, Collection $previousBreakdowns): void
    {
        $previous = $previousBreakdowns->first(
            fn ($breakdown) => (int) $breakdown->objective_id === (int) $objective->id
        );

        $breakdown = TargetBreakdown::create([
            'target_id' => $target->id,
            'objective_id' => $objective->id,
            'laboratory_id' => null,
            'count' => $previous->count ?? 0,
            'accom' => 0,
            'is_amount' => $objective->is_amount,
            'is_consolidated' => $objective->is_consolidated,
        ]);

        $previousItems = $previous?->items ?? collect();

        foreach (ListObjectiveItem::where('objective_id', $objective->id)->get() as $item) {
            $previousItem = $previousItems->first(
                fn ($targetItem) => (int) $targetItem->item_id === (int) $item->id
            );

            TargetItem::create([
                'target_id' => $breakdown->id,
                'item_id' => $item->id,
                'count' => $previousItem->count ?? 0,
                'accom' => 0,
                'is_amount' => $objective->is_amount,
            ]);
        }
    }

    private function createLaboratoryBreakdown(Target $target, ListObjective $objective, int $laboratoryId, Collection $previousBreakdowns): void
    {
        $previous = $previousBreakdowns->first(
            fn ($breakdown) => (int) $breakdown->objective_id === (int) $objective->id
                && (int) $breakdown->laboratory_id === $laboratoryId
        );

        TargetBreakdown::create([
            'target_id' => $target->id,
            'objective_id' => $objective->id,
            'laboratory_id' => $laboratoryId,
            'count' => $previous->count ?? 0,
            'accom' => 0,
            'is_amount' => $objective->is_amount,
            'is_consolidated' => $objective->is_consolidated,
        ]);
    }
}
