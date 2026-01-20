<?php

namespace App\Services\Common\Package;

use Hashids\Hashids;
use App\Models\Package;
use App\Http\Resources\Common\Package\IndexResource;

class SaveClass
{
    public function package($request){
        $data = Package::create($request->all());
        if($data){
            foreach($request->lists as $list){
                $data->testservices()->create([
                    'testservice_id' => $list['id']
                ]);
            }
        }
        return [
            'data' => $data,
            'message' => 'Package was created!', 
            'info' => "You've successfully created a package."
        ];
    }

    public function status($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->code);

        $data = Package::where('id',$id)->first();
        $data->is_active = $request->is_active;
        $data->save();

        $data = Package::with('laboratory','added')
        ->with('testservices.testservice.testname','testservices.testservice.method.method','testservices.testservice.method.reference')
        ->where('id',$id)->first();
        return [
            'data' => new IndexResource($data),
            'message' => 'Package Status', 
            'info' => "You've successfully updated the customer status."
        ];
    }
}
