<?php

namespace App\Services;

use App\Models\Agency;
use App\Models\AgencyDiscount;
use App\Models\AgencyFacilityLaboratory;
use App\Models\TestserviceAddon;

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
                'number' => $item->discount->value,
                'type' => $item->discount->type->name,
                'based' => $item->discount->based->name,
                'subtype' => $item->discount->subtype->name
            ];
        });
        return $data;
    }

    public function laboratories(){
        $data = AgencyFacilityLaboratory::with('laboratory')
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
                'fee' => $item->fee
            ];
        });
        return $data;
    }
}
