<?php

namespace App\Services\Insights\Laboratory;

use App\Models\TsrAnalysis;
use App\Models\UserRole;
use App\Models\AgencyFacilityLaboratory;

class SummaryClass
{
    public function data($request){
        $year = $request->year;
        $laboratory = $request->laboratory;

        $scope = function ($query) use ($laboratory, $year) {
            $query->whereHas('sample.tsr', function ($query) use ($laboratory, $year) {
                $query->when($laboratory, function ($query, $laboratory) {
                    $query->where('laboratory_id', $laboratory);
                });
                if ($year) {
                    $query->whereYear('created_at', $year);
                }
            });
        };

        $completed = TsrAnalysis::where($scope)->where('status_id', 12)->count();
        $ongoing = TsrAnalysis::where($scope)->where('status_id', 11)->count();
        $conducted = TsrAnalysis::where($scope)->whereIn('status_id', [11, 12])->count();

        $analysts = UserRole::where('is_active', 1)
            ->whereHas('role', function ($query) {
                $query->where('name', 'Laboratory Analyst');
            })
            ->when($laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id', $laboratory);
            })
            ->distinct('user_id')
            ->count('user_id');

        $laboratories = AgencyFacilityLaboratory::with('laboratory')
            ->whereHas('laboratory', fn ($query) => $query->where('is_active', 1))
            ->when($laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id', $laboratory);
            })
            ->distinct('laboratory_id')
            ->count('laboratory_id');

        return [
            [
                'name' => 'Total Completed Tests',
                'description' => 'Total tests that have been finalized',
                'total' => $completed,
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Total Ongoing Tests',
                'description' => 'Tests that are currently in progress',
                'total' => $ongoing,
                'icon' => 'ri-indeterminate-circle-fill fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Total Tests Conducted',
                'description' => 'The overall count of tests conducted',
                'total' => $conducted,
                'icon' => 'ri-record-circle-fill fs-20',
                'color' => 'text-dark'
            ],
            [
                'name' => 'Number of Laboratory Analysts',
                'description' => 'Total number of analysts working in the laboratory.',
                'total' => $analysts,
                'icon' => 'ri-user-3-fill fs-20',
                'color' => 'text-primary'
            ],
            [
                'name' => 'Number of Laboratories',
                'description' => 'Total number of laboratories available in the region.',
                'total' => $laboratories,
                'icon' => 'ri-building-2-fill fs-20',
                'color' => 'text-info'
            ],
        ];
    }
}
