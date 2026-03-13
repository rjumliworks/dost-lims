<?php

namespace App\Services\Insights\Customer;

use App\Models\Customer;

class DataClass
{
  public function summary_count($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

        return [
            [
                'name' => 'New Customers',
                'description' => 'Customers who recently availed services',
                'total' => Customer::where('is_new',1)
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                })
                ->when($year, function ($query, $year) {
                    $query->whereYear('created_at',$year);
                })
                ->where('is_active',1)->count(),
                'icon' => 'ri-user-add-fill fs-20',
                'color' => 'text-info'
            ],
            [
                'name' => 'Active Customers',
                'description' => 'Customers actively using services',
                'total' => Customer::whereHas('tsrs', function ($query) use ($year, $month) {
                    ($year) ? $query->whereYear('created_at', $year) : '';
                    ($month) ? $query->whereMonth('created_at', $month) : '';
                })
                ->count(),
                'icon' => 'ri-group-2-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Old Customer',
                'description' => 'Existing customers who returned for services',
                'total' =>  Customer::whereYear('created_at', '<', $year) 
                ->whereHas('tsrs', function ($query) use ($year){
                    ($year) ? $query->whereYear('created_at', $year) : '';
                })
                ->count(),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-success',
                'icon' => 'ri-radio-button-fill fs-20',
                'color' => 'text-primary'
            ]
        ];
    }

    public function summary_type($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

        return [
            [
                'name' => 'Firms',
                'description' => 'Business entities availing services.',
                'total' => Customer::where('classification_id',8)
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                })
                ->when($year, function ($query, $year) {
                    $query->whereYear('created_at',$year);
                })
                ->where('is_active',1)->count(),
                'icon' => 'ri-team-fill fs-20',
                'color' => 'text-dark'
            ],
            [
                'name' => 'Individuals',
                'description' => 'Private customers using services',
                'total' => Customer::where('classification_id',9)
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                })
                ->when($year, function ($query, $year) {
                    $query->whereYear('created_at',$year);
                })
                ->where('is_active',1)->count(),
                'icon' => 'ri-user-3-fill fs-20',
                'color' => 'text-dark'
            ]
        ];
    }
}
