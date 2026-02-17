<?php

namespace App\Services\Major\Tsr;

use Hashids\Hashids;
use App\Models\UserRole;
use App\Models\Tsr;
use App\Models\TsrReport;
use App\Models\TsrAnalysis;
use App\Models\TsrPayment;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\AgencyConfiguration;
use App\Models\AgencyFacilitySignatory;
use App\Http\Resources\Major\Tsr\ListResource;
use App\Http\Resources\Major\Tsr\ViewResource;
use App\Http\Resources\Major\Tsr\AnalysisResource;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ViewClass
{
    public function counts($statuses){
        foreach($statuses as $status){
            if ($status['value'] == '2') {
                $counts[] = Tsr::where(function ($query) {
                    $query->where('status_id', 2)
                          ->orWhere(function ($query) {
                              $query->whereIn('status_id', [3, 4])
                                    ->whereHas('payment', function ($query) {
                                        $query->where('status_id', 18);
                                    });
                          });
                })
                // ->when($this->province, function ($query) {
                //     $query->where('received_by', \Auth::user()->id);
                // })
                // ->when($this->configuration->strict_mode == 1, function ($query) {
                //     $facility = \Auth::user()->profile->facility;

                //     if ($facility->is_psto || $facility->is_separated) {
                //         $query->where('facility_id', $facility->id);
                //     }
                // })
                // ->where('agency_id',$this->agency)
                ->count();
            } else {
                $counts[] = Tsr::where('status_id',$status['value'])
                // ->when($this->province, function ($query){
                //     $query->where('received_by', \Auth::user()->id);
                // })
                // ->when($this->configuration->strict_mode == 1, function ($query) {
                //     $facility = \Auth::user()->profile->facility;

                //     if ($facility->is_psto || $facility->is_separated) {
                //         $query->where('facility_id', $facility->id);
                //     }
                // })
                // ->where('agency_id',$this->agency)
                ->count();
            }
        }
        return $counts;
    }

    public function lists($request){
        $data = ListResource::collection(
            Tsr::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('laboratory:id,name','status:id,name,color,others')
            ->with('payment:tsr_id,id,total,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others')
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
                $query->select('id','tsr_id');
                $query->withCount([
                    'analyses as analyses_count',
                    'analyses as completed_analyses_count' => function ($query) {
                        $query->where('status_id', 12);
                    },
                    'analyses as ongoing_analyses_count' => function ($query) {
                        $query->where('status_id', 11);
                    }
                ]);
            }])
            ->when($request->status, function ($query, $status) {
                if ($status == '2') {
                    $query->where(function ($query) {
                        $query->where('status_id', 2) 
                              ->orWhere(function ($query) {
                                  $query->whereIn('status_id', [3,4]) 
                                        ->whereHas('payment', function ($query) {
                                            $query->where('status_id', 18);
                                        });
                              });
                    });
                } else {
                    $query->where('status_id', $status);
                }
            })
            ->when($request->datetype && $request->date, function ($query) use ($request) {
                $query->whereDate($request->datetype, $request->date);
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
            ->when($request->reminder, function ($query, $reminder) {
                switch($reminder){
                    case 'Memorandum of Agreement (MOA)':
                        $query->whereHas('payment', function ($query) {
                            $query->where('status_id',18);
                        });
                    break;
                    case 'Due Soon':
                        $query->whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])->where('status_id','!=',4);
                    break;
                    case 'Overdue Request':
                        $query->whereNotIn('status_id',[4,5])->whereDate('due_at','<',Carbon::now());
                    break;
                    case 'Report Pending':
                        $query->whereHas('samples',function ($query){
                            $query->whereDoesntHave('report')->whereHas('analyses', function ($query) {
                                $query->where('status_id', 12);
                            });
                        });
                        $query->where('status_id',4)->whereIn('laboratory_type',$this->type);
                    break;
                    case 'For Release':
                        $query->where('status_id',4)->whereHas('release', function ($query) {
                            $query->where('status_id',26)->where('created_at','>=', Carbon::now()->subDays(30));
                        });
                    break;
                    case 'Unclaimed Reports':
                        $query->where('status_id',4)->whereHas('release', function ($query) {
                            $query->where('status_id',26)->where('created_at','<=', Carbon::now()->subDays(30));
                        });
                    break;
                    case 'Completed with no report number':
                        $query->where('status_id',4)->whereHas('samples', function ($query) {
                            $query->doesntHave('report');
                        }, '=', 0);
                    break;
                }
            })
            // ->when($this->configuration->strict_mode == 1, function ($query) {
            //     $facility = \Auth::user()->profile->facility;

            //     if($facility->is_psto) { //|| $facility->is_separated
            //         $query->where('facility_id', $facility->id);
            //     }elseif($facility->is_separated){
            //         $query->where('laboratory_id',3);
            //     }
            // })
            ->when($request->region, function ($query, $region) {
                $query->whereHas('customer.address', function ($query) use ($region) {
                    $query->where('region_code', $region);
                });
            })
            ->when($request->province, function ($query, $province) {
                $query->whereHas('customer.address', function ($query) use ($province) {
                    $query->where('province_code', $province);
                });
            })
            ->when($request->municipality, function ($query, $municipality) {
                $query->whereHas('customer.address', function ($query) use ($municipality) {
                    $query->where('municipality_code', $municipality);
                });
            })
            ->when($request->barangay, function ($query, $barangay) {
                $query->whereHas('customer.address', function ($query) use ($barangay) {
                    $query->where('barangay_code', $barangay);
                });
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
            Tsr::query()
            ->with('samples.report',
                'samples.sampletype',
                'samples.samplename',
                'samples.category',
                'samples.analyses.started',
                'samples.analyses.ended',
                'samples.analyses.remarkable',
                'samples.analyses.addfee.service',
                'samples.analyses.testservice.testname',
                'samples.analyses.testservice.method.method',
                'samples.analyses.testservice.method.reference',
                'samples.analyses.testservice.fees'
            )
            ->with('services.service')
            ->with('mode','release:id','release.mode','release.user.profile')
            ->with('referral.agency.member','referral.province')
            ->with('received:id','received.profile:id,firstname,lastname,user_id')
            ->with('agency','laboratory:id,name','status:id,name,color,others')
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.wallet','customer.industry:id,name')
            ->with('customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name','customer.conformes')
            ->with('conforme:id,name,contact_no','customer.contact:id,email,contact_no,tin,customer_id')
            ->with('payment:tsr_id,id,total,subtotal,discount,or_number,is_paid,is_free,has_deduction,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others','payment.collection:id,name','payment.type:id,name','payment.discounted:id,name,value','payment.deduction')
            ->where('id',$id)->first()
        );
        return $data;
    }

    public function analyses($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = AnalysisResource::collection(
            TsrAnalysis::query()
            ->with('sample','status','started','ended','addfee.service')
            ->with('testservice.testname','testservice.method.method','testservice.method.reference','testservice.fees')
            ->whereHas('sample',function ($query) use ($id){
                $query->whereHas('tsr',function ($query) use ($id){
                    $query->where('id',$id);
                });
            })
            ->get()
        );
        return $data;
    }

    public function print($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);

        $tsrinfo = Tsr::where('id',$id)->with('laboratory')->first();
        $tsr = TsrReport::where('tsr_id',$id)->value('information');
        $secret = TsrReport::where('tsr_id',$id)->value('secret_key');
        $lab = json_decode($tsr);

        $signatory = AgencyFacilitySignatory::with('cashier.profile')->where('facility_id',$tsrinfo->facility_id)->first();

        $head = UserRole::with('user:id','user.profile:id,user_id,firstname,middlename,lastname')
       ->where('laboratory_id',$tsrinfo->laboratory->id)->whereHas('role',function ($query){
            $query->where('name','Technical Manager');
        })->where('is_active',1)->first();

        $url = $_SERVER['HTTP_HOST'].'/verification/'.$request->id;
        $result = new Builder(
            writer: new PngWriter(),
            data: $url,
            size: 300,
            margin: 10,
        );

        $qrCodeImageString = $result->build()->getString();
        $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);

        $wallet = Wallet::where('customer_id',$tsrinfo->customer_id)->value('available');
        $payment = TsrPayment::select('id','total','payment_id')->with('type:id,name')->where('tsr_id',$tsrinfo->id)->first();
        $transaction = WalletTransaction::where('transacable_id',$tsrinfo->id)->where('transacable_type','App\Models\Tsr')->first();
        $array = [
            'qrCodeImage' => $base64Image,
            'configuration' => AgencyConfiguration::with('agency.member')->where('agency_id',\Auth::user()->profile->agency_id)->first(),
            'tsr' => json_decode($tsr),
            'cashier' => $signatory->cashier->profile->firstname.' '.$signatory->cashier->profile->middlename[0].'. '.$signatory->cashier->profile->lastname,
            'manager' => ($head) ? $head->user->profile->firstname.' '.$head->user->profile->middlename[0].'. '.$head->user->profile->lastname : '',
            'user' => \Auth::user()->profile->firstname.' '.\Auth::user()->profile->middlename[0].'. '.\Auth::user()->profile->lastname,
            'color' => ($tsrinfo->laboratory) ? $tsrinfo->laboratory->color : 'black',
            'wallet' => ($wallet) ?  $wallet : '0.00',
            'payment' => $payment,
            'transaction' => $transaction,
            'secret' => $secret
        ]; 

        $pdf = \PDF::loadView('reports.tsr',$array)->setPaper('a4', 'portrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $copies = 3;
            $totalPagesPerCopy = $pageCount / $copies;
            $currentPageInCopy = ($pageNumber - 1) % $totalPagesPerCopy + 1;
            $text = "PAGE $currentPageInCopy OF $totalPagesPerCopy";
            $font = $fontMetrics->get_font("Helvetica", "normal");
            $size = 7;
            $width = $fontMetrics->get_text_width($text, $font, $size);
            $canvas->text(106 - $width, 796, $text, $font, $size);
        });
        return $pdf->stream($lab->code.'.pdf');
    }


    public function region(){
        return \Auth::user()->profile?->agency?->address?->region_code;
    }
}
