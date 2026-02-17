<?php

namespace App\Services\Finance;

use App\Models\AgencyConfiguration;
use App\Models\FinanceOrseries;
use App\Http\Resources\DefaultResource;

class OrseriesClass
{
    public function __construct()
    {
        $this->facility = (\Auth::check()) ? \Auth::user()->profile?->facility_id : null;
        $this->configuration = AgencyConfiguration::first();
    }

    public function lists($request){
        $data = FinanceOrseries::with('user.profile')
        ->when($request->keyword, function ($query, $keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        })
        ->when(true, function ($query) {
            if ($this->province) {
                // Province is set: match province_code
                $query->whereHas('user.myroles', function ($q) {
                    $q->whereNotNull('province_code')
                      ->where('province_code', $this->province);
                });
            } else {
                // Province is not set: exclude users with any role that has a province_code
                $query->whereDoesntHave('user.myroles', function ($q) {
                    $q->whereNotNull('province_code');
                });
            }
        })
        ->where('user_id',\Auth::user()->id) // only this user see
        ->orderBy('is_active','DESC')
        ->paginate($request->count);
        return DefaultResource::collection($data);
    }

    public function save($request){
        $data = FinanceOrseries::create(array_merge($request->all(),[
            'user_id' => \Auth::user()->id,
            'is_finished' => 0,
            'agency_id' => $this->agency
        ]));
           
        return [
            'data' => new DefaultResource($data),
            'message' => 'Orseries creation was successful!', 
            'info' => "You've successfully created a orseries."
        ];
    }

    public function update($request){
        $data = FinanceOrseries::where('id',$request->id)->first();
        $data->update($request->all());

        return [
            'data' => new DefaultResource($data),
            'message' => 'Orseries update was successful!', 
            'info' => "You've successfully updated the selected orseries."
        ];
    }

}
