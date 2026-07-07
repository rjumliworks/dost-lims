<?php

namespace App\Services\Major\Analysis;

use App\Models\Package;
use App\Models\TsrAnalysis;
use App\Models\SampleName;
use App\Models\SampleType;
use App\Models\Testservice;
use App\Http\Resources\Common\Package\IndexResource;
use App\Http\Resources\Major\Analysis\TestserviceResource;

class ViewClass
{
    public function check($request){
        $tsr_id = $request->tsr_id;
        $count = TsrAnalysis::whereHas('sample',function ($query) use ($tsr_id){
            $query->whereHas('tsr',function ($query) use ($tsr_id){
                $query->where('id',$tsr_id);
            });
        })->whereIn('status_id',[10,11])->count();

        return $count;
    }

    public function testservices($request){
        $keyword = $request->keyword;
        $type = $request->type;
        
        if($type == 'Packages'){
            $data = Package::with('testservices.testservice.method.method','testservices.testservice.method.reference','testservices.testservice.testname')
            ->where('laboratory_id', $request->laboratory_id)
            ->where('is_active', 1)
            ->get();

            return IndexResource::collection($data);
        }else if($type == 'Tagged to Sample'){
            $sampletypes = $request->sampletypes;
            
            if(count($sampletypes) > 0){
                if(isset($request->samplenames)){
                    $samplenames = $request->samplenames;
                    $hasSampleNames = Testservice::query()
                    ->whereHas('samples', function ($q) use ($samplenames) {
                        $q->whereIn('sampleable_id', $samplenames)
                        ->where('sampleable_type', SampleName::class);
                    })
                    ->exists();
                }else{
                    $samplenames = null;
                    $hasSampleNames = false;
                }
                $data = TestserviceResource::collection(
                    Testservice::query()
                        ->with('method.method','method.reference','laboratory')
                        ->whereHas('samples', function ($q) use ($sampletypes, $samplenames, $hasSampleNames) {

                            if ($hasSampleNames) {
                                // ONLY sample names
                                $q->whereIn('sampleable_id', $samplenames)
                                ->where('sampleable_type', SampleName::class);
                            } else {
                                // fallback to sample types
                                $q->whereIn('sampleable_id', $sampletypes)
                                ->where('sampleable_type', SampleType::class);
                            }

                        })
                        ->when($request->ids, function ($query, $ids) {
                            $query->whereNotIn('id', $ids);
                        })
                        ->withWhereHas('testname', function ($query) use ($keyword){
                            $query->when($keyword, function ($query, $keyword) {
                                $query->where('name', 'LIKE', "%{$keyword}%")
                                    ->orWhere('short', 'LIKE', "%{$keyword}%");
                            });
                        })
                        ->where('laboratory_id', $request->laboratory_id)
                        ->where('is_active', 1)
                        ->get()
                );
            }else{
                $data = [];
            }
        }else{
            if($keyword){
                $data = TestserviceResource::collection(
                    Testservice::query()
                    ->with('method.method','method.reference','laboratory')
                    ->when($request->ids, function ($query, $ids) {
                        $query->whereNotIn('id', $ids);
                    })
                    ->withWhereHas('testname', function ($query) use ($keyword){
                        $query->when($keyword, function ($query, $keyword) {
                            $query->where('name', 'LIKE', "%{$keyword}%")->orWhere('short', 'LIKE', "%{$keyword}%");
                        });
                    })
                    ->where('laboratory_id',$request->laboratory_id)
                    ->where('is_active',1)
                    ->get()
                );
            }else{
                $data = [];
            }
        }
        return $data;
    }
}
