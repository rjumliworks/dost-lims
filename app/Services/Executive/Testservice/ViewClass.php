<?php

namespace App\Services\Executive\Testservice;

use App\Models\Testservice;
use App\Http\Resources\Executive\Testservice\ListResource;

class ViewClass
{
    public function list($request)
    {
        $data = Testservice::withoutGlobalScope('agency')
            ->with('agency:id,name')
            ->with('agency.address.region:code,name,region', 'agency.address.province:code,name')
            ->with('laboratory', 'status')
            ->with(['testname' => function ($query) {
                $query->withoutGlobalScope('agency');
            }])
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('testname', function ($query) use ($keyword) {
                    $query->withoutGlobalScope('agency')->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->when($request->region, function ($query, $region) {
                $query->whereHas('agency.address', function ($query) use ($region) {
                    $query->where('region_code', $region);
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status_id', $status);
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'asc')
            ->paginate($request->count ?? 20);

        return ListResource::collection($data);
    }
}
