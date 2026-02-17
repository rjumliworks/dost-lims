<?php

namespace App\Services\Finance\Op;

use NumberFormatter;
use Hashids\Hashids;
use App\Models\Customer;
use App\Models\FinanceOp;
use App\Models\AgencyConfiguration;
use App\Models\AgencyFacilitySignatory;

class PrintClass
{
    public function op($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);
        $items = [];
        $data = FinanceOp::query()
        ->with('items.itemable:id,code,created_at,facility_id','items.itemable.samples:id,name,tsr_id','items.itemable.samples.analyses:id,sample_id,testservice_id','items.itemable.samples.analyses.testservice:id,testname_id','items.itemable.samples.analyses.testservice.testname:id,name')
        ->with('createdby:id','createdby.profile:id,firstname,lastname,user_id')
        ->with('payorable')
        ->where('id',$id)
        ->first()
        ->loadMorph('payorable', [
            Customer::class => [
                'customer_name:id,name,has_branches',
                'address:address,customer_id,region_code,province_code,municipality_code,barangay_code',
                'address.region:code,name,region',
                'address.province:code,name',
                'address.municipality:code,name',
                'address.barangay:code,name'
            ],
        ]);
        
        if($data){
            $samples_list = []; $facility_id = null;
            $customer = ($data->payorable->customer_name) ? $data->payorable->customer_name->name : $data->payorable->name; 
            if($data->payorable->customer_name){
                $sub = ($data->payorable->name == 'Main') ? '' : ' - '.$data->payorable->name;
                foreach($data->items as $item){
                    foreach($item->itemable->samples as $samples){
                        foreach($samples['analyses'] as $analysis){
                            $analyses[] = [$analysis['testservice']['testname']['name']];
                        }
                        $samples = [
                            'name' => $samples['name'],
                            'analyses' => $analyses
                        ];
                    }
                    $items[] = [
                        'name' => $item->itemable->code,
                        'date' => $item->itemable->created_at
                    ];
                    $facility_id = $item->facility_id;
                    $samples_list[] = $samples;
                    
                }
                $facility_id = $data->items[0]->itemable->facility_id;
            }
        }
        $val = trim($data->total, '₱ ');
        $val = (float) str_replace(',', '', $val);
        $wholeNumber = intval($val);
        $excess = $this->checkDecimal($val);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $number = $digit->format($wholeNumber);

        $signatory = AgencyFacilitySignatory::with('accountant.profile','cashier.profile')->where('facility_id',$facility_id)->first();
        $array = [
            'configuration' => AgencyConfiguration::with('agency.member')->first(),
            'lists' => $data->items,
            'code' => $data->code,
            'date' => $data->created_at,
            'total' => $data->total,
            'word' => ucwords($number).$excess,
            'customer' => $customer.$sub,
            'items' => $items,
            'samples' => $samples_list,
            'address' => $data->payorable->address->address.', '.$data->payorable->address->barangay->name.', '.$data->payorable->address->municipality->name.', '.$data->payorable->address->province->name,
            'cashier' => $signatory->cashier->profile->firstname.' '.$signatory->cashier->profile->middlename[0].'. '.$signatory->cashier->profile->lastname,
            'role' => ($signatory->is_cashier) ? 'Cashier' : 'Special Collecting Officer',
            'accountant' => $signatory->accountant->profile->firstname.' '.$signatory->accountant->profile->middlename[0].'. '.$signatory->accountant->profile->lastname,
        ];

        $pdf = \PDF::loadView('finance.op',$array)->setPaper('A4', 'portrait');
        return $pdf->stream('orderofpayment.pdf');
    }

    private function checkDecimal($number) {
        $decimal = $number - floor($number);
        $decimal = round($decimal, 2);
    
        if ($decimal == 0.00) {
            return ' And 00/100';
        } else {
            return ' And '.ltrim(substr($decimal, 2), '0').'/100';
        }
    }
}
