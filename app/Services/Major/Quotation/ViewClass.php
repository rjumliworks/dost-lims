<?php

namespace App\Services\Major\Quotation;

use Hashids\Hashids;
use App\Models\Quotation;
use App\Models\QuotationAnalysis;
use App\Http\Resources\Major\Quotation\ListResource;
use App\Http\Resources\Major\Quotation\ViewResource;
use App\Http\Resources\Major\Quotation\AnalysisResource;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ViewClass
{
    public function counts($statuses){
        foreach($statuses as $status){
            $counts[] = Quotation::where('status_id',$status['value'])
            // ->when($this->province, function ($query){
            //     $query->where('created_by', \Auth::user()->id);
            // })
            // ->when($this->configuration->strict_mode == 1, function ($query) {
            //     $facility = \Auth::user()->profile->facility;

            //     if ($facility->is_psto || $facility->is_separated) {
            //         $query->where('facility_id', $facility->id);
            //     }
            // })
            ->count();
        }
        return $counts;
    } 

    public function lists($request){
        $data = ListResource::collection(
            Quotation::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('received:id','received.profile:id,firstname,lastname,user_id')
            ->with('laboratory:id,name','status:id,name,color,others')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('code', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('customer', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('customer_name', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', "%{$keyword}%");
                            });
                    });
                });
            })
            ->with(['samples' => function ($query){
                $query->select('id','quotation_id');
                $query->withCount([
                    'analyses as analyses_count'
                ]);
            }])
            ->when($request->status, function ($query, $status) {
                $query->where('status_id',$status);
            })
            ->when($request->laboratory , function ($query, $labtype ) {
                (is_array($labtype)) ?  $query->whereIn('laboratory_id',$labtype ) : $query->where('laboratory_id',$labtype );
            }) 
            ->when($request->sort, function ($query, $sort) use ($request) {
                if ($request->sortby == 'Code') {
                    $query->orderBy('code', $sort)
                        ->orderBy('id', 'asc');
                } elseif ($request->sortby == 'Requested At') {
                    $query->orderBy('created_at', $sort)
                        ->orderBy('id', 'asc');
                } else {
                    $query->orderBy('due_at', $sort)
                        ->orderBy('id', 'asc');
                }
            })
            ->when($request->type, function ($query, $type) {
                ($type == 'Referral') ? $query->where('is_referral',1) : $query->where('is_referral', 0);
            })
            ->paginate($request->count)
        );
        return $data;
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = new ViewResource(
            Quotation::query()
            ->with('samples.report',
                'samples.sampletype',
                'samples.samplename',
                'samples.category',
                'samples.analyses.started',
                'samples.analyses.ended',
                'samples.analyses.remarkable',
                'samples.analyses.addfee.service',
                'samples.analyses.testservice.testname',
                'samples.analyses.testservice.method.method',
                'samples.analyses.testservice.method.reference',
                'samples.analyses.testservice.fees'
            )
            ->with('services.service')
            ->with('mode')
            ->with('referral.agency.member','referral.province')
            ->with('received:id','received.profile:id,firstname,lastname,user_id')
            ->with('agency','laboratory:id,name','status:id,name,color,others')
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.wallet','customer.industry:id,name')
            ->with('customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name','customer.conformes')
            ->with('conforme:id,name,contact_no','customer.contact:id,email,contact_no,tin,customer_id')
            ->where('id',$id)->first()
        );
        return $data;
    }

    public function analyses($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = AnalysisResource::collection(
            QuotationAnalysis::query()
            ->with('sample','status','addfee.service')
            ->with('testservice.testname','testservice.method.method','testservice.method.reference','testservice.fees')
            ->whereHas('sample',function ($query) use ($id){
                $query->whereHas('quotation',function ($query) use ($id){
                    $query->where('id',$id);
                });
            })
            ->get()
        );
        return $data;
    }

    public function region(){
        return \Auth::user()->profile?->agency?->address?->region_code;
    }
}
