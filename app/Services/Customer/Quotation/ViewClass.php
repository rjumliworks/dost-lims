<?php

namespace App\Services\Customer\Quotation;

use App\Models\CustomerQuotation;
use App\Http\Resources\Customer\Quotation\ViewResource;

class ViewClass
{
   public function view($id){
       
        $data = new ViewResource(
            CustomerQuotation::query()
            ->with('samples',
                'samples.sampletype',
                'samples.samplename',
                'samples.category',
                'samples.analyses.testservice.testname',
                'samples.analyses.testservice.method.method',
                'samples.analyses.testservice.method.reference',
                'samples.analyses.testservice.fees'
            )
            ->with('agency','laboratory:id,name','status:id,name,color,others')
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.wallet')
            ->with('customer.customer_name.industry:id,name')
            ->with('customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name','customer.conformes')
            ->with('conforme:id,name,contact_no','customer.contact:id,email,contact_no,tin,customer_id')
            ->where('id',1)->first()
        );
        return $data;
    }

    // public function analyses($id){
       

    //     $data = AnalysisResource::collection(
    //         CustomerQuotationAnalysis::query()
    //         ->with('sample.sampletype','sample.samplename')
    //         ->with('testservice.testname','testservice.method.method','testservice.method.reference','testservice.fees')
    //         ->whereHas('sample',function ($query) use ($id){
    //             $query->whereHas('quotation',function ($query) use ($id){
    //                 $query->where('id',$id);
    //             });
    //         })
    //         ->get()
    //     );
    //     return $data;
    // }
}
