<?php

namespace App\Services\Major\Testreport;

use Hashids\Hashids;
use App\Models\TsrSample;
use App\Models\TsrSampleReport;
use App\Http\Resources\Major\Testreport\WithReportResource;
use App\Http\Resources\Major\Testreport\NoReportResource;

class ViewClass
{
    public function testreport($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        $data = new WithReportResource(
            TsrSampleReport::query()
            ->with('lists.sample:id,code','lists.sample.analyses:testservice_id,sample_id','lists.sample.analyses.testservice:id,testname_id','lists.sample.analyses.testservice.testname:id,name')
            ->with('sample.tsr','user:id','user.profile:user_id,firstname,lastname,middlename,suffix_id')
            ->with('signatory.user:id','signatory.user.profile:user_id,firstname,middlename,lastname,suffix_id')
            ->with('sample.analyses:testservice_id,sample_id','sample.analyses.testservice:id,testname_id','sample.analyses.testservice.testname:id,name')
            ->where('id',$id[0])
            ->first()
        );

        return $data;
    }

    public function count(){
        $count = TsrSample::where('is_completed', 1)
        ->doesntHave('report')
        ->doesntHave('reportlist')
        ->whereHas('tsr', function ($query) {
            $query->where('status_id','!=',5);
        })
        ->count();
        return $count;
    }

    public function list($request){
        if($request->status == 'with'){
            $data = WithReportResource::collection(
                TsrSampleReport::query()
                ->with('lists.sample:id,code','lists.sample.analyses:testservice_id,sample_id','lists.sample.analyses.testservice:id,testname_id','lists.sample.analyses.testservice.testname:id,name')
                ->with('sample.tsr','user.profile')
                ->with('signatory.analyzed.profile:id,firstname,middlename,lastname,suffix_id')
                ->with('sample.analyses:testservice_id,sample_id','sample.analyses.testservice:id,testname_id','sample.analyses.testservice.testname:id,name')
                ->when($request->keyword, function ($query, $keyword) {
                    $query->where('code', 'LIKE', "%{$keyword}%");
                    $query->orWhereHas('sample', function ($query) use ($keyword){
                        $query->where('code', 'LIKE', "%{$keyword}%");
                        $query->orwhereHas('tsr', function ($query) use ($keyword){
                            $query->where('code', 'LIKE', "%{$keyword}%");
                            $query->when($this->laboratory, function ($query) {
                                if(in_array(4, $this->role->toArray(), false)){
                                    $query->whereIn('laboratory_id',$this->laboratory);
                                }
                            });
                        });
                    });
                })
                ->when($request->analyst, function ($query, $analyst) {
                    $query->where('user_id',$analyst);
                })
                ->whereHas('sample', function ($query) use ($request){
                    $query->whereHas('tsr', function ($query) use ($request){
                        $query->when($request->laboratory , function ($query, $labtype) {
                            $query->where('laboratory_id',$labtype);
                        });
                    });
                })
                ->orderBy('created_at','DESC')
                ->paginate($request->count)
            );
        }else{
            $data = NoReportResource::collection(
                TsrSample::where('is_completed',1)
                ->doesntHave('report')
                ->doesntHave('reportlist')
                ->withWhereHas('tsr', function ($query) {
                    $query->where('status_id','!=',5);
                })
                ->when($request->id, function ($query, $id) {
                    $query->where('id',$id);
                })
                ->orderBy('created_at','DESC')
                ->paginate($request->count)
            );
        }
        return $data;
    }

    public function samples($request)
    {
        $item = TsrSample::with('tsr')
            ->whereYear('created_at', 2026)
            ->where('is_completed', 1)
            ->doesntHave('report')
            ->doesntHave('reportlist')
            ->whereHas('analyses', function ($query) {
                $query->where('status_id', 12);
            })
            ->when($request->id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->first();

        if (!$item) {
            return null; // or return []
        }

        $tsr = $item->tsr_id;

        $related = TsrSample::with('tsr')
            ->whereHas('tsr', function ($query) use ($tsr) {
                $query->where('id', $tsr);
            })
            ->where('is_completed', 1)
            ->doesntHave('report')
            ->doesntHave('reportlist')
            ->whereHas('analyses', function ($query) {
                $query->where('status_id', 12);
            })
            ->where('id', '!=', $item->id)
            ->get()
            ->map(function ($item1) {
                return [
                    'value' => $item1->id,
                    'report' => null,
                    'name' => $item1->code,
                    'selected' => null
                ];
            });

        return [
            'value' => $item->id,
            'report' => null,
            'name' => $item->code,
            'related' => $related,
            'selected' => null,
            'laboratory_id' => $item->tsr->laboratory_id
        ];
    }

    // public function samples($request){

    //     $data = TsrSample::with('tsr')
    //         ->whereYear('created_at',2026)
    //         ->where('is_completed', 1)
    //         ->doesntHave('report')
    //         ->doesntHave('reportlist')
    //         ->whereHas('analyses', function ($query) {
    //             $query->where('status_id', 12);
    //         })
    //         ->when($request->id, function ($query,$id) {
    //             $query->where('id',$id);
    //         })
    //         ->get()->map(function ($item) {
    //             $tsr = $item->tsr_id;
    //             $related = TsrSample::with('tsr')->whereHas('tsr', function ($query) use ($tsr){
    //                 $query->where('id',$tsr);
    //             })
    //             ->where('is_completed', 1)
    //             ->doesntHave('report')
    //             ->doesntHave('reportlist')
    //             ->whereHas('analyses', function ($query) {
    //                 $query->where('status_id', 12);
    //             })
    //             ->where('id', '!=', $item->id)
    //             ->get()->map(function ($item1) {
    //                 return [
    //                     'value' => $item1->id,
    //                     'report' => null,
    //                     'name' => $item1->code,
    //                     'selected' => null
    //                 ];
    //             });
    //         return [
    //             'value' => $item->id,
    //             'report' => null,
    //             'name' => $item->code,
    //             'related' => $related,
    //             'selected' => null,
    //             'laboratory_id' => $item->tsr->laboratory_id
    //         ];
    //     });
    //     return $data;
    // }
}
