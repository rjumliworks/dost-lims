<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tsr;
use App\Http\Resources\Public\Customer\TsrResource;

class TsrController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->list($request);
            break;
            default:
                return inertia('Customer/Tsrs/Index');
        }
    }

    private function list(Request $request){
        $data = Tsr::with('payment.status','status','samples.report.signatory','samples.samplename','samples.analyses')
        ->withCount([
            'samples as total_report_count' => function ($query) {
                $query->select(\DB::raw('COUNT(DISTINCT tsr_sample_reports.code)'))
                    ->join('tsr_sample_reports', 'tsr_sample_reports.sample_id', '=', 'tsr_samples.id');
            },
            'samples as completed_report_count' => function ($query) {
                $query->select(\DB::raw('COUNT(DISTINCT tsr_sample_reports.code)'))
                    ->join('tsr_sample_reports', 'tsr_sample_reports.sample_id', '=', 'tsr_samples.id')
                    ->join('tsr_sample_report_signatories', 'tsr_sample_report_signatories.report_id', '=', 'tsr_sample_reports.id')
                    ->where('tsr_sample_report_signatories.status_id', 42);
            }
        ])
        ->whereIn('status_id',[2,3,4])
        ->where('customer_id',\Auth::guard('customer')->id())
        ->orderBy('created_at','DESC')
        ->paginate(10);
        return TsrResource::collection($data);
    }
}
