<?php

namespace App\Services;

use App\Models\Agency;
use App\Models\AgencyDiscount;
use App\Models\AgencyFacility;
use App\Models\AgencyFacilityLaboratory;
use App\Models\TestserviceAddon;
use Illuminate\Support\Facades\Auth;

class AgencyClass
{
    public function all(){
        $data = Agency::with('member')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->member->name,
                'short' => $item->name
            ];
        });
        return $data;
    }

    public function discounts(){
        $data = AgencyDiscount::with('discount')->where('is_active',1)->get()->map(function ($item) {
            $total = ($item->discount->subtype->name == 'Percentage') ? $item->discount->value.'%' : '₱'.$item->discount->value;
            $name = ($item->discount->name === 'Regular') ? $item->discount->name : $item->discount->name.' ('.$total.')';
            return [
                'value' => $item->discount->id,
                'name' => $name,
                'is_individual' => $item->discount->is_individual,
                'number' => $item->discount->value,
                'type' => $item->discount->type->name,
                'based' => $item->discount->based->name,
                'subtype' => $item->discount->subtype->name
            ];
        });
        return $data;
    }

    public function facilities(){
        $agencyId = Auth::user()->profile?->agency_id;
        $data = AgencyFacility::where('agency_id', $agencyId)
        ->where('is_active',1)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function laboratories($facility = null){
        $data = AgencyFacilityLaboratory::with('laboratory')
        ->when($facility, function ($query) use ($facility) {
            $query->where('facility_id', $facility);
        })
        ->select('laboratory_id')
        ->distinct()
        ->get()->map(function ($item) {
            return [
                'value' => $item->laboratory_id,
                'name' => $item->laboratory->name
            ];
        });
        return $data;
    }

    public function services(){
        $data = TestserviceAddon::where('is_additional',0)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'label' => $item->name.' ('.$item->description.')',
                'name' => $item->name,
                'description' => $item->description,
                'is_onsite' => $item->is_onsite,
                'fee' => $item->fee
            ];
        });
        return $data;
    }
}
