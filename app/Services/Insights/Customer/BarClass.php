<?php

namespace App\Services\Insights\Customer;

use App\Models\Customer;

class BarClass
{
    public function data($request){
        $year = ($request->year) ? $request->year : date('Y') ;
        $laboratory = $request->laboratory;
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $first = []; 
        for($month = 1; $month <= 12; $month++){
            $count = Customer::where('is_new',1)
            ->whereMonth('created_at',$month)->whereYear('created_at',$year)
            ->where('is_active',1)->count();
            $first[] = $count;
        }
        $second = [];
        for($month = 1; $month <= 12; $month++){
            $count = Customer::whereHas('tsrs', function ($query) use ($year,$month) {
                $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
            })
            ->count();
            $second[] = $count;
        }
        $third = [];
        for($month = 1; $month <= 12; $month++){
            $count = Customer::whereYear('created_at', '<', $year) 
            ->whereHas('tsrs', function ($query) use ($year,$month){
                $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
            })
            ->count();
            $third[] = $count;
        }

        $arr = [
            [
                'name' => 'New Customer',
                'data' => $first
            ],
            [
                'name' => 'Active Customer', 
                'data' => $second
            ],
            [
                'name' => 'Old Customer', 
                'data' => $third
            ]
        ];
        
        return $y =[
            'categories' => $months,
            'lists' => $arr,
        ];
    }

}
