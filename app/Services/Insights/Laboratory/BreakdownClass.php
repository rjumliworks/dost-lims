<?php

namespace App\Services\Insights\Laboratory;

use App\Models\TsrAnalysis;
use App\Models\AgencyFacilityLaboratory;

class BreakdownClass
{
    public function data($request){
        $year = ($request->year) ? $request->year : date('Y');
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $laboratories = AgencyFacilityLaboratory::with('laboratory')
            ->whereHas('laboratory', fn ($query) => $query->where('is_active', 1))
            ->get()
            ->pluck('laboratory')
            ->unique('id')
            ->values();

        $lists = $laboratories->map(function ($laboratory) use ($year) {
            $data = [];
            for ($month = 1; $month <= 12; $month++) {
                $data[] = TsrAnalysis::whereHas('sample.tsr', function ($query) use ($laboratory, $year, $month) {
                        $query->where('laboratory_id', $laboratory->id);
                        $query->whereYear('created_at', $year);
                        $query->whereMonth('created_at', $month);
                    })
                    ->whereIn('status_id', [11, 12])
                    ->count();
            }

            return [
                'name' => $laboratory->name,
                'data' => $data,
            ];
        })->values();

        return [
            'categories' => $months,
            'lists' => $lists,
        ];
    }
}
