<?php

namespace App\Services\Executive\History;

use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Models\TsrAmendment;
use App\Models\TsrSampleAmendment;
use App\Models\TsrPayment;
use App\Models\TsrRelease;
use Spatie\Activitylog\Models\Activity;

class ViewClass
{
    protected array $trackedTypes = [
        Tsr::class,
        TsrSample::class,
        TsrAnalysis::class,
        TsrAmendment::class,
        TsrSampleAmendment::class,
        TsrPayment::class,
        TsrRelease::class,
    ];

    protected array $subjectEagerLoads = [
        Tsr::class => [],
        TsrSample::class => ['tsr'],
        TsrAnalysis::class => ['sample.tsr'],
        TsrAmendment::class => ['tsr'],
        TsrSampleAmendment::class => ['sample.tsr'],
        TsrPayment::class => ['tsr'],
        TsrRelease::class => ['tsr'],
    ];

    public function list($request)
    {
        $activities = Activity::with('causer.profile')
            ->whereIn('subject_type', $this->trackedTypes)
            ->when($request->month, fn ($q) => $q->whereMonth('created_at', $request->month))
            ->when($request->year, fn ($q) => $q->whereYear('created_at', $request->year))
            ->orderBy('created_at', 'DESC')
            ->paginate($request->count ?? 20);

        $activities->getCollection()->loadMorph('subject', $this->subjectEagerLoads);
        $activities->getCollection()->transform(fn ($activity) => $this->format($activity));

        return $activities;
    }

    public function tsr($request)
    {
        $tsr = Tsr::where('code', $request->code)->first();

        if (! $tsr) {
            return ['tsr' => null, 'activities' => []];
        }

        $sampleIds = TsrSample::where('tsr_id', $tsr->id)->pluck('id');
        $analysisIds = TsrAnalysis::whereIn('sample_id', $sampleIds)->pluck('id');
        $amendmentIds = TsrAmendment::where('tsr_id', $tsr->id)->pluck('id');
        $sampleAmendmentIds = TsrSampleAmendment::whereIn('sample_id', $sampleIds)->pluck('id');
        $paymentIds = TsrPayment::where('tsr_id', $tsr->id)->pluck('id');
        $releaseIds = TsrRelease::where('tsr_id', $tsr->id)->pluck('id');

        $activities = Activity::with('causer.profile')
            ->where(function ($query) use ($tsr, $sampleIds, $analysisIds, $amendmentIds, $sampleAmendmentIds, $paymentIds, $releaseIds) {
                $query->where(fn ($q) => $q->where('subject_type', Tsr::class)->where('subject_id', $tsr->id))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrSample::class)->whereIn('subject_id', $sampleIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrAnalysis::class)->whereIn('subject_id', $analysisIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrAmendment::class)->whereIn('subject_id', $amendmentIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrSampleAmendment::class)->whereIn('subject_id', $sampleAmendmentIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrPayment::class)->whereIn('subject_id', $paymentIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrRelease::class)->whereIn('subject_id', $releaseIds));
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        $activities->loadMorph('subject', $this->subjectEagerLoads);

        return [
            'tsr' => [
                'code' => $tsr->code,
                'reference' => $tsr->reference,
            ],
            'activities' => $activities->map(fn ($activity) => $this->format($activity))->values(),
        ];
    }

    private function format($activity)
    {
        return [
            'id' => $activity->id,
            'log_name' => $activity->log_name,
            'event' => $activity->event,
            'description' => $activity->description,
            'tsr_code' => $this->resolveTsrCode($activity),
            'causer' => $activity->causer ? [
                'id' => $activity->causer->id,
                'name' => $activity->causer->profile?->fullname,
            ] : null,
            'properties' => $activity->properties,
            'created_at' => $activity->created_at,
        ];
    }

    private function resolveTsrCode($activity)
    {
        $subject = $activity->subject;

        if (! $subject) {
            return null;
        }

        return match ($activity->subject_type) {
            Tsr::class => $subject->code,
            TsrSample::class, TsrAmendment::class, TsrPayment::class, TsrRelease::class => $subject->tsr?->code,
            TsrAnalysis::class, TsrSampleAmendment::class => $subject->sample?->tsr?->code,
            default => null,
        };
    }
}
