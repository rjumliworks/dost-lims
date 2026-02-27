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
            ->with('received:id','received.profile:id,firstname,lastname,user_id')
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
            ->with('received:id','received.profile:id,firstname,lastname,user_id')
            ->with('agency','laboratory:id,name','status:id,name,color,others')
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.wallet','customer.industry:id,name')
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
        ->with('services.service')
        ->with('signatory.prepared.profile:user_id,signature','signatory.approved.profile:user_id,signature','signatory.received.profile:user_id,signature')
        ->with('received:id','received.profile:id,firstname,lastname,middlename,user_id')
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
            $sampleName = ($row['name']) ? $row['name'] : $row['samplename']['name'];
            $sampleType = $row['sampletype']['name'];
            foreach ($row['analyses'] as $index => $analysis) {
                $testName = $analysis['testservice']['testname']['name'];
                $testMethod = $analysis['testservice']['method']['method']['name'];
                $shortMethod = $analysis['testservice']['method']['method']['short'];
                $key = $sampleName . "_" . $analysis['sampletype_id'] . "_" . $testName . "_" . $testMethod;

                // Initialize grouping if not yet set
                if (!isset($groupedData[$key])) {
                    $groupedData[$key] = [
                        "samplename" => ($index == 0) ? $sampleName : '-',
                        "sampletype" => ($index == 0) ? $sampleType : '-',
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
              
                    
                    foreach ($analysis['addfee'] as $addfee) {
                        // Extract fee info
                        $feeName = $addfee['service']['name'] ?? null;
                        $feeAmount = isset($addfee['service']['fee']) 
                            ? floatval(str_replace(['₱', ','], '', $addfee['service']['fee'])) 
                            : 0;
                        $feeQuantity = isset($addfee['quantity']) ? (int) $addfee['quantity'] : 1;
                        $feeTotal = isset($addfee['total']) 
                            ? floatval(str_replace(['₱', ','], '', $addfee['total'])) 
                            : $feeAmount * $feeQuantity;

                        // Ensure 'additional' array exists
                        if (!isset($groupedData[$key]['additional'])) {
                            $groupedData[$key]['additional'] = [];
                        }

                        // Look for existing fee by name
                        $found = false; 
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

        $samples2 = array_values($groupedData);
        $services = null;

        if(isset($quotation->services) && count($quotation->services) > 0){
            $services = $quotation->services->map(function($item){
                return [
                    'name' => $item->service->name ?? null,
                    'description' => $item->service->description ?? null,
                    'quantity' => $item->quantity ?? 1,
                    'fee' => $item->fee ?? 0,
                ];
            })->toArray();
        }

        $head = UserRole::with('user:id','user.profile:id,user_id,firstname,middlename,lastname')
        ->where('laboratory_id',$quotation->laboratory_id)->whereHas('role',function ($query){
            $query->where('name','Technical Manager');
        })->where('is_active',1)->first();

        $url = $_SERVER['HTTP_HOST'].'/quotation/'.$request->id;
        $result = new Builder(
            writer: new PngWriter(),
            data: $url,
            size: 300,
            margin: 10,
        );

        $qrCodeImageString = $result->build()->getString();
        $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

        $available = Wallet::where('customer_id', $quotation->customer_id)->value('available') ?? 0;
        $wallet = ($available != 0) ? trim(str_replace(',','',$available),'₱') : 0;
        $array= [
            'qrCodeImage' => $base64Image,
            'configuration' => AgencyConfiguration::first(),
            'quotation' => new ViewResource($quotation),
            'samples' => $samples,
            'group' => $samples2,
            'services' => $services,
            'descs' => $descs,
            'wallet' => $wallet,
            'manager' => $head->user->profile->firstname.' '.$head->user->profile->middlename[0].'. '.$head->user->profile->lastname,
            'user' => $quotation->received->profile->firstname.' '.$quotation->received->profile->middlename[0].'. '.$quotation->received->profile->lastname,
            'signatory' => $quotation->signatory
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
            $canvas->text(106 - $width, 796, $text, $font, $size);
        });

        $signatory = $quotation->signatory;

        $latestDate = collect([
            $signatory->prepared_date,
            $signatory->approved_date,
            $signatory->received_date,
        ])->filter()->max();

        $pdfBinary = $dompdf->output();

        $meta = "\n%--- DOC META ---\n";
        $meta .= "% ValidationHMAC: {$signatory->hmac}\n";
        $meta .= "% GeneratedAt: " . $latestDate . "\n";
        $meta .= "% Version: {$signatory->version}\n";
        $meta .= "%--- END META ---\n";

        $pos = strrpos($pdfBinary, '%%EOF');
        if ($pos !== false) {
            $pdfBinary = substr_replace($pdfBinary, $meta . '%%EOF', $pos, 5);
        } else {
            $pdfBinary .= $meta . "%%EOF\n";
        }

        return response($pdfBinary)
            ->header('Content-Type', 'application/pdf')
             ->header('Content-Disposition', 'inline; filename="' . $quotation->code . '.pdf"');
        // return $pdf->stream($quotation->code.'.pdf');
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
