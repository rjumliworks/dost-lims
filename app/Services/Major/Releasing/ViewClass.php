<?php

namespace App\Services\Major\Releasing;

use Carbon\Carbon;
use App\Models\TsrRelease;
use App\Http\Resources\Major\Releasing\IndexResource;

class ViewClass
{
    public function list($request){
        $keyword = $request->keyword;
        $laboratory = $request->laboratory;
        $year = $request->year;
        $mode = $request->mode;
        $data = IndexResource::collection(
            TsrRelease::with('tsr.customer:id,name_id,name,is_main','tsr.customer.customer_name:id,name,has_branches','tsr.mode')
            ->with('user.profile')
            ->where('status_id',26)
            ->whereHas('tsr', function ($query) use ($laboratory,$year,$mode){
                ($mode) ? $query->where('release_id',$mode) : '';
                ($laboratory) ? $query->where('laboratory_id',$laboratory) : '';
                $query->whereYear('created_at',$year);
            })
            ->when($request->keyword, function ($query) use ($keyword){
                $query->whereHas('tsr', function ($query) use ($keyword){
                    $query->where('code', 'LIKE', "%{$keyword}%")->where('status_id', 4)
                    ->orWhereHas('customer',function ($query) use ($keyword) {
                        $query->whereHas('customer_name',function ($query) use ($keyword) {
                            $query->where('name', 'LIKE', "%{$keyword}%");
                        });
                    });
                });
            })
            ->when($request->type, function ($query, $type) {
                switch($type){
                    case 'For Released':
                        $query->where('created_at','>=', Carbon::now()->subDays(30));
                    break;
                    case 'Unclaimed Reports':
                        $query->where('created_at','<=', Carbon::now()->subDays(30));
                    break;
                }
            })
            ->orderBy('status_id','ASC') 
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

}
