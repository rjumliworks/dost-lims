<?php

namespace App\Services\Major\Testreport;

use Hashids\Hashids;
use App\Models\UserRole;
use App\Models\TsrSample;
use App\Models\TsrSampleReport;
use App\Models\ListLaboratory;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
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
            ->with('tsr','user:id','user.profile:user_id,firstname,lastname,middlename,suffix_id')
            ->with('signatory.analyzed:id','signatory.analyzed.profile:user_id,firstname,middlename,lastname,suffix_id')
            ->with('signatory.certified:id','signatory.certified.profile:user_id,firstname,middlename,lastname,suffix_id')
            ->with('signatory.approved:id','signatory.approved.profile:user_id,firstname,middlename,lastname,suffix_id')
            // ->with('sample.analyses:testservice_id,sample_id','sample.analyses.testservice:id,testname_id','sample.analyses.testservice.testname:id,name')
            ->where('id',$id[0])
            ->first()
        );

        return $data;
    }

    public function count(){
        $count = TsrSample::where('is_completed', 1)
        ->doesntHave('report')
        // ->doesntHave('reportlist')
        ->whereHas('tsr', function ($query) {
            $query->where('status_id','!=',5);
        })
        ->count();
        return $count;
    }

    public function list($request,$laboratory){
        $isLaboratoryHead = \Auth::user()->roles()
            ->where('name', 'Laboratory Head')
            ->where('user_roles.is_active', 1)
            ->exists();

        $facilityScope = $isLaboratoryHead ? $request->facility : \Auth::user()->profile?->facility_id;

        $scopeToTsr = function ($query) use ($laboratory, $request, $isLaboratoryHead, $facilityScope) {
            $query->when($facilityScope, function ($query, $facility) {
                (is_array($facility)) ? $query->whereIn('facility_id',$facility) : $query->where('facility_id',$facility);
            });

            if($isLaboratoryHead){
                $query->when($request->laboratory, function ($query, $labtype) {
                    (is_array($labtype)) ? $query->whereIn('laboratory_id',$labtype) : $query->where('laboratory_id',$labtype);
                });
            }else{
                $query->when($laboratory, function ($query, $labtype) {
                    $query->whereIn('laboratory_id',$labtype);
                });
            }
        };

        if($request->status == 'with'){
            $data = WithReportResource::collection(
                TsrSampleReport::query()
                ->with('lists.sample:id,code','lists.sample.analyses:testservice_id,sample_id','lists.sample.analyses.testservice:id,testname_id','lists.sample.analyses.testservice.testname:id,name')
                ->with('tsr','user.profile')
                ->with('signatory.analyzed.profile:id,firstname,middlename,lastname,suffix_id','signatory.status')
                ->when($request->keyword, function ($query, $keyword) {
                    $query->where('code', 'LIKE', "%{$keyword}%");
                    $query->orWhereHas('tsr', function ($query) use ($keyword){
                        $query->where('code', 'LIKE', "%{$keyword}%");
                    });
                    $query->orWhereHas('lists', function ($query) use ($keyword){
                        $query->whereHas('sample', function ($q) use ($keyword){
                            $q->where('code', 'LIKE', "%{$keyword}%");
                        });
                    });
                })
                ->when($request->analyst, function ($query, $analyst) {
                    $query->where('user_id',$analyst);
                })
                ->whereHas('tsr', $scopeToTsr)
                ->orderBy('created_at','DESC')
                ->paginate($request->count)
            );
        }else{
            $data = NoReportResource::collection(
                TsrSample::where('is_completed',1)
                ->doesntHave('report')
                ->doesntHave('reportlist')
                ->withWhereHas('tsr', function ($query) use ($scopeToTsr) {
                    $query->where('status_id','!=',5);
                    $scopeToTsr($query);
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
            ->where('is_completed', 1)
            ->doesntHave('report')
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

    public function analysts($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);
        
        $data = UserRole::with('user.profile')
        ->whereHas('user', function ($query){
            // $query->where('is_active',1);
        })
        ->whereIn('role_id',[3,5,10])
        ->select('user_id')   
        ->distinct()         
        ->get()->map(function ($item) {
            return [
                'value' => $item->user_id,
                'name' => $item->user->profile->firstname.' '.$item->user->profile->lastname
            ];
        });
        return $data;
    }

    public function reports($request){
        $code = $request->keyword;
        $year = $request->year;
        $laboratory = $request->laboratory;

        $data = TsrSample::with('tsr')
            ->whereHas('tsr', function ($query) use ($year,$laboratory){
                $query->whereYear('created_at',$year)->where('laboratory_id',$laboratory);
            })
            ->when($code, function ($query) use ($code){
                $query->where(function ($q) use ($code) {
                    $q->where('code', 'LIKE', "%{$code}%")
                        ->orWhereHas('tsr', function ($q) use ($code) {
                            $q->where('code', 'LIKE', "%{$code}%");
                        });
                });
            })
            ->whereYear('created_at','!=',2024)
            ->where('is_completed', 1)
            ->doesntHave('report')
            ->whereHas('analyses', function ($query) {
                $query->where('status_id', 12);
            })
            ->get()->map(function ($item) {
                $tsr = $item->tsr_id;
                $related = TsrSample::with('tsr')->whereHas('tsr', function ($query) use ($tsr){
                    $query->where('id',$tsr);
                })
                ->where('is_completed', 1)
                ->doesntHave('report')
                ->whereHas('analyses', function ($query) {
                    $query->where('status_id', 12);
                })
                ->where('id', '!=', $item->id)
                ->get()->map(function ($item1) {
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
        });
        return $data;
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

    public function qrcode($request){
        $id = $request->id;
        $url = $_SERVER['HTTP_HOST'].'/verification/sample/'.$id;
        $result = new Builder(
            writer: new PngWriter(),
            data: $url,
            size: 120,
            margin: 0,
        );

        $qrCodeImageString = $result->build()->getString();
        $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

        return response($qrCodeImageString)
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'inline; filename="sample_qrcode.png"');
    }

     public function laboratories(){
        $laboratories = ListLaboratory::whereIn('id',$this->labs())->get()
        ->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $laboratories;
    }

    private function labs(){
        return UserRole::where('user_id',auth()->id())->whereIn('role_id',[3,5,10])->where('is_active',1)->pluck('laboratory_id');
    }
}
