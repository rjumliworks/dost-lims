<?php

namespace App\Services\Major\Analysis;

use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Models\TsrSampleDisposal;
use App\Http\Resources\Major\Tsr\SampleResource;
use App\Http\Resources\Major\TsR\AnalysisResource;

class UpdateClass
{
    public function start($request){
        $tsr_id = $request->tsr_id;
        $data = TsrAnalysis::whereIn('id',$request->id)->update([
            'status_id' => $request->status_id,
            'started_by' => \Auth::user()->id,
            'start_at' => $request->start_at
        ]);
        

        $data = New SampleResource(
            TsrSample::query()
            ->with('analyses.status','analyses.testservice.method.method','analyses.testservice.testname','analyses.sample','analyses.started.profile','analyses.ended.profile')
            ->with('tsr:id,due_at','disposal')
            ->where('id',$request->sample_id)
            ->orderBy('created_at','ASC')
            ->first()
        );
        
        return [
            'data' => $data,
            'message' => 'Sample analysis successfully started!', 
            'info' => "You've successfully started the analyzation.",
        ];
    }

    public function end($request){
        $tsr_id = $request->tsr_id;
        $sample_id = $request->sample_id;
        $data = TsrAnalysis::whereIn('id',$request->id)->update([
            'status_id' => $request->status_id,
            'ended_by' => \Auth::user()->id,
            'end_at' => $request->end_at
        ]);
        if($data){
            $count = TsrAnalysis::whereHas('sample',function ($query) use ($tsr_id){
                $query->whereHas('tsr',function ($query) use ($tsr_id){
                    $query->where('id',$tsr_id);
                });
            })->whereIn('status_id',[10,11])->count();
            if($count === 0){
                $tsr = Tsr::where('id',$tsr_id)->update(['status_id' => 4]); 
            }

            $count = TsrAnalysis::where('sample_id',$sample_id)->whereIn('status_id',[10,11])->count();
            if($count === 0){
                $tsr = TsrSample::where('id',$request->sample_id)->update([
                    'is_completed' => 1,
                    'completed_at' => $request->end_at
                ]); 
                $count2 = TsrSampleDisposal::where('sample_id',$sample_id)->count();
                if($count2 === 0){
                    TsrSampleDisposal::create([
                        'status_id' => 28,
                        'sample_id' => $sample_id,
                    ]);
                }
            }    
        }
        $data = New SampleResource(
            TsrSample::query()->with('analyses.status','analyses.testservice.method.method','analyses.testservice.testname','analyses.sample','analyses.started.profile','analyses.ended.profile')
            ->with('tsr:id,due_at','disposal')
            ->where('id',$request->sample_id)
            ->orderBy('created_at','ASC')
            ->first()
        );
        
        return [
            'data' => $data,
            'message' => 'Analysis was completed!', 
            'info' => "You've successfully completed the analysis.",
        ];
    }

    public function tagging($request){
        $data = TsrAnalysis::with('status')->where('id',$request->id)->first();
        if($request->started){
            $data->started_by = $request->started['value'] ?? $data->started_id;
            $data->start_at   = $request->start_at ?? $data->start_at;
        }
        if($request->ended){
            $data->ended_by   = $request->ended['value'] ?? $data->ended_id;
            $data->end_at     = $request->end_at ?? $data->end_at;
        }
        $data->save();

        return [
            'data' => new AnalysisResource($data),
            'message' => 'Analysis was updated!', 
            'info' => "You've successfully updated the analysis."
        ];
    }

    public function group($request){
        if($request->type == 'Sample Code'){
            $analyses = TsrAnalysis::whereIn('sample_id', $request->lists)->get();
            foreach ($analyses as $analysis) {
                if (is_null($analysis->start_at)) {
                    $analysis->start_at = $request->date;
                    $analysis->status_id = 11; 
                    $analysis->started_by = \Auth::user()->id;
                } else {
                    $analysis->ended_by = \Auth::user()->id;
                    $analysis->end_at = $request->date;
                    $analysis->status_id = 12; 
                }
                $analysis->save();
            }
            foreach ($request->lists as $sample) {
                $tsr_id = TsrSample::find($sample)?->tsr_id;
                $count = TsrAnalysis::whereHas('sample',function ($query) use ($tsr_id){
                    $query->whereHas('tsr',function ($query) use ($tsr_id){
                        $query->where('id',$tsr_id);
                    });
                })->whereIn('status_id',[10,11])->count();
                if($count === 0){
                    $tsr = TsrSample::where('id',$request->sample_id)->update([
                        'is_completed' => 1,
                        'completed_at' => $request->date
                    ]); 
                    $tsr = Tsr::where('id',$tsr_id)->update(['status_id' => 4]); 
                }
            }
            foreach($request->lists as $sampleId) {
                if (!TsrAnalysis::where('sample_id', $sampleId)->where('status_id', '!=', 12)->exists()) {
                    TsrSample::where('id', $sampleId)->update(['is_completed' => true, 'completed_at' => $request->date]);
                }
            }
            $samples = SampleResource::collection(TsrSample::whereIn('id',$request->lists)->get());
        }else{
            foreach ($request->lists as $list) {
                $analysis = TsrAnalysis::where('id',$list)->first();
                if (is_null($analysis->start_at)) {
                    $analysis->start_at = $request->date;
                    $analysis->status_id = 11; 
                    $analysis->started_by = \Auth::user()->id;
                } else {
                    $analysis->ended_by = \Auth::user()->id;
                    $analysis->end_at = $request->date;
                    $analysis->status_id = 12; 
                }
                if($analysis->save()){
                    $tsr_id = TsrSample::find($analysis->sample_id)?->tsr_id;
                    $count = TsrAnalysis::whereHas('sample',function ($query) use ($tsr_id){
                        $query->whereHas('tsr',function ($query) use ($tsr_id){
                            $query->where('id',$tsr_id);
                        });
                    })->whereIn('status_id',[10,11])->count();
                    if($count === 0){
                        $tsr = TsrSample::where('id',$analysis->sample_id)->update([
                            'is_completed' => 1,
                            'completed_at' => $request->date
                        ]); 
                        $tsr = Tsr::where('id',$tsr_id)->update(['status_id' => 4]); 
                    }
                    if (!TsrAnalysis::where('id', $list)->where('status_id', '!=', 12)->exists()) {
                        TsrSample::where('id', $analysis->sample_id)->update(['is_completed' => true, 'completed_at' => $request->date]);
                    }
                }
            }
            $samples = '';
        }

        return [
            'data' => $samples,
            'message' => 'Analysis was updated!', 
            'info' => "You've successfully updated the analysis."
        ];
    }
}
