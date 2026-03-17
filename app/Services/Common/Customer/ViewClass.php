<?php

namespace App\Services\Common\Customer;

use Hashids\Hashids;
use App\Models\Customer;
use App\Models\CustomerName;
use App\Models\AgencyConfiguration;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\Common\Customer\ViewResource;
use App\Http\Resources\Common\Customer\IndexResource;

class ViewClass
{
    public function list($request){
        $data = Customer::select('customers.*', 'customers.name as branch_name')
        ->join('customer_names', 'customers.name_id', '=', 'customer_names.id') //'classification:id,name' 'type:id,name','industry:id,name,industry_id,is_main,is_alone,is_active'
        ->with([
            'customer_name.classification:id,name',
            'customer_name.type:id,name',
            'customer_name.industry:id,name,industry_id,is_main,is_alone,is_active',
            'sex:id,name',
            'led:id,name'
        ])
        ->with('address.region:code,name,region','address.province:code,name','address.municipality:code,name','address.barangay:code,name')
        ->with(['customer_name' => function ($q) {
            $q->withoutGlobalScope('agency');
        }])
        ->when($request->keyword, function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereRaw("
                    CASE
                        WHEN customers.is_main = 1 THEN customer_names.name
                        ELSE CONCAT(customer_names.name, ' - ', customers.name)
                    END LIKE ?
                ", ["%{$keyword}%"]);
            });
        })
        ->when($request->type, function ($query, $type) {
            match ($type) {
                'New Customer' => $query->where('is_new', 1),
                'Old Customer' => $query->where('is_new', 0),
                'Not Identified' => $query->whereNull('is_new'),
            };
        })
        ->when($request->class, fn ($q, $v) => $q->where('classification_id', $v))
        ->when($request->industry, fn ($q, $v) => $q->where('industry_id', $v))
        ->when($request->sex, fn ($q, $v) => $q->where('sex_id', $v))
        ->when($request->individual, fn ($q, $v) => $q->where('type_id', $v))
        ->orderBy('customer_names.name', 'asc')
        ->orderBy('customers.created_at', 'desc')
        ->orderBy('customers.id', 'asc')
        ->paginate($request->count ?? 20);

        return IndexResource::collection($data);
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = new ViewResource(
            Customer::query()
            ->with('conformes','payors')
            ->with('customer_name:id,name,classification_id,industry_id,type_id','customer_name.classification:id,name','customer_name.industry:id,name','customer_name.type:id,name','sex:id,name','led:id,name')
            ->with('address.region:code,name,region','address.province:code,name','address.municipality:code,name','address.barangay:code,name')
            ->where('id',$id)->first()
        );
        return $data;
    }

    public function search($request){
        $keyword = $request->keyword;
        if($keyword){
            $data = CustomerName::with('classification:id','industry:id','type:id')->where('name', 'LIKE', "%{$keyword}%")->get()->map(function ($item) {
                return [
                    'value' => $item->id,
                    'name' => $item->name,
                    'has_branches' => $item->has_branches,
                    'classification' => $item->classification->id,
                    'industry' => $item->industry->id,
                    'type_id' => $item->type?->id
                ];
            });
            return $data;
        }else{
            return [];
        }
    }

    public function pick($request){
        $keyword = $request->keyword;
        $id = $request->id;
        $data = Customer::with('conformes','contact')->with('customer_name')
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
                'email' => $item->contact->email,
                'contact_no' => $item->contact->contact_no,
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

    public function logs($request)
    {
        $customer = Customer::findOrFail($request->id);
        $data = $customer->activities()->paginate(15);
        return ActivityResource::collection($data);
    }

    public function region(){
        return auth()->user()?->profile?->agency?->address?->region_code;
    }
}
