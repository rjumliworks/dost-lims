<?php

namespace App\Services\Common\Testservice;

use Hashids\Hashids;
use App\Models\Testservice;
use App\Models\TestserviceName;
use App\Models\TestserviceMethod;
use App\Http\Resources\Common\TestserviceResource;
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
        $data = TestserviceResource::collection(
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
            ->orderBy('created_at','DESC')->orderBy('id','ASC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function search($request){
        $keyword = $request->keyword;
        $type = $request->type;
        $laboratory = $request->laboratory_id;

        $data = TestserviceName::where('name', 'LIKE', "%{$keyword}%")
        ->where('type_id',$type)
        ->where('laboratory_id',$laboratory)
        ->where('is_active',1)
        ->limit(20)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = new TestserviceResource(
            Testservice::query()
            ->with('testname','laboratory','status','added.profile.suffix')
            ->with('method.method','method.reference')
            ->with('fees','samples.sampleable')
            ->where('id',$id)->first()
        );
        return $data;
    }

    public function methods($request){
        $laboratory = $request->laboratory_id;
        $keyword = $request->keyword;
      
        $data = TestserviceResource::collection(
            TestserviceMethod::query()
            ->where('is_active',1)
            ->withWhereHas('method', function ($query) use ($keyword){
                $query->select('id','name','short');
                $query->when($keyword, function ($query, $keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%")->orWhere('short', 'LIKE', "%{$keyword}%");
                });
            })
            ->withWhereHas('reference', function ($query) use ($keyword){
                $query->select('id','name');
                $query->when($keyword, function ($query, $keyword) {
                    $query->orWhere('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->where('laboratory_id',$laboratory)
            ->paginate(50)
        );
        return $data;
    }

}
