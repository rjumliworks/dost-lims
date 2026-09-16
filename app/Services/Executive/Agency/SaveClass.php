<?php

namespace App\Services\Executive\Agency;

use Hashids\Hashids;
use App\Models\Agency;
use App\Models\AgencyFacility;
use App\Models\AgencyConfiguration;
use App\Models\AgencyFacilitySignatory;
use App\Models\AgencyFacilityLaboratory;
use App\Models\ListLaboratory;
use App\Models\TsrSequence;
use App\Models\User;
use App\Models\UserFacilityVisibility;
use App\Services\Common\FacilityVisibility;
use App\Http\Resources\Executive\AgencyResource;

class SaveClass
{
    public function activate($request){
        $data = Agency::with('configuration')->where('id',$request->id)->first();
        $data->is_active = 1;
        if($data->save()){
            $form = [
                "time" => "update time",
                "email" => "update email",
                "address" => "update address",
                "contact" => "update contact",
                "form_name" => "update form name"
            ];
            
            $config = new AgencyConfiguration;
            $config->laboratories = [];
            $config->form = $form;
            $config->contact = [];
            $config->functionalities = AgencyConfiguration::defaultFunctionalities();
            $config->samplecode_year = 0;
            $config->agency_id = $data->id;
            $config->show_others = 0;
            $config->strict_mode = 1;
            $config->save();
        }
        $data = new AgencyResource(
            Agency::with('member','type','configuration')->where('id',$request->id)->first()
        );
        return [
            'data' => $data,
            'message' => 'Agency activation was successful!',
            'info' => "The agency is now active and has full access to the laboratory system, including test services and other features."
        ];
    }

    public function laboratories($request){
        $data = AgencyConfiguration::where('id',$request->id)->first();
        $data->laboratories = $request->laboratories;
        $data->save();

        return [
            'data' => $data,
            'message' => 'User creation was successful!', 
            'info' => "You've successfully created an account for the user."
        ];
    }

    public function settings($request){
        $data = AgencyConfiguration::where('id',$request->id)->first();
        $data->form = $request->settings;
        $data->save();

        return [
            'data' => $data,
            'message' => 'User creation was successful!', 
            'info' => "You've successfully created an account for the user."
        ];
    }

    public function functionalities($request){
        $data = AgencyConfiguration::where('id',$request->id)->first();
        $data->functionalities = $request->functionalities;
        $data->save();

        return [
            'data' => $data,
            'message' => 'Functionalities updated successfully!',
            'info' => "The agency's enabled modules have been updated."
        ];
    }

    public function printing($request){
        $data = AgencyConfiguration::where('id',$request->id)->first();
        $data->printing = ['address_format' => $request->address_format];
        $data->save();

        return [
            'data' => $data,
            'message' => 'Printing settings updated successfully!',
            'info' => "The agency's address format for printed reports has been updated."
        ];
    }

    public function visibility($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->user)[0] ?? null;
        $user = User::findOrFail($id);

        $data = UserFacilityVisibility::updateOrCreate(
            ['user_id' => $user->id],
            ['facility_ids' => $request->facility_ids ?? []]
        );

