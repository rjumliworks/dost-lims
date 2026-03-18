<?php

namespace App\Services\Insights\Customer;

use App\Models\Tsr;

class LocationClass
{
    public function data($request)
    {
        $year = $request->year;
        $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = date('m'); // current month (01–12)
        } else {
            $month = date('m', strtotime($monthInput));
        }

        $query = Tsr::whereIn('id', function ($query) use ($year,$month) {
            $query->selectRaw('MIN(id)')
                ->from('tsrs')
                ->where('status_id','!=',5)
                ->whereYear('created_at', $year)
                ->groupBy('customer_id');
        })
        ->with([
            'customer.address.province','customer.address.municipality',
            'customer.address.barangay:code,name,district_code',
            'customer.address.barangay.district:code,name',
            'customer:id,name,sex_id,name_id,is_new',
            'customer.sex',
            'customer.customer_name:id,name,classification_id,type_id',
            'customer.customer_name.type:id,name',
            'customer.customer_name.classification:id,name',
            'payment'
        ])
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->orderBy('created_at','ASC');

        return $query->get()->map(function ($item) {
            $municipality = optional($item->customer->address->municipality)->name;
            $province     = optional($item->customer->address->province)->name;
            
            $isZamboangaProvince = in_array($province, [
                'Zamboanga Del Norte', 
                'Zamboanga Del Sur', 
                'Zamboanga Sibugay'
            ]);
            $barangayDistrict = optional($item->customer->address->barangay->district)->name;
            
            // Get municipality district only for Zamboanga provinces
            if ($isZamboangaProvince) {
                $municipalityDistrict = optional($item->customer->address->municipality)->district;
            }

            $classification = optional($item->customer->customer_name->classification)->name;
            $sex = optional($item->customer->sex)->name;
            $type = optional($item->customer->customer_name->type)->name;

            $ic   = $municipality === 'Isabela City';
            $zc   = $municipality === 'Zamboanga City';
            $sulu = $province === 'Sulu';
            $zdn  = $province === 'Zamboanga Del Norte';
            $zds  = $province === 'Zamboanga Del Sur' && !$zc;
            $zsp  = $province === 'Zamboanga Sibugay';

            // Initialize district flags
            $zcFirstDistrict = false;
            $zcSecondDistrict = false;
            $provinceFirstDistrict = false;
            $provinceSecondDistrict = false;
            
            // For Zamboanga City: use barangay district
            if ($zc) {
                $zcFirstDistrict = $barangayDistrict === '1st';
                $zcSecondDistrict = $barangayDistrict === '2nd';
            }
            
            // For Zamboanga provinces: use municipality district
            if ($isZamboangaProvince && isset($municipalityDistrict)) {
                $districtStr = (string) $municipalityDistrict;
                if (strpos($districtStr, '1') !== false || $districtStr === '1') {
                    $provinceFirstDistrict = true;
                } elseif (strpos($districtStr, '2') !== false || $districtStr === '2') {
                    $provinceSecondDistrict = true;
                }else if (strpos($districtStr, '3') !== false || $districtStr === '3'){
                    $provinceThirdDistrict = true;
                }
            }

            $male = false;
            $female = false;
            $student = false;
            $senior = false;
            $pwd = false;
            $paying = false;
            $nonpay = false;

            if ($classification === 'Firm') {
                // if($item->customer->payment->discount == )
                if($item->payment->is_free == 1){
                    $paying = false;
                    $nonpay = true;
                }else{
                    $paying = true;
                    $nonpay = false;
                }
            } elseif ($classification === 'Individual') {
                // Check sex
                if ($sex === 'Male') {
                    $male = true;
                    $female = false;
                } elseif ($sex === 'Female') {
                    $male = false;
                    $female = true;
                }
                
                // Check type
                if ($type === 'Student') {
                    $student = true;
                } elseif ($type === 'Senior Citizen') {
                    $senior = true;
                } elseif ($type === 'Person with Disability') {
                    $pwd = true;
                }
            }

            $zdn1 = false;
            $zdn2 = false;
            $zdn3 = false;
            $zds1 = false;
            $zds2 = false;
            $zsp1 = false;
            $zsp2 = false;

            if ($zdn) {
                if ($provinceFirstDistrict) {
                    $zdn1 = true;
                    $zdn2 = false;
                    $zdn3 = false;
                } elseif ($provinceSecondDistrict) {
                    $zdn1 = false;
                    $zdn2 = true;
                    $zdn3 = false;
                }elseif ($provinceThirdDistrict) {
                    $zdn1 = false;
                    $zdn2 = false;
                    $zdn3 = true;
                }
            }

            // Check district for Zamboanga Del Sur (excluding Zamboanga City)
            if ($zds) {
                if ($provinceFirstDistrict) {
                    $zds1 = true;
                    $zds2 = false;
                } elseif ($provinceSecondDistrict) {
                    $zds1 = false;
                    $zds2 = true;
                }
            }

            // Check district for Zamboanga Sibugay
            if ($zsp) {
                if ($provinceFirstDistrict) {
                    $zsp1 = true;
                    $zsp2 = false;
                } elseif ($provinceSecondDistrict) {
                    $zsp1 = false;
                    $zsp2 = true;
                }
            }
            $name = ($item->customer->name == 'Main') ? '' : ' - '.$item->customer->name;

            return [
                'name' => $item->customer->customer_name->name.' '.$name,
                'ic'   => $ic,
                'sulu' => $sulu,
                'zc1'  => $zc && $zcFirstDistrict,  // Use barangay district for ZC
                'zc2'  => $zc && $zcSecondDistrict, // Use barangay district for ZC
                'zdn1' => $zdn1,
                'zdn2' => $zdn2,
                'zdn3' => $zdn3,
                'zds1' => $zds1,
                'zds2' => $zds2,
                'zsp1' => $zsp1,
                'zsp2' => $zsp2,
                'outside' => !($ic || $zc || $sulu || $zdn || $zds || $zsp),
                'paying' => $paying,
                'nonpay' => $nonpay,
                'male' => $male,
                'female' => $female,
                'student' => $student,
                'senior' => $senior,
                'pwd' => $pwd,
                'isnew' => is_null($item->customer->is_new)
                ? 'none'
                : ($item->customer->is_new == 1 ? 'yes' : 'no'),
            ];
        });
    }
}
