<?php

namespace App\Services\Major\Analysis;

use App\Models\Testservice;
use App\Http\Resources\Operation\TestserviceResource;

class ViewClass
{
    public function testservices($request){
        $keyword = $request->keyword;
        if($request->sampletype_id){
            $data = TestserviceResource::collection(
                Testservice::query()
                ->when($request->sampletype_id, function ($query, $sampletype) {
                    $query->where('sampletype_id',$sampletype);
                })
                ->when($request->ids, function ($query, $ids) {
                    $query->whereNotIn('id', $ids);
                })
                // ->when($this->agency, function ($query, $agency) {
                //     $query->where('agency_id',$agency);
                // })
                 ->where('agency_id',$this->agency)
                ->with('sampletype','agency.member','agency.address.region','laboratory')
                ->with('method.method','method.reference')
                // ->with('testname')
                ->withWhereHas('testname', function ($query) use ($keyword){
                    $query->when($keyword, function ($query, $keyword) {
                        $query->where('name', 'LIKE', "%{$keyword}%")->orWhere('short', 'LIKE', "%{$keyword}%");
                    });
                })
                ->where('is_active',1)
                ->get()
            );
        }else{
            $data = [];
        }
        return $data;
    }
}
