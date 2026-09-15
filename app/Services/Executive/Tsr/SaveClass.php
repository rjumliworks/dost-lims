<?php

namespace App\Services\Executive\Tsr;

use App\Models\Tsr;
use App\Services\Major\Tsr\ReportGenerateClass;

class SaveClass
{
    protected int $maxRange = 500;
    protected ReportGenerateClass $reportGenerate;

    public function __construct(ReportGenerateClass $reportGenerate)
    {
        $this->reportGenerate = $reportGenerate;
    }

    public function sync($request)
    {
        $minId = min($request->from_id, $request->to_id);
        $maxId = max($request->from_id, $request->to_id);

        $ids = Tsr::whereBetween('id', [$minId, $maxId])
            ->whereNotNull('code')
            ->orderBy('id')
            ->pluck('id');

        if ($ids->count() > $this->maxRange) {
            return [
                'data' => [],
                'message' => 'Range too large',
                'status' => false,
                'info' => "The selected range covers {$ids->count()} TSRs, which exceeds the {$this->maxRange} limit per sync. Please narrow the range.",
            ];
        }

        $updated = 0;

        foreach ($ids as $id) {
            if ($this->reportGenerate->generate($id)) {
                $updated++;
            }
        }

        return [
            'data' => $updated,
            'message' => 'Printed TSRs Synced',
            'info' => "Successfully refreshed the printed version for {$updated} of {$ids->count()} TSR(s) in the selected range.",
        ];
    }
}
