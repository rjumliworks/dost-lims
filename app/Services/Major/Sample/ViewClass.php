<?php

namespace App\Services\Major\Sample;

use Hashids\Hashids;
use App\Models\UserRole;
use App\Models\TsrSample;
use App\Models\ListLaboratory;
use App\Http\Resources\Major\Tsr\SampleResource;

class ViewClass
{
    public function sample($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = New SampleResource(
            TsrSample::query()
            ->with('analyses.status','analyses.testservice.method.method','analyses.testservice.testname',
                'analyses.sample',
                'analyses.started.profile','analyses.ended.profile'
            )
            ->with('tsr:id,due_at,code','disposal.disposal','disposal.user.profile','disposal.sample')
            ->where('id',$id)
            ->orderBy('created_at','ASC')
            ->first()
        );
        return $data;
    }

    public function list($request){
        $code = $request->code;
        $data = SampleResource::collection(
            TsrSample::query()
            ->with(
                'analyses.status',
                'analyses.testservice.method.method','analyses.testservice.testname',
                'analyses.sample',
                'analyses.started.profile','analyses.ended.profile')
            ->with('disposal')
            ->withWhereHas('tsr',function ($query) use ($code){
                $query->whereNotIn('status_id',[1,2]);
                $query->select('id','due_at','code','created_at')->whereIn('laboratory_id',$this->labs());
                $query->when($code, function ($query) use ($code){
                    $query->where('code', 'LIKE', "%{$code}%");
                });
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('code', 'LIKE', "%{$keyword}%")->orWhere('name', 'LIKE', "%{$keyword}%");
            })
            ->when($request->sample, function ($query, $sample) {
                $query->where('name', 'LIKE', "%{$sample}%")
                ->orWhereHas('samplename', function ($q2) use ($sample) {
                    $q2->where('name', 'LIKE', "%{$sample}%");
                });
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('is_completed', $request->status);
            })
            ->whereYear('created_at',$request->year)
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function counts(){
        $counts = [
            TsrSample::where('is_completed',0)->withWhereHas('tsr',function ($query){
                $query->whereNotIn('status_id',[1,2])->whereIn('laboratory_id',$this->labs());
            })->count(),
            TsrSample::withWhereHas('tsr',function ($query){
                $query->whereIn('laboratory_id',$this->labs());
            })->where('is_completed',1)->count()
        ];
        return $counts;
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

    public function analysts(){
        $data = UserRole::with('user.profile')
        ->whereHas('user', function ($query){
            $query->where('is_active',1);
        })
        ->whereIn('role_id',[5,10])
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

    private function labs(){
        return UserRole::where('user_id',auth()->id())->whereIn('role_id',[5,10])->where('is_active',1)->pluck('laboratory_id');
    }
}
