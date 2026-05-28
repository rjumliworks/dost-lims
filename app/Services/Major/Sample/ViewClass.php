<?php

namespace App\Services\Major\Sample;

use Hashids\Hashids;
use App\Models\UserRole;
use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\ListLaboratory;
use App\Http\Resources\Major\Tsr\SampleResource;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

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
        $date = $request->date;
        $laboratory = $request->laboratory;
        $data = SampleResource::collection(
            TsrSample::query()
            ->with(
                'analyses.status',
                'analyses.testservice.method.method','analyses.testservice.testname',
                'analyses.sample',
                'analyses.started.profile','analyses.ended.profile')
            ->with('disposal')
            ->withWhereHas('tsr',function ($query) use ($code,$date,$laboratory){
                $query->whereNotIn('status_id',[1,2]);
                $query->select('id','due_at','code','created_at');
                $query->when($code, function ($query) use ($code){
                    $query->where('code', 'LIKE', "%{$code}%");
                })
                ->when($date, function ($query) use ($date){
                    $query->where('due_at',$date);
                })
                ->when($laboratory, function ($query) use ($laboratory){
                    $query->where('laboratory_id',$laboratory);
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

    public function qrcode_list($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);
        $samples = TsrSample::with('samplename:id,name')
        ->with('analyses:id,sample_id,testservice_id','analyses.testservice:id,testname_id','analyses.testservice.testname:id,name')
        ->with('tsr:id,due_at,created_at')
        ->where('tsr_id',$id)->get();
        $lists = [];
        foreach($samples as $sample){
            $testnames = [];

            foreach ($sample->analyses as $analysis) {
                if (isset($analysis->testservice->testname->name)) {
                    $testnames[] = $analysis->testservice->testname->name;
                }
            }

            $code = $sample->code;
            $result = new Builder(
                writer: new PngWriter(),
                data: $code,
                size: 300,
                margin: 10,
            );

            $qrCodeImageString = $result->build()->getString();
            $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

            $lists[] = [
                'qrCodeImage' => $base64Image,
                'sample_code' => $code,
                'sample_name' => ($sample->samplename->name != 'n/a') ? $sample->samplename->name : $sample->name,
                'due_at' => $sample->tsr->due_at,
                'created_at' => $sample->tsr->created_at,
                'testnames' => $testnames
            ];

        }
        $array = [
            'lists' => $lists
        ];
        $width = 6.20 * 28.35; 
        $height = 6.00 * 28.35;
        $pdf = \PDF::loadView('qrcodes.list-sample',$array)->setPaper([0, 0, $width, $height], 'portrait');
        return $pdf->stream(Tsr::where('id',$id)->value('code').'_qrcodes.pdf');
    }

    private function labs(){
        return UserRole::where('user_id',auth()->id())->whereIn('role_id',[3,5,10])->where('is_active',1)->pluck('laboratory_id');
    }
}
