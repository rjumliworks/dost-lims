<?php

namespace App\Services\Executive\Customer;

use App\Models\Customer;
use App\Http\Resources\Executive\Customer\ListResource;

class ViewClass
{
    public function list($request)
    {
        $data = Customer::select('customers.*')
            ->join('customer_names', 'customers.name_id', '=', 'customer_names.id')
            ->with('customer_name:id,name,has_branches')
            ->with(['customer_name' => function ($q) {
                $q->withoutGlobalScope('agency');
            }])
            ->with('agency:id,name')
            ->with('address.region:code,name,region', 'address.province:code,name')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereRaw("
                    CASE
                        WHEN customers.is_main = 1 THEN customer_names.name
                        ELSE CONCAT(customer_names.name, ' - ', customers.name)
                    END LIKE ?
                ", ["%{$keyword}%"]);
            })
            ->when($request->region, function ($query, $region) {
                $query->whereHas('address', function ($query) use ($region) {
                    $query->where('region_code', $region);
                });
            })
            ->orderBy('customers.created_at', 'desc')
            ->orderBy('customers.id', 'asc')
            ->paginate($request->count ?? 20);

        return ListResource::collection($data);
    }
}
