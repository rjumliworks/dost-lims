<?php

namespace App\Services\Executive\Agency;

use App\Models\Agency;
use App\Models\AgencyFacility;
use App\Models\AgencyConfiguration;
use App\Models\AgencyFacilitySignatory;
use App\Models\AgencyFacilityLaboratory;
use App\Models\ListLaboratory;
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

    public function signatory($request){
        $data = AgencyFacilitySignatory::where('facility_id',$request->id)->first();
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
}
