<?php

namespace App\Services\Executive\Agency;

use Hashids\Hashids;
use App\Models\Member;
use App\Models\Agency;
use App\Models\AgencyFacility;
use App\Models\ListData;
use App\Models\TsrSequence;
use App\Models\User;
use App\Models\UserFacilityVisibility;
use App\Services\Common\FacilityVisibility;
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
            'address','fees','discounts.discount','accounts','funds')
            ->where('id',$id)->first()
        );

        $laboratories = $data->facilities
        ->flatMap->laboratories
        ->pluck('laboratory')
        ->unique('id')
        ->values();
        return [$data,$laboratories];
    }

    public function sequences($id){
        $hashids = new Hashids('krad',10);
        $agencyId = $hashids->decode($id)[0] ?? null;

        $facilities = AgencyFacility::with('laboratories.laboratory')->where('agency_id',$agencyId)->get();
        $types = ListData::where('type','Sequence')->where('is_active',1)->orderBy('id')->get();
        $year = date('Y');

        $sequences = TsrSequence::withoutGlobalScope('agency')
            ->where('agency_id',$agencyId)
            ->where('year',$year)
            ->get();

        // Quotation sequences are tracked per facility only (laboratory_id is a
        // placeholder), so they're looked up ignoring laboratory_id.
        $existingByLab = $sequences->keyBy(fn($sequence) => $sequence->facility_id.'-'.$sequence->laboratory_id.'-'.$sequence->type_id);
        $existingByFacility = $sequences->keyBy(fn($sequence) => $sequence->facility_id.'-'.$sequence->type_id);

        $rows = [];
        foreach($facilities as $facility){
            foreach($types as $type){
                $isQuotation = strtolower($type->name) === 'quotation';

                if($isQuotation){
                    $sequence = $existingByFacility->get($facility->id.'-'.$type->id);
                    $rows[] = [
                        'facility_id' => $facility->id,
                        'facility_name' => $facility->name,
                        'is_regional' => (bool) $facility->is_regional,
                        'laboratory_id' => null,
                        'laboratory_name' => null,
                        'laboratory_short' => null,
                        'type_id' => $type->id,
                        'type_name' => $type->name,
                        'year' => $year,
                        'sequence_id' => $sequence->id ?? null,
                        'next_sequence' => $sequence->next_sequence ?? null,
                    ];
                    continue;
                }

                foreach($facility->laboratories as $facilityLaboratory){
                    if(!$facilityLaboratory->laboratory) continue;
                    $laboratory = $facilityLaboratory->laboratory;
                    $sequence = $existingByLab->get($facility->id.'-'.$laboratory->id.'-'.$type->id);
                    $rows[] = [
                        'facility_id' => $facility->id,
                        'facility_name' => $facility->name,
                        'is_regional' => (bool) $facility->is_regional,
                        'laboratory_id' => $laboratory->id,
                        'laboratory_name' => $laboratory->name,
                        'laboratory_short' => $laboratory->short,
                        'type_id' => $type->id,
                        'type_name' => $type->name,
                        'year' => $year,
                        'sequence_id' => $sequence->id ?? null,
                        'next_sequence' => $sequence->next_sequence ?? null,
                    ];
                }
            }
        }

        return $rows;
    }

    public function visibility($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->user)[0] ?? null;

        $user = User::with('profile.facility')->findOrFail($id);

        return [
            'user' => $request->user,
            'facility_ids' => FacilityVisibility::effectiveFacilityIds($user),
            'default_facility_ids' => FacilityVisibility::defaultFacilityIds($user),
            'is_customized' => UserFacilityVisibility::where('user_id', $user->id)->exists(),
        ];
    }
}
