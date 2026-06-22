<?php

namespace App\Services\Major\Quotation;

use Hashids\Hashids;
use App\Models\Wallet;
use App\Models\Quotation;
use App\Models\QuotationSample;
use App\Models\QuotationAnalysis;
use App\Models\UserRole;
use App\Models\AgencyConfiguration;
use App\Http\Resources\Major\Quotation\ListResource;
use App\Http\Resources\Major\Quotation\ViewResource;
use App\Http\Resources\Major\Quotation\AnalysisResource;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ViewClass
{
    public function counts($statuses){
        foreach($statuses as $status){
            $counts[] = Quotation::where('status_id',$status['value'])
            // ->when($this->province, function ($query){
            //     $query->where('created_by', \Auth::user()->id);
            // })
            // ->when($this->configuration->strict_mode == 1, function ($query) {
            //     $facility = \Auth::user()->profile->facility;

            //     if ($facility->is_psto || $facility->is_separated) {
            //         $query->where('facility_id', $facility->id);
            //     }
            // })
            ->count();
        }
        return $counts;
    } 

    public function lists($request){
        $data = ListResource::collection(
            Quotation::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('received:id','received.profile:id,firstname,middlename,suffix_id,lastname,user_id')
            ->with('laboratory:id,name','status:id,name,color,others')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('code', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('customer', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('customer_name', function ($q) use ($keyword) {
                                $q->where('name', 'LIKE', "%{$keyword}%");
                            });
                    });
                });
            })
            ->with(['samples' => function ($query){
                $query->select('id','quotation_id');
                $query->withCount([
                    'analyses as analyses_count'
                ]);
            }])
            ->when($request->status, function ($query, $status) {
                $query->where('status_id',$status);
            })
            ->when($request->laboratory , function ($query, $labtype ) {
                (is_array($labtype)) ?  $query->whereIn('laboratory_id',$labtype ) : $query->where('laboratory_id',$labtype );
            }) 
            ->when($request->sort, function ($query, $sort) use ($request) {
                if ($request->sortby == 'Code') {
                    $query->orderBy('code', $sort)
                        ->orderBy('id', 'asc');
                } elseif ($request->sortby == 'Requested At') {
                    $query->orderBy('created_at', $sort)
                        ->orderBy('id', 'asc');
                } else {
                    $query->orderBy('due_at', $sort)
                        ->orderBy('id', 'asc');
                }
            })
            ->when($request->type, function ($query, $type) {
                ($type == 'Referral') ? $query->where('is_referral',1) : $query->where('is_referral', 0);
            })
            ->paginate($request->count)
        );
        return $data;
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = new ViewResource(
            Quotation::query()
            ->with('samples',
                'samples.sampletype',
                'samples.samplename',
                'samples.category',
                'samples.analyses.addfee.service',
                'samples.analyses.testservice.testname',
                'samples.analyses.testservice.method.method',
                'samples.analyses.testservice.method.reference',
                'samples.analyses.testservice.fees'
            )
            ->with('services.service')
            ->with('mode')
            ->with('referral.agency.member','referral.province')
            ->with('received:id','received.profile:id,firstname,middlename,suffix_id,lastname,user_id')
            ->with('agency','laboratory:id,name','status:id,name,color,others')
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.wallet')
            ->with('customer.customer_name.industry:id,name')
            ->with('customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name','customer.conformes')
            ->with('conforme:id,name,contact_no','customer.contact:id,email,contact_no,tin,customer_id')
            ->where('id',$id)->first()
        );
        return $data;
    }

    public function analyses($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = AnalysisResource::collection(
            QuotationAnalysis::query()
            ->with('sample.sampletype','sample.samplename','addfee.service')
            ->with('testservice.testname','testservice.method.method','testservice.method.reference','testservice.fees')
            ->whereHas('sample',function ($query) use ($id){
                $query->whereHas('quotation',function ($query) use ($id){
                    $query->where('id',$id);
                });
            })
            ->get()
        );
        return $data;
    }

    public function region(){
        return \Auth::user()->profile?->agency?->address?->region_code;
    }

    public function print($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);

        $quotation = Quotation::query()
        ->with('service.service')
        ->with('createdby:id','createdby.profile:id,firstname,lastname,middlename,user_id')
        ->with('laboratory:id,name','status:id,name,color,others')
        ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name')
        ->with('conforme:id,name,contact_no','customer.contact:id,email,contact_no,customer_id')
        ->where('id',$id[0])
        ->first();
      
        $samples = $this->analysesList($id[0]);

        $descs = QuotationSample::query()
        ->where('quotation_id',$id)
        ->get();

        $samples = QuotationSample::with('analyses.testservice.method.method','analyses.testservice.testname','analyses.addfee.service')
        ->whereHas('quotation',function ($query) use ($id) {
            $query->where('id',$id);
        })->get();

        $groupedData = [];

        foreach ($samples as $row) {
            $sampleName = $row['name'];

            foreach ($row['analyses'] as $index => $analysis) {
                $testName = $analysis['testservice']['testname']['name'];
                $testMethod = $analysis['testservice']['method']['method']['name'];
                $shortMethod = $analysis['testservice']['method']['method']['short'];
                $key = $sampleName . "_" . $analysis['sample_id'] . "_" . $testName . "_" . $testMethod;

                // Initialize grouping if not yet set
                if (!isset($groupedData[$key])) {
                    $groupedData[$key] = [
                        "samplename" => ($index == 0) ? $sampleName : '-',
                        "testname" => $testName,
                        "method" => ($shortMethod) ? $shortMethod : $testMethod,
                        "count" => 0,
                        "fee" => $analysis['fee'],
                        'additional' => [] // Store as array of grouped additional fees
                    ];
                }

                // Increase count
                $groupedData[$key]["count"] += 1;

                // Group additional fees by name and sum quantity and total
                if (!empty($analysis['addfee'])) {
                    $addfees = is_array($analysis['addfee']) && isset($analysis['addfee'][0])
                        ? $analysis['addfee']            // array of fees
                        : [$analysis['addfee']];         // single fee wrapped in array

                    foreach ($addfees as $addfee) {
                        $feeName = $addfee['service']['name'];
                        $feeAmount = $addfee['service']['fee'];
                        $feeQuantity = $addfee['quantity'];
                        $feeTotal = $addfee['total'];

                        // Look for existing fee by name
                        $found = false;
                        $feeAmount = floatval(str_replace(['₱', ','], '', $addfee['service']['fee']));
                        $feeQuantity = (int) $addfee['quantity'];
                        $feeTotal = floatval(str_replace(['₱', ','], '', $addfee['total']));
                        foreach ($groupedData[$key]['additional'] as &$existingFee) {
                            if ($existingFee['name'] === $feeName) {
                                $existingFee['quantity'] += $feeQuantity;
                                $existingFee['total'] += $feeTotal;
                                $found = true;
                                break;
                            }
                        }

                        // If not found, add as new fee entry
                        if (!$found) {
                            $groupedData[$key]['additional'][] = [
                                'name' => $feeName,
                                'fee' => $feeAmount,
                                'quantity' => $feeQuantity,
                                'total' => $feeTotal,
                            ];
                        }
                    }
                }
            }
        }


        if(isset($quotation->service)){
            $service = [
                'name' => $quotation->service->service->name,
                'description' => $quotation->service->service->description,
                'quantity' => $quotation->service->quantity,
                'fee' => $quotation->service->fee
            ];
        }else{
            $service = null;
        }

        $samples2 = array_values($groupedData);

        $head = UserRole::with('user:id','user.profile:id,user_id,firstname,middlename,lastname')
        ->where('agency_id',$quotation->agency_id)->whereHas('role',function ($query){
            $query->where('name','Technical Manager');
        })
        ->where('laboratory_id',$quotation->laboratory_id)
        ->where('is_active',1)
        ->first();
        $available = Wallet::where('customer_id', $quotation->customer_id)->value('available') ?? 0;
        $wallet = ($available != 0) ? trim(str_replace(',','',$available),'₱') : 0;
        $array= [
            'configuration' => AgencyConfiguration::where('agency_id',$this->agency)->first(),
            'quotation' => new QuotationResource($quotation),
            'samples' => $samples,
            'group' => $samples2,
            'service' => $service,
            'descs' => $descs,
            'wallet' => $wallet,
            'manager' => $head->user->profile->firstname.' '.$head->user->profile->middlename[0].'. '.$head->user->profile->lastname,
            'user' => $quotation->createdby->profile->firstname.' '.$quotation->createdby->profile->middlename[0].'. '.$quotation->createdby->profile->lastname
        ]; 
        $pdf = \PDF::loadView('reports.quotation',$array)->setPaper('a4', 'portrait');
       

        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $copies = 1;
            $totalPagesPerCopy = $pageCount / $copies;
            $currentPageInCopy = ($pageNumber - 1) % $totalPagesPerCopy + 1;
            $text = "PAGE $currentPageInCopy OF $totalPagesPerCopy";
            $font = $fontMetrics->get_font("Helvetica", "normal");
            $size = 7;
            $width = $fontMetrics->get_text_width($text, $font, $size);
            $canvas->text(80 - $width, 796, $text, $font, $size);
        });
        return $pdf->stream($quotation->code.'.pdf');
    }

     private function analysesList($id){
        $samples = QuotationAnalysis::query()->with('testservice.method.method','testservice.testname','sample')
        ->whereHas('sample',function ($query) use ($id) {
            $query->whereHas('quotation',function ($query) use ($id) {
                $query->where('id',$id);
            });
        })
        ->orderBy('created_at','ASC')
        ->get();

        $groupedData = [];
        foreach ($samples as $row) {
            $sampleName = $row['sample']['name'];
            $testName = $row['testservice']['testname']['name'];
            $testMethod = $row['testservice']['method']['method']['name'];
            $testMethodShort = $row['testservice']['method']['method']['short'];
            
            $key = $sampleName . "_" . $testName . "_" . $testMethod;
            
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    "samplename" => $sampleName,
                    "testname" => $testName,
                    "method" => $testMethod,
                    "short" => $testMethodShort,
                    "count" => 0,
                    "fee" => $row['fee']
                ];
            }
            $groupedData[$key]["count"] += 1;
        }
        return $samples = array_values($groupedData);
    }

}
