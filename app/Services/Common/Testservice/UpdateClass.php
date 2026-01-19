<?php

namespace App\Services\Common\Testservice;

use Hashids\Hashids;
use App\Models\Testservice;
use App\Models\TestserviceAddon;
use App\Http\Resources\Common\TestserviceResource;

class UpdateClass
{
    public function fee($request){
        $data = TestserviceAddon::where('id',$request->id)->first();
        $data->name = $request->name;
        $data->fee = $request->fee;
        $data->save();

        return [
            'data' => $data,
            'message' => 'Service was successfully updated!', 
            'info' => "You've successfully updated the service details.",
        ];
    }

    public function status($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->code);

        $data = Testservice::where('id',$id)->first();
        $data->is_active = $request->is_active;
        $data->save();

        $data = Testservice::with('testname','laboratory','status','added.profile.suffix')
        ->with('method.method','method.reference')
        ->with('fees')
        ->where('id',$id)->first();
        return [
            'data' => new TestserviceResource($data),
            'message' => 'Customer Status', 
            'info' => "You've successfully updated the customer status."
        ];
    }
}
