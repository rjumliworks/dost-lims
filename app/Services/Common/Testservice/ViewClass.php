<?php

namespace App\Services\Common\Testservice;

use App\Models\Testservice;
use App\Http\Resources\DefaultResource;

class ViewClass
{
    public function counts($statuses){
        foreach($statuses as $status){
            $counts[] = Testservice::where('status_id',$status['value'])->count();
        }
        return $counts;
    }

    public function list($request){
        $data = DefaultResource::collection(
            Testservice::query()
            ->when($request->laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id',$laboratory);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status_id',$status);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('testname', function ($query) use ($keyword){
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })->orWhereHas('method', function ($query) use ($keyword){
                    $query->whereHas('method', function ($query) use ($keyword){
                        $query->where('name', 'LIKE', "%{$keyword}%");
                    });
                });
            })
            ->with('fees','status')
            ->with('testname','agency.member','agency.address.region','laboratory')
            ->with('method.method','method.reference')
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

}
