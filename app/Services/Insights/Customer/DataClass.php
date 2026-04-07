<?php

namespace App\Services\Insights\Customer;

use App\Models\Tsr;
use App\Models\Customer;
use App\Http\Resources\DefaultResource;

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
                'total' => Customer::whereHas('customer_name', function ($q) {
                    $q->where('classification_id',8);
                })
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
                'total' => Customer::whereHas('customer_name', function ($q) {
                    $q->where('classification_id',9);
                })
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

    public function high_request($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

        $startMonth = null;
        $endMonth = null;
        $month = null;
        if($request->by == 'By Month'){
            $month = ($request->month) ? \DateTime::createFromFormat('F', $request->month)->format('m') : null; 
        }elseif($request->by == 'By Quarter'){
            switch($request->quarter){
                case '1st Quarter':
                    $startMonth = 1;
                    $endMonth = 3;
                break;
                case '2nd Quarter':
                    $startMonth = 4;
                    $endMonth = 6;
                break;
                case '3rd Quarter':
                    $startMonth = 7;
                    $endMonth = 9;
                break;
                case '4th Quarter':
                    $startMonth = 10;
                    $endMonth = 12;
                break;
            }
        }elseif($request->by == 'By Semester'){
            switch($request->semester){
                case '1st Semester':
                    $startMonth = 1;
                    $endMonth = 6;
                break;
                case '2nd Semester':
                    $startMonth = 7;
                    $endMonth = 12;
                break;
            }
        }

        $query = Customer::query()->select('id','name','is_main','name_id','agency_id')->with('customer_name:id,name,has_branches');
        $query->withCount(['tsrs' => function ($query) use ($year,$month,$laboratory,$startMonth,$endMonth){
            $query->whereIn('status_id', [3,4]);
            ($laboratory) ? $query->where('laboratory_id',$laboratory) : '';
            ($year) ? $query->whereYear('created_at',$year) : '';
            ($month) ? $query->whereMonth('created_at',$month) : '';
            $query->when(isset($startMonth) && isset($endMonth), function ($query) use ($startMonth, $endMonth) {
                $query->whereBetween(\DB::raw('MONTH(created_at)'), [$startMonth, $endMonth]);
            });
        }])
        ->orderBy('tsrs_count', $sort);
        $data = ($request->type == 'tsr') ? $query->paginate(10) : $query->take(5)->get();
        return [
            'data' => DefaultResource::collection($data),
            'total_tsrs' => Tsr::when($month, fn($q) => $q->whereMonth('created_at', $month))->whereYear('created_at',$year)->whereIn('status_id', [3,4])->count()
        ];
    }
}
