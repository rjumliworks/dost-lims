<?php

namespace App\Services\Executive\Agency;

use Hashids\Hashids;
use App\Models\Member;
use App\Models\Agency;
use App\Http\Resources\Executive\AgencyResource;

class ViewClass
{
    public function lists($request){
        $data = AgencyResource::collection(
            Agency::with('member:id,name','type:id,name','configuration','facilities','discounts')->orderBy('is_active','DESC')->paginate($request->count)
        );
        return $data;
    }

    public function members(){
        $data = Member::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'acronym' => $item->acronym,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = new AgencyResource(
            Agency::with('member','type','configuration',
            'facilities.region','facilities.province','facilities.municipality','facilities.barangay','facilities.laboratories.laboratory.fees',
            'facilities.signatories','facilities.signatories.accountant.profile','facilities.signatories.cashier.profile',
            'address','fees','discounts.discount')
            ->where('id',$id)->first()
        );

        $laboratories = $data->facilities
        ->flatMap->laboratories
        ->pluck('laboratory')
        ->unique('id')
        ->values();
        return [$data,$laboratories];
    }
}
