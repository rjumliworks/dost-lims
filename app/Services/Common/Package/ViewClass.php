<?php

namespace App\Services\Common\Package;

use App\Models\Package;
use App\Http\Resources\Common\Package\IndexResource;

class ViewClass
{
    public function list($request){
        $data = Package::with('laboratory','added')
        ->with('testservices.testservice.testname','testservices.testservice.method.method','testservices.testservice.method.reference')
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'asc')
        ->paginate($request->count ?? 20);

        return IndexResource::collection($data);
    }
}
