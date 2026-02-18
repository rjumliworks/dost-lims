<?php

namespace App\Services\Finance\Op;

use App\Models\Tsr;
use App\Models\Customer;
use App\Models\FinanceOp;
use App\Http\Resources\Finance\OpResource;
use App\Http\Resources\Finance\Tsr\ListResource;

class ViewClass
{
     public function list($request){
        $data = OpResource::collection(
            FinanceOp::query()
            ->with('items.itemable','or')
            ->with('createdby:id','createdby.profile:id,firstname,lastname,user_id')
            ->with('collection:id,name','payment:id,name,others','status:id,name,color,others')
            ->with('payorable')
            ->when($request->status, function ($query, $status) {
                $query->where('status_id',$status);
            })
            ->when($request->mode, function ($query, $mode) {
                $query->where('payment_id',$mode);
            })
            ->where('payorable_type','!=','App\Models\FinanceName')
            ->orderBy('updated_at','DESC')
            ->orderBy('id','DESC')
            ->paginate(10)
            ->loadMorph('payorable', [
                Customer::class => [
                    'customer_name:id,name,has_branches',
                    'address:address,customer_id,region_code,province_code,municipality_code,barangay_code',
                    'address.region:code,name,region',
                    'address.province:code,name',
                    'address.municipality:code,name',
                    'address.barangay:code,name',
                    'contact:id,email,contact_no,customer_id'
                ],
             ])
        );
        return $data;
    }

    public function tsrs($request){
        $data = ListResource::collection(
            Tsr::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('payment:tsr_id,id,total,subtotal,discount,or_number,is_paid,paid_at,status_id','payment.status:id,name,color,others')
            ->whereHas('payment',function ($query){
                $query->where('is_paid', 0)->where('payment_id',null)->where('collection_id',null)->whereIn('status_id',[6,18]);
            })
            ->whereIn('status_id',[2,3,4])
            ->whereIn('customer_id',$request->customer_id)
            //  ->when($this->facility, function ($query) {
            //     $query->where('facility_id', $this->facility);
            // })
            ->orderBy('created_at','DESC')
            ->get()
        );
        return $data;
    }

    public function search($request){
        $keyword = $request->keyword;
        $id = $request->id;
        $data = Customer::with('conformes')->with('customer_name')
        ->where(function($query) use ($keyword,$id) {
            $query->where('name', 'LIKE', "%{$keyword}%")
                ->where('id','!=',$id)
                ->orWhereHas('customer_name', function ($query) use ($keyword,$id) {
                    $query->where('name', 'LIKE', "%$keyword%")->whereHas('customer', function ($query) use ($id) {
                        $query->where('id','!=',$id);
                    });
                });
        })
        ->get()->map(function ($item) {
            $name = ($item->customer_name->has_branches) ? ($item->is_main) ? $item->customer_name->name :  $item->customer_name->name.' - '.$item->name : $item->customer_name->name;
            return [
                'value' => $item->id,
                'name' => $name,
                'conformes' => $item->conformes->map(function ($i) {
                    return [
                        'value' => $i->id,
                        'name' => $i->name,
                        'contact_no' => $i->contact_no
                    ];
                })
            ];
        });
        if($keyword){
            return $data;
        }else{
            return [];
        }
    }
}
