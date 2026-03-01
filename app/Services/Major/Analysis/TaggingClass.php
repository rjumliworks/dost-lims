<?php

namespace App\Services\Major\Analysis;

use Carbon\Carbon;
use App\Models\UserRole;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Http\Resources\Major\Analysis\AnalysisResource;

class TaggingClass
{
    public function view($request){
        $data = TsrSample::with(
            'sampletype:id,name','samplename:id,name',
            'tsr:id,code,due_at',
            'analyses.status',
            'analyses.testservice.testname',
            'analyses.testservice.method.reference',
            'analyses.testservice.method.method'
            )
        ->where('id',$request->id)->first();
        if (!$data) {
            return null;
        }

        $result = [
            'id' => $data->id,
            'tsr' => $data->tsr,
            'code' => $data->code,
            'name' => $data->name,
            'sampletype' => $data->sampletype?->name,
            'samplename' => $data->samplename?->name,
            'analyses' => AnalysisResource::collection($data->analyses) ?? null,
            'selected' => null,
        ];

        return $result;
    }

    public function list($request)
    {
        return [
            'pendings'   => $this->samplesByStatus($request, 10, 'pending_page'),
            'ongoings'   => $this->samplesByStatus($request, 11, 'ongoing_page'),
            'completeds' => $this->completedNoReport($request),
        ];
    }

    private function baseQuery($request)
    {
        $laboratories = UserRole::where('user_id', auth()->id())
            ->whereIn('role_id', [5,10])
            ->pluck('laboratory_id');
        $keyword = $request->keyword;

        if ($request->type === 'Testing Parameter') {
            // Query from TsrAnalysis
            $query = TsrAnalysis::query()
                ->with(['sample', 'testservice.testname', 'sample.samplename'])
                ->whereHas('sample', function($q) use ($request, $laboratories) {
                    $q->whereHas('tsr', function($q) use ($request, $laboratories) {
                        $q->select('id', 'code', 'laboratory_id', 'due_at');
                        $q->whereIn('laboratory_id', $request->laboratory ?? $laboratories)->where('status_id',3);
                        if ($request->month) $q->whereMonth('due_at', $request->month);
                        $q->when($request->year, function ($query, $year) {
                            $query->whereYear('created_at', $year);
                        });
                        $q->when($request->reminder, function ($query, $reminder) {
                            switch($reminder){
                                case 'Completed with no report number':
                                    $query->where('status_id',4)->where('due_at','<',Carbon::now());
                                break;
                                case 'Due Soon':
                                    $query->whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()]);
                                break;
                                case 'Overdue Request':
                                    $query->whereDate('due_at','<',Carbon::now());
                                break;
                                case 'Completed':
                                    $query->where('status_id',4);
                                break;
                            }
                        });
                    });
                });

