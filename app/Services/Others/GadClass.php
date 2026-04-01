<?php

namespace App\Services\Others;

use App\Models\Tsr;

class GadClass
{
    public function numbers(){
        $year = 2026;
        $types = [
            ['id' => 82, 'name' => 'Male'],
            ['id' => 83, 'name' => 'Male-led'],
            ['id' => 73, 'name' => 'Female'],
            ['id' => 74, 'name' => 'Female-led']
        ];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $result = [];

        foreach($types as $index => $type){
            $monthlyTotals = [];
            $typeTotal = 0;
            foreach($months as $index => $month){
                $total = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free',0);
                })
                ->whereHas('customer', function ($query) use ($type){
                    $query->where('led_id',$type['id'])
                    ->orWhere(function ($sub) use ($type) {
                        if($type['name'] == 'Male'){
                            $sub->whereNull('led_id')->where('sex_id', 70);
                        }else if($type['name'] == 'Female'){
                            $sub->whereNull('led_id')->where('sex_id', 71);
                        }
                    });
                })
                ->where('status_id','!=',5)
                ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                ->where('agency_id',14)
                ->get()
                ->count();
                $monthlyTotals[] = $total;
                $typeTotal += $total;
            }
            $result[] = [
                'name' => $type['name'],
                'monthly' => $monthlyTotals,
                'total' => $typeTotal
            ];
        }
        return $result;
    }

    public function transactions(){
        $year = 2026;
        $types = [
            ['id' => 82, 'name' => 'Male'],
            ['id' => 83, 'name' => 'Male-led'],
            ['id' => 73, 'name' => 'Female'],
            ['id' => 74, 'name' => 'Female-led']
        ];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $result = [];

        foreach($types as $index => $type){
            $monthlyTotals = [];
            $typeTotal = 0;
            $totalDiscount = 0;
            foreach($months as $index => $month){
                $total = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free',0);
                })
                ->whereHas('customer', function ($query) use ($type){
                    $query->where('led_id',$type['id'])
                    ->orWhere(function ($sub) use ($type) {
                        if($type['name'] == 'Male'){
                            $sub->whereNull('led_id')->where('sex_id', 70);
                        }else if($type['name'] == 'Female'){
                            $sub->whereNull('led_id')->where('sex_id', 71);
                        }
                    });
                })
                ->where('status_id','!=',5)
                ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                ->where('agency_id',14)
                ->get();
                
                $sumTotal = $total->sum(fn($tsr) => (float) str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->total));
                $sumDiscount = $total->sum(fn($tsr) => (float) str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount));

                $monthlyTotals[] = [
                    'total' => $sumTotal,
                    'discount' => $sumDiscount,
                    'net' => $sumTotal - $sumDiscount
                ];
                $typeTotal += $sumTotal;
                $totalDiscount += $sumDiscount;
            }
            $result[] = [
                'name' => $type['name'],
                'monthly' => $monthlyTotals,
                'total' => $typeTotal,
                'discount' => $totalDiscount
            ];
        }
        return $result;
    }

    public function discounts(){
        $year = 2026;
        $types = [
            ['id' => 73, 'name' => 'Female'],
            ['id' => 74, 'name' => 'Female-led']
        ];

        $result = [];

        foreach($types as $type){
            $records = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free', 0)
                        ->where('discount_id', 9); // March-only discount
                })
                ->whereHas('customer', function ($query) use ($type){
                    $query->where('led_id', $type['id']);
                })
                ->where('status_id', '!=', 5)
                ->whereYear('created_at', $year)
                ->where('agency_id', 14)
                ->get();

            $sumTotal = $records->sum(fn($tsr) => (float) str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->total));
            $sumDiscount = $records->sum(fn($tsr) => (float) str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount));

            $result[] = [
                'name' => $type['name'],
                'transactions' => $records->count(),
                'gross' => $sumTotal,
                'discount' => $sumDiscount,
                'net' => $sumTotal - $sumDiscount
            ];
        }

        return $result;
    }


    public function chart(){
         // $code = '097200000';//zdn
        // $code = '097300000';//zds
        $code = '098300000'; //zsp 
        // 097332000 zc
        $array = [$this->city('097332000'),$this->province('097200000'),$this->province('097300000'),$this->province('098300000'),$this->province('098300000')];
        return $array;
    }

    public function province($code){
        $year = 2026;
        return Tsr::whereYear('created_at', $year)
        ->whereHas('customer.address', function ($query) use ($code) {
            $query->where('province_code', $code);
            ($code == '097300000') ? $query->where('municipality_code','!=','097332000') : '-';
        })->with('customer:id') ->get()->pluck('customer.id') ->unique() ->count();
    }

     public function city($code){
        $year = 2026;
        return Tsr::whereYear('created_at', $year)
        ->whereHas('customer.address', function ($query) use ($code) {
            $query->where('municipality_code', $code);
        })->with('customer:id') ->get()->pluck('customer.id') ->unique()->count();
    }
}
