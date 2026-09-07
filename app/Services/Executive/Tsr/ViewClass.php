<?php

namespace App\Services\Executive\Tsr;

use App\Models\Tsr;
use App\Http\Resources\Executive\Tsr\ListResource;

class ViewClass
{
    public function list($request)
    {
        return ListResource::collection(
            Tsr::query()
                ->with(['customer' => function ($query) {
                    $query->select('id', 'name_id', 'name', 'is_main')
                        ->with(['customer_name' => function ($query) {
                            $query->select('id', 'name', 'has_branches')->withoutGlobalScope('agency');
                        }]);
                }])
                ->with('laboratory:id,name', 'status:id,name,color,others')
                ->with('agency:id,name')
                ->with('facility:id,name,region_code', 'facility.region:code,name,region')
                ->when($request->keyword, function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('code', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('customer', function ($q) use ($keyword) {
                                $q->join('customer_names', 'customers.name_id', '=', 'customer_names.id')
                                    ->whereRaw("
                                        CASE
                                            WHEN customers.is_main = 1 THEN customer_names.name
                                            ELSE CONCAT(customer_names.name, ' - ', customers.name)
                                        END LIKE ?
                                    ", ["%{$keyword}%"]);
                            });
                    });
                })
                ->when($request->region, function ($query, $region) {
                    $query->whereHas('facility', function ($query) use ($region) {
                        $query->where('region_code', $region);
                    });
                })
                ->when($request->status, function ($query, $status) {
                    $query->where('status_id', $status);
                })
                ->when($request->year, function ($query, $year) {
                    $query->whereYear('created_at', $year);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate($request->count ?? 20)
        );
    }
}