            if ($keyword) {
                $query->whereHas('testservice.testname', function($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            }

        } else {
            // Query from TsrSample
            $query = TsrSample::query()
            ->withWhereHas('tsr', function ($q) use ($request, $laboratories, $keyword) {
                $q->when($keyword && $request->type == 'TSR Code', function ($q) use ($keyword) {
                    $q->where('code', 'LIKE', "%{$keyword}%");
                });
                $q->select('id', 'code', 'laboratory_id', 'due_at');
                $q->whereIn('laboratory_id', $request->laboratory ?? $laboratories)->where('status_id',3);
                if ($request->month) $q->whereMonth('due_at', $request->month);
                $q->when($request->year, function ($query, $year) {
                    $query->whereYear('created_at', $year);
                });
                $q->when($request->reminder, function ($query, $reminder) {
                    switch($reminder){
                        case 'Completed with no report number':
                            $query->where('status_id',4)->where('due_at','<',Carbon::now());
                        break;
                        case 'Due Soon':
                            $query->whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()]);
                        break;
                        case 'Overdue Request':
                            $query->whereDate('due_at','<',Carbon::now());
                        break;
                        case 'Completed':
                            $query->where('status_id',4);
                        break;
                    }
                });
            })
            ->when($keyword && $request->type !== 'TSR Code', function ($q) use ($keyword) {
                $q->where('code', 'LIKE', "%{$keyword}%");
            });
        }

        return $query;
    }

    private function samplesByStatus($request, $statusId, $pageName)
    {
        if ($request->type === 'Testing Parameter') {
            // Use TsrAnalysis as base
            return $this->baseQuery($request)
                ->where('status_id', $statusId)
                ->paginate(10, ['*'], $pageName)
                ->through(function ($analysis) {
                    return [
                        'id'        => $analysis->id,
                        'tsr_id'    => $analysis->sample->tsr_id,
                        'tsr'       => $analysis->sample->tsr,
                        'code'      => $analysis->sample->code,
                        'type'      => $analysis->sample->sampletype->name,
                        'name'      => $analysis->sample->samplename->name,
                        'testservice_name' => $analysis->testservice->testname->name ?? null,
                        'selected'  => null
                    ];
                });
        } else {
            // Use TsrSample as base (your existing logic)
            return $this->baseQuery($request)
                ->withWhereHas('analyses', fn($q) => $q->where('status_id', $statusId))
                ->withCount([
                    'analyses as analyses_count' => fn($q) => $q->where('status_id','!=',13),
                    'analyses as pending_analyses_count' => fn($q) => $q->where('status_id',10),
                    'analyses as ongoing_analyses_count' => fn($q) => $q->where('status_id',11),
                    'analyses as completed_analyses_count' => fn($q) => $q->where('status_id',12),
                ])
                ->paginate(10, ['*'], $pageName)
                ->through(function ($sample) {
                    return [
                        'id'        => $sample->id,
                        'tsr_id'    => $sample->tsr_id,
                        'tsr'       => $sample->tsr,
                        'code'      => $sample->code,
                        'type'      => $sample->sampletype->name,
                        'name'      => $sample->samplename->name,
                        'count'     => $sample->analyses_count,
                        'pending'   => $sample->pending_analyses_count,
                        'ongoing'   => $sample->ongoing_analyses_count,
                        'completed' => $sample->completed_analyses_count,
                        'selected'  => null
                    ];
                });
        }
    }

    private function completedNoReport($request)
    {
        $laboratories = UserRole::where('user_id', auth()->id())
            ->whereIn('role_id', [5,10])
            ->pluck('laboratory_id');
        return TsrSample::query()
            ->withWhereHas('tsr', function ($q) use ($request, $laboratories) {
                $q->whereIn('laboratory_id', $request->laboratory ?? $laboratories);
                if ($request->month) $q->whereMonth('due_at', $request->month);
                $q->when($request->year, function ($query, $year) {
                    $query->whereYear('created_at', $year);
                });
                $q->when($request->reminder, function ($query, $reminder) {
                    switch($reminder){
                        case 'Completed with no report number':
                            $query->where('status_id',4)->where('due_at','<',Carbon::now());
                        break;
                        case 'Due Soon':
                            $query->whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])->whereNotIn('status_id',[4,5]);
                        break;
                        case 'Overdue Request':
                            $query->whereDate('due_at','<',Carbon::now())->whereNotIn('status_id',[4,5]);
                        break;
                        case 'Completed':
                            $query->where('status_id',4);
                        break;
                    }
                });
            })
            ->when($request->keyword, function ($q) use ($request) {
                if ($request->type === 'Sample Code') $q->where('code', 'LIKE', "%{$request->keyword}%");
                else $q->where('name', 'LIKE', "%{$request->keyword}%");
            })
        ->whereDoesntHave('report')
        ->withWhereHas('analyses', function ($query) {
            $query->where('status_id', 12);
        })
        ->withCount([
            'analyses as analyses_count' => fn($q) => $q->where('status_id','!=',13),
            'analyses as pending_analyses_count' => fn($q) => $q->where('status_id',10),
            'analyses as ongoing_analyses_count' => fn($q) => $q->where('status_id',11),
            'analyses as completed_analyses_count' => fn($q) => $q->where('status_id',12),
        ])
        ->paginate(10, ['*'], 'completed_page')
        ->through(function ($sample) {
            return [
                'id'        => $sample->id,
                'tsr_id'    => $sample->tsr_id,
                'tsr'       => $sample->tsr,
                'code'      => $sample->code,
                'name'      => $sample->samplename->name,
                'count'     => $sample->analyses_count,
                'pending'   => $sample->pending_analyses_count,
                'ongoing'   => $sample->ongoing_analyses_count,
                'completed' => $sample->completed_analyses_count,
            ];
        });
    }
}
