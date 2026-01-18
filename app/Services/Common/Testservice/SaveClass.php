<?php

namespace App\Services\Common\Testservice;

use App\Models\Testservice;
use App\Models\TestserviceName;
use App\Models\TestserviceMethod;

class SaveClass
{
    public function create($request){
        $service = Testservice::create(array_merge($request->all(),[
            'agency_id' => $this->agency,
            'is_active' => 0
        ]));
        return [
            'data' => $service,
            'message' => 'Testservice creation was successful!', 
            'info' => "You've successfully created the new testservice."
        ];
    }

    public function name($request){
        $name = TestserviceName::create($request->all());
        $data = TestserviceName::findOrFail($name->id);
        $data = [
            'value' => $data->id,
            'name' => $data->name,
        ];
        return $data;
    }

    public function method($request){
        $method = TestserviceMethod::create($request->all());
        $data = TestserviceMethod::with('method')->where('id',$method->id)->first();
        return $data;
    }

    public function fee($request){
        $data = Testservice::findOrFail($request->id);
        $fee = $data->fees()->create($request->all());
        return [
            'data' => $fee,
            'message' => 'Additional fee added was successful!', 
            'info' => "You've successfully added additional fee."
        ];
    }
}