        return [
            'data' => $data,
            'message' => 'Facility visibility updated successfully!',
            'info' => "The user's visible facilities for the TSR list have been updated."
        ];
    }

    public function resetVisibility($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->user)[0] ?? null;
        $user = User::findOrFail($id);

        UserFacilityVisibility::where('user_id', $user->id)->delete();

        return [
            'data' => ['facility_ids' => FacilityVisibility::defaultFacilityIds($user)],
            'message' => 'Facility visibility reset successfully!',
            'info' => "The user's visible facilities now follow the default rule."
        ];
    }

    public function fee($request){
        $data = Agency::findOrFail($request->id);
        $data->fees()->create($request->all());
        return [
            'data' => $data,
            'message' => 'Additional fee added was successful!', 
            'info' => "You've successfully added additional fee."
        ];
    }

    public function discount($request){
        $data = Agency::findOrFail($request->agency_id);
        $data->discounts()->create($request->all());
        return [
            'data' => $data,
            'message' => 'Discount added was successful!', 
            'info' => "You've successfully added discount."
        ];
    }

    public function account($request){
        $data = Agency::findOrFail($request->agency_id);
        $data->accounts()->create($request->all());
        return [
            'data' => $data,
            'message' => 'Account added was successful!',
            'info' => "You've successfully added an account."
        ];
    }

    public function funding($request){
        $data = Agency::findOrFail($request->agency_id);
        $data->funds()->create($request->all());
        return [
            'data' => $data,
            'message' => 'Funding source added was successful!',
            'info' => "You've successfully added a funding source."
        ];
    }

    public function facility($request){
        $data = Agency::findOrFail($request->agency_id);
        $facility = $data->facilities()->create($request->all());
        $facility->signatories()->create();
        return [
            'data' => $data,
            'message' => 'Facility added was successful!', 
            'info' => "You've successfully added discount."
        ];
    }

    public function updatefacility($request){
        $data = AgencyFacility::findOrFail($request->id);
        $data->fill($request->only([
            'name','short','is_regional','is_psto','is_separated','address','longitude','latitude','barangay_code','municipality_code','province_code','region_code'
        ]));
        $data->save();

        return [
            'data' => $data,
            'message' => 'Facility updated successfully!',
            'info' => "You've successfully updated the facility."
        ];
    }

    public function signatory($request){
        $data = AgencyFacilitySignatory::firstOrCreate(['facility_id' => $request->id]);
        if($request->type == 'Cashier'){
           $data->cashier_id =  $request->user_id;
        }else{
           $data->accountant_id = $request->user_id;
        }
        $data->save();
        if($request->type == 'Cashier'){
            $data = AgencyFacilitySignatory::with('cashier.profile')->findOrFail($data->id);
        }else{
            $data = AgencyFacilitySignatory::with('accountant.profile')->findOrFail($data->id);
        }
        return [
            'data' => $data,
            'message' => 'Additional fee added was successful!', 
            'info' => "You've successfully added additional fee."
        ];
    }

   public function laboratory($request){
        $data = AgencyFacility::findOrFail($request->id);
        $facility = $data->laboratories()->create([
            'laboratory_id' => $request->laboratory_id
        ]);
        $data = AgencyFacilityLaboratory::with('laboratory')->findOrFail($facility->id);
        return [
            'data' => $data,
            'message' => 'Facility Laboratory added was successful!', 
            'info' => "You've successfully added discount."
        ];
    }

    public function addfee($request){
        $data = ListLaboratory::findOrFail($request->laboratory_id);
        $fee = $data->fees()->create($request->all());
        return [
            'data' => $fee,
            'message' => 'Additional fee added was successful!',
            'info' => "You've successfully added additional fee."
        ];
    }

    public function generateSequence($request){
        $facility = AgencyFacility::findOrFail($request->facility_id);
        $year = date('Y');
        $created = [];

        foreach($request->rows as $row){
            $isQuotation = empty($row['laboratory_id']);
            $laboratoryId = $row['laboratory_id'] ?? 1;

            $query = TsrSequence::withoutGlobalScope('agency')->where([
                'agency_id' => $facility->agency_id,
                'facility_id' => $facility->id,
                'year' => $year,
                'type_id' => $row['type_id'],
            ]);
            // Quotation sequences are tracked per facility only, so ignore laboratory_id.
            if(!$isQuotation){
                $query->where('laboratory_id', $laboratoryId);
            }
            $exists = $query->exists();

            if(!$exists){
                $created[] = TsrSequence::create([
                    'agency_id' => $facility->agency_id,
                    'facility_id' => $facility->id,
                    'laboratory_id' => $laboratoryId,
                    'year' => $year,
                    'type_id' => $row['type_id'],
                    'next_sequence' => $row['next_sequence'] ?? 1,
                ]);
            }
        }

        return [
            'data' => $created,
            'message' => 'Sequence generation was successful!',
            'info' => "You've successfully generated the missing sequences for the facility."
        ];
    }

    public function updateSequence($request){
        $data = TsrSequence::withoutGlobalScope('agency')->findOrFail($request->id);
        $data->next_sequence = $request->next_sequence;
        $data->save();

        return [
            'data' => $data,
            'message' => 'Sequence update was successful!',
            'info' => "You've successfully updated the sequence."
        ];
    }
}
