<?php

namespace App\Http\Controllers\Customer;

use Hashids\Hashids;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tsr;
use App\Models\AgencyConfiguration;
use App\Http\Resources\Public\Customer\TsrResource;

class TsrController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->list($request);
            break;
             case 'print':
                return $this->print($request);
            break;
            default:
                return inertia('Customer/Tsrs/Index');
        }
    }

    private function list($request){
        $data = Tsr::with('payment.status','onlinepayment','status','samples.report.signatory','samples.samplename','samples.analyses')
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

    private function print($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);

        $tsr = Tsr::with('payment.status','onlinepayment','status')
        ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.contact:id,email,contact_no,tin,customer_id')
        ->with('customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name')
        ->where('id',$id)->first();

        $url = $_SERVER['HTTP_HOST'].'/verification/'.$request->id;
        $result = new Builder(
            writer: new PngWriter(),
            data: $url,
            size: 300,
            margin: 10,
        );

        $qrCodeImageString = $result->build()->getString();
        $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

         $array = [
            'qrCodeImage' => $base64Image,
            'configuration' => AgencyConfiguration::with('agency.member')->where('agency_id',14)->first(),
            'tsr' => $tsr
        ]; 

        $pdf = \PDF::loadView('reports.eor',$array)->setPaper('A4', 'portrait');
        return $pdf->stream($tsr->code.'.pdf');
    }

}
