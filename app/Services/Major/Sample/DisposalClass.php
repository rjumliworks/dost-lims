<?php

namespace App\Services\Major\Sample;

use App\Models\TsrSample;
use App\Models\TsrSampleDisposal;
use App\Http\Resources\Major\Sample\DisposalResource;

class DisposalClass
{
    public function lists($request){
        $laboratory = $request->laboratory;
        $keyword = $request->keyword;
        $year = $request->year;
        $data = DisposalResource::collection(
            TsrSampleDisposal::query()
            ->with('disposal','sample.tsr','user.profile','status')
            ->whereHas('sample',function ($query) use ($laboratory,$keyword){
                $query->when($keyword, function ($query, $keyword) {
                    $query->where('code', 'LIKE', "%{$keyword}%");
                });
                $query->whereHas('tsr',function ($query) use ($laboratory){
                    $query->when($laboratory, function ($query,$laboratory) {
                        $query->where('laboratory_id',$laboratory);
                    });
                });
                $query->whereYear('completed_at','!=',2024);
            })
            ->when($year, function ($query) use ($year) {
                $query->whereYear('created_at', $year);
            })
            ->orderBy('status_id','ASC')
            ->orderBy('created_at','ASC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function save($request){
        $data = TsrSampleDisposal::where('sample_id',$request->sample['id'])->update([
            'disposed_at' => $request->disposed_at,
            'disposal_id' => $request->disposal_id,
            'status_id' => 29,
            'user_id' => \Auth::user()->id
        ]);
        if($data){
            TsrSample::where('id',$request->sample['id'])->update(['is_disposed' => 1]);
        }
        return [
            'data' => new DisposalResource(TsrSampleDisposal::with('disposal','sample','user.profile','status')->where('sample_id',$request->sample['id'])->first()),
            'message' => 'Sample disposal was successful!', 
            'info' => "You've successfully disposed the sample."
        ];
    }
}
