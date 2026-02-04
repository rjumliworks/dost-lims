<?php

namespace App\Services\Major\Analysis;

use App\Models\SampleType;
use App\Models\Testservice;
use App\Http\Resources\Major\Analysis\TestserviceResource;

class ViewClass
{
    public function testservices($request){
        $keyword = $request->keyword;
        $sampletypes = $request->sampletypes;
        if(count($sampletypes) > 0){
            $data = TestserviceResource::collection(
                Testservice::query()
                ->with('method.method','method.reference','laboratory')
                ->whereHas('samples', function ($q) use ($sampletypes) {
                    $q->whereIn('sampleable_id', $sampletypes)->where('sampleable_type', SampleType::class);
                })
                ->when($request->ids, function ($query, $ids) {
                    $query->whereNotIn('id', $ids);
                })
                ->withWhereHas('testname', function ($query) use ($keyword){
                    $query->when($keyword, function ($query, $keyword) {
                        $query->where('name', 'LIKE', "%{$keyword}%")->orWhere('short', 'LIKE', "%{$keyword}%");
                    });
                })
                ->where('laboratory_id',$request->laboratory_id)
                // ->where('is_active',1)
                ->get()
            );
        }else{
            $data = [];
        }
        return $data;
    }
}
