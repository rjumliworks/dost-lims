<?php

namespace App\Services\Major\Sample;

use App\Models\Tsr;
use App\Models\TsrReport;
use App\Models\TsrSample;

class ReportClass
{
    public function update($id){
        $tsr = Tsr::where('id',$id)
        ->with('services.service')
        ->with('received:id','received.profile:id,firstname,middlename,lastname,user_id')
        ->with('agency','laboratory:id,name','status:id,name,color,others')
        ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.wallet')
        ->with('customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name')
        ->with('conforme:id,name,contact_no','customer.contact:id,email,contact_no,customer_id')
        ->with('payment:tsr_id,id,total,subtotal,discount,or_number,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others','payment.collection:id,name','payment.type:id,name','payment.discounted:id,name,value')
        ->first();

        $samples = TsrSample::with(
            'analyses.testservice.method.method',
            'analyses.testservice.testname',
            'analyses.addfee.service',
            'sampletype','samplename','category'
            )
        ->whereHas('tsr',function ($query) use ($id) {
            $query->where('id',$id);
        })->get();

        $groupedData = [];
        foreach ($samples as $row) {
            $sampleCode = $row['code'];
            $sampleOther = $row['name'];
            $sampleCategory = $row['category']['name'];
            $sampleType = $row['sampletype']['name'];
            $sampleName = $row['samplename']['name'];
            
            foreach($row['analyses'] as $index=>$analysis){
                $testName = $analysis['testservice']['testname']['name'];
                $testMethod = $analysis['testservice']['method']['method']['name'];
                $testMethodShort = $analysis['testservice']['method']['method']['short'];
                $key = $sampleCode . "_" . $testName . "_" . $testMethod;
                
                if (!isset($groupedData[$key])) {
                    if($analysis['addfee']){
                        $fee = [
                            'name' => $analysis['addfee']['service']['name'],
                            'fee' => $analysis['addfee']['service']['fee'],
                            'quantity' => $analysis['addfee']['quantity'],
                            'total' => $analysis['addfee']['total']
                        ];
                    }else{
                        $fee = null;
                    }
                    $groupedData[$key] = [
                        "samplecode" => ($index == 0) ? $sampleCode : '',
                        "sampleother" => ($index == 0) ? $sampleOther : '-',
                        "sampletype" => ($index == 0) ? $sampleType : '-',
                        "samplename" => ($index == 0) ? $sampleName : '-',
                        "samplecategory" => ($index == 0) ? $sampleCategory : '-',
                        "testname" => $testName,
                        "method" => $testMethod,
                        "methodShort" => $testMethodShort,
                        "count" => 0,
                        "fee" => $analysis['fee'],
                        'additional' => $fee
                    ];
                }
                $groupedData[$key]["count"] += 1;
            }
        }
        if(isset($tsr->services) && count($tsr->services)){
           foreach ($tsr->services as $item) {
                $services[] = [
                    'name' => $item->service->name ?? null,
                    'description' => $item->service->description ?? null,
                    'quantity' => $item->quantity,
                    'fee' => $item->fee,
                    'total' => $item->total
                ];
            }
        }else{
            $services = null;
        }

        $samples = array_values($groupedData);

        $descs = TsrSample::query()
        ->where('tsr_id',$id)
        ->get();
        $d = ($tsr->customer->address->address != NULL || $tsr->customer->address->address != '') ? $tsr->customer->address->address.', ' : '';
        if($tsr->customer->address->municipality->name == 'Zamboanga City' || $tsr->customer->address->municipality->name == 'Isabela City'){
            $a = $tsr->customer->address->municipality->name;
        }else if($tsr->customer->address->province->name == 'Sulu'){
            $a = $tsr->customer->address->municipality->name.', '.$tsr->customer->address->province->name;
        }else{
            $a = $tsr->customer->address->municipality->name.', '.$tsr->customer->address->province->name.', '.$tsr->customer->address->region->region;
        }
        $information = [
            'code' => $tsr->code,
            'services' => $services,
            'date' => $tsr->created_at,
            'laboratory_id' => $tsr->laboratory_id,
            'due_at' => $tsr->due_at,
            'receiver' => $tsr->received->profile->firstname.' '.$tsr->received->profile->middlename[0].'. '.$tsr->received->profile->lastname,
            'customer' => [
                'name' => ($tsr->customer->is_main) ? $tsr->customer->customer_name->name :  $tsr->customer->customer_name->name.' - '.$tsr->customer->name,
                'address' => $d.$tsr->customer->address->barangay->name.', '.$a,
                'contact_no' => $tsr->customer->contact->contact_no,
                'email' => $tsr->customer->contact->email,
                'conforme' => [
                    'name' => $tsr->conforme->name,
                    'contact_no' => $tsr->conforme->contact_no
                ]
            ],
            'payment' => [
                'subtotal' => $tsr->payment->subtotal,
                'discount' => $tsr->payment->discount,
                'total' => $tsr->payment->total,
            ],
            'samples' => $samples,
            'descriptions' => $descs    
        ];
        if(TsrReport::where('tsr_id',$id)->count() > 0){
            $data = TsrReport::where('tsr_id',$id)->first();
            $data->information = json_encode($information);
            $data->save();
        }else{
            $data = TsrReport::create([
                'information' => json_encode($information,true),
                'tsr_id' => $id
            ]);
        }
        return true;
    }
}
