<?php

namespace App\Services\Executive\History;

use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Models\TsrAmendment;
use App\Models\TsrSampleAmendment;
use App\Models\TsrPayment;
use App\Models\TsrPaymentDeduction;
use App\Models\TsrRelease;
use App\Models\TsrReferral;
use App\Models\TsrRemark;
use App\Models\TsrReport;
use App\Models\TsrSampleDisposal;
use App\Models\TsrSampleReport;
use App\Models\TsrSampleReportList;
use App\Models\TsrSampleReportSignatory;
use App\Models\TsrService;
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
        TsrPaymentDeduction::class,
        TsrRelease::class,
        TsrReferral::class,
        TsrRemark::class,
        TsrReport::class,
        TsrSampleDisposal::class,
        TsrSampleReport::class,
        TsrSampleReportList::class,
        TsrSampleReportSignatory::class,
        TsrService::class,
    ];

    protected array $subjectEagerLoads = [
        Tsr::class => [],
        TsrSample::class => ['tsr'],
        TsrAnalysis::class => ['sample.tsr'],
        TsrAmendment::class => ['tsr'],
        TsrSampleAmendment::class => ['sample.tsr'],
        TsrPayment::class => ['tsr'],
        TsrPaymentDeduction::class => ['payment.tsr'],
        TsrRelease::class => ['tsr'],
        TsrReferral::class => ['tsr'],
        TsrRemark::class => ['remarkable'],
        TsrReport::class => ['tsr'],
        TsrSampleDisposal::class => ['sample.tsr'],
        TsrSampleReport::class => ['tsr'],
        TsrSampleReportList::class => ['report.tsr'],
        TsrSampleReportSignatory::class => ['report.tsr'],
        TsrService::class => ['typeable'],
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
        $paymentDeductionIds = TsrPaymentDeduction::whereIn('payment_id', $paymentIds)->pluck('id');
        $referralIds = TsrReferral::where('tsr_id', $tsr->id)->pluck('id');
        $reportIds = TsrReport::where('tsr_id', $tsr->id)->pluck('id');
        $sampleDisposalIds = TsrSampleDisposal::whereIn('sample_id', $sampleIds)->pluck('id');
        $sampleReportIds = TsrSampleReport::where('tsr_id', $tsr->id)->pluck('id');
        $sampleReportListIds = TsrSampleReportList::whereIn('report_id', $sampleReportIds)->pluck('id');
        $sampleReportSignatoryIds = TsrSampleReportSignatory::whereIn('report_id', $sampleReportIds)->pluck('id');
        $remarkIds = TsrRemark::where(function ($q) use ($tsr, $analysisIds) {
            $q->where(fn ($q2) => $q2->where('remarkable_type', Tsr::class)->where('remarkable_id', $tsr->id))
                ->orWhere(fn ($q2) => $q2->where('remarkable_type', TsrAnalysis::class)->whereIn('remarkable_id', $analysisIds));
        })->pluck('id');
        $serviceIds = TsrService::where(function ($q) use ($tsr, $analysisIds) {
            $q->where(fn ($q2) => $q2->where('typeable_type', Tsr::class)->where('typeable_id', $tsr->id))
                ->orWhere(fn ($q2) => $q2->where('typeable_type', TsrAnalysis::class)->whereIn('typeable_id', $analysisIds));
        })->pluck('id');

        $activities = Activity::with('causer.profile')
            ->where(function ($query) use ($tsr, $sampleIds, $analysisIds, $amendmentIds, $sampleAmendmentIds, $paymentIds, $releaseIds, $paymentDeductionIds, $referralIds, $reportIds, $sampleDisposalIds, $sampleReportIds, $sampleReportListIds, $sampleReportSignatoryIds, $remarkIds, $serviceIds) {
                $query->where(fn ($q) => $q->where('subject_type', Tsr::class)->where('subject_id', $tsr->id))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrSample::class)->whereIn('subject_id', $sampleIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrAnalysis::class)->whereIn('subject_id', $analysisIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrAmendment::class)->whereIn('subject_id', $amendmentIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrSampleAmendment::class)->whereIn('subject_id', $sampleAmendmentIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrPayment::class)->whereIn('subject_id', $paymentIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrRelease::class)->whereIn('subject_id', $releaseIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrPaymentDeduction::class)->whereIn('subject_id', $paymentDeductionIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrReferral::class)->whereIn('subject_id', $referralIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrReport::class)->whereIn('subject_id', $reportIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrSampleDisposal::class)->whereIn('subject_id', $sampleDisposalIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrSampleReport::class)->whereIn('subject_id', $sampleReportIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrSampleReportList::class)->whereIn('subject_id', $sampleReportListIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrSampleReportSignatory::class)->whereIn('subject_id', $sampleReportSignatoryIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrRemark::class)->whereIn('subject_id', $remarkIds))
                    ->orWhere(fn ($q) => $q->where('subject_type', TsrService::class)->whereIn('subject_id', $serviceIds));
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
            TsrSample::class, TsrAmendment::class, TsrPayment::class, TsrRelease::class,
            TsrReferral::class, TsrReport::class, TsrSampleReport::class => $subject->tsr?->code,
            TsrAnalysis::class, TsrSampleAmendment::class => $subject->sample?->tsr?->code,
            TsrPaymentDeduction::class => $subject->payment?->tsr?->code,
            TsrSampleDisposal::class => $subject->sample?->tsr?->code,
            TsrSampleReportList::class, TsrSampleReportSignatory::class => $subject->report?->tsr?->code,
            TsrRemark::class => match (true) {
                $subject->remarkable instanceof Tsr => $subject->remarkable->code,
                $subject->remarkable instanceof TsrAnalysis => $subject->remarkable->sample?->tsr?->code,
                default => null,
            },
            TsrService::class => match (true) {
                $subject->typeable instanceof Tsr => $subject->typeable->code,
                $subject->typeable instanceof TsrAnalysis => $subject->typeable->sample?->tsr?->code,
                default => null,
            },
            default => null,
        };
    }
}
