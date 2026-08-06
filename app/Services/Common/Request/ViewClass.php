<?php

namespace App\Services\Common\Request;

use App\Models\Tsr;
use App\Models\ListStatus;
use App\Models\TsrSampleAmendment;
use App\Models\TsrAmendment;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewClass
{
    public function lists($request, $statuses)
    {
        $status = $request->status;

        $paginator = Tsr::query()
                ->with('customer:id,name_id,is_main,name', 'customer.customer_name:id,name')
                ->with('laboratory:id,name')
                ->with('status:id,name,color,others')
                ->withMax(['amendments as latest_sample_request_at' => function ($query) use ($status) {
                    $query->when($status, function ($query) use ($status) {
                        $query->where('status_id', $status);
                    });
                }], 'created_at')
                ->withMax(['dueDateAmendments as latest_due_date_request_at' => function ($query) use ($status) {
                    $query->when($status, function ($query) use ($status) {
                        $query->where('status_id', $status);
                    });
                }], 'created_at')
                ->with(['samples' => function ($query) use ($status) {
                    $query->select('id', 'code', 'name', 'description', 'samplename_id', 'tsr_id')
                        ->with('samplename:id,name')
                        ->when($status, function ($query) use ($status) {
                            $query->whereHas('amendments', function ($q) use ($status) {
                                $q->where('status_id', $status);
                            });
                        }, function ($query) {
                            $query->whereHas('amendments');
                        })
                        ->with(['amendments' => function ($query) use ($status) {
                            $query->when($status, function ($query) use ($status) {
                                $query->where('status_id', $status);
                            })
                            ->with('requestedBy:id', 'requestedBy.profile:id,user_id,firstname,middlename,lastname')
                            ->with('reviewedBy:id', 'reviewedBy.profile:id,user_id,firstname,middlename,lastname')
                            ->with('status:id,name,color,others')
                            ->latest();
                        }]);
                }])
                ->with(['dueDateAmendments' => function ($query) use ($status) {
                    $query->when($status, function ($query) use ($status) {
                        $query->where('status_id', $status);
                    })
                    ->with('requestedBy:id', 'requestedBy.profile:id,user_id,firstname,middlename,lastname')
                    ->with('reviewedBy:id', 'reviewedBy.profile:id,user_id,firstname,middlename,lastname')
                    ->with('status:id,name,color,others')
                    ->latest();
                }])
                ->when($status, function ($query) use ($status) {
                    $query->where(function ($query) use ($status) {
                        $query->whereHas('samples.amendments', function ($q) use ($status) {
                            $q->where('status_id', $status);
                        })->orWhereHas('dueDateAmendments', function ($q) use ($status) {
                            $q->where('status_id', $status);
                        });
                    });
                }, function ($query) {
                    $query->where(function ($query) {
                        $query->whereHas('samples.amendments')->orWhereHas('dueDateAmendments');
                    });
                })
                ->when($request->keyword, function ($query, $keyword) {
                    $query->where('code', 'LIKE', "%{$keyword}%");
                })
                ->orderByDesc('id')
                ->paginate($request->count ?? 10);

        $paginator->getCollection()->each(function ($tsr) {
            $candidates = array_filter([$tsr->latest_sample_request_at, $tsr->latest_due_date_request_at]);
            $latest = count($candidates) ? max($candidates) : null;
            $tsr->latest_request_at = $latest ? date('M d, Y g:i a', strtotime($latest)) : null;
        });

        return JsonResource::collection($paginator)->additional([
            'summary' => $this->counts($statuses)
        ]);
    }

    public function counts($statuses)
    {
        $counts = [];
        foreach ($statuses as $status) {
            $counts[] = TsrSampleAmendment::where('status_id', $status['value'])->count()
                + TsrAmendment::where('status_id', $status['value'])->count();
        }
        return $counts;
    }

    public function approve($request)
    {
        return $request->type === 'due_date' ? $this->approveDueDate($request) : $this->approveSample($request);
    }

    public function reject($request)
    {
        return $request->type === 'due_date' ? $this->rejectDueDate($request) : $this->rejectSample($request);
    }

    private function approveSample($request)
    {
        $amendment = TsrSampleAmendment::findOrFail($request->id);

        $amendment->update([
            'status_id' => $this->statusId('Approved'),
            'reviewed_by' => \Auth::user()->id,
            'reviewed_at' => now(),
            'review_remarks' => $request->remarks,
        ]);

        $sample = $amendment->sample;
        $sample->description = $amendment->proposed_description;
        $sample->customer_description = $amendment->proposed_customer_description;
        $sample->save();

        \Artisan::call('report', ['id' => $sample->tsr_id]);

        return [
            'data' => $amendment->fresh(['status', 'reviewedBy.profile'])->toArray(),
            'message' => 'Update Request Approved',
            'info' => 'The sample description has been updated as requested.'
        ];
    }

    private function rejectSample($request)
    {
        $amendment = TsrSampleAmendment::findOrFail($request->id);

        $amendment->update([
            'status_id' => $this->statusId('Rejected'),
            'reviewed_by' => \Auth::user()->id,
            'reviewed_at' => now(),
            'review_remarks' => $request->remarks,
        ]);

        return [
            'data' => $amendment->fresh(['status', 'reviewedBy.profile'])->toArray(),
            'message' => 'Update Request Rejected',
            'info' => 'The requested update was rejected and the sample description remains unchanged.'
        ];
    }

    private function approveDueDate($request)
    {
        $amendment = TsrAmendment::findOrFail($request->id);

        $amendment->update([
            'status_id' => $this->statusId('Approved'),
            'reviewed_by' => \Auth::user()->id,
            'reviewed_at' => now(),
            'review_remarks' => $request->remarks,
        ]);

        $tsr = $amendment->tsr;
        $tsr->due_at = $amendment->getRawOriginal('proposed_due_at');
        $tsr->save();

        \Artisan::call('report', ['id' => $tsr->id]);

        return [
            'data' => $amendment->fresh(['status', 'reviewedBy.profile'])->toArray(),
            'message' => 'Update Request Approved',
            'info' => 'The due date has been updated as requested.'
        ];
    }

    private function rejectDueDate($request)
    {
        $amendment = TsrAmendment::findOrFail($request->id);

        $amendment->update([
            'status_id' => $this->statusId('Rejected'),
            'reviewed_by' => \Auth::user()->id,
            'reviewed_at' => now(),
            'review_remarks' => $request->remarks,
        ]);

        return [
            'data' => $amendment->fresh(['status', 'reviewedBy.profile'])->toArray(),
            'message' => 'Update Request Rejected',
            'info' => 'The requested due date update was rejected and remains unchanged.'
        ];
    }

    private function statusId($name)
    {
        return ListStatus::where('type', 'Amendment')->where('name', $name)->value('id');
    }
}
