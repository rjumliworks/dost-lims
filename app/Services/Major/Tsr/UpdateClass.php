<?php

namespace App\Services\Major\Tsr;

use Carbon\Carbon;
use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrReport;
use App\Models\TsrPayment;

class UpdateClass
{
    public function cancel($request){
        $tsr_id = $request->id;
        $data = Tsr::find($tsr_id);
        $data->update($request->except(['option']));
        $payment = TsrPayment::where('tsr_id',$tsr_id)->update(['status_id' => 9]);
        
        $cancel = $data->remarkable()->create([
            'amount' => $data->payment->subtotal,
            'reason' => $request->reason,
            'type_id' => 85,
            'user_id' => \Auth::user()->id
        ]);
        
        return [
            'data' => $data,
            'message' => 'TS Request Cancelled', 
            'info' => "Request has been cancelled. No further actions can be performed, including adding samples, analyses, or editing any information.",
        ];
    }

    public function update($request){
        $data = Tsr::with('payment')->where('id',$request->id)->first();
        $originalTime = Carbon::parse($data->created_at)->format('H:i:s');
        if($data->status_id == 1 || $data->status_id == 2){
            $data->customer_id = $request->customer['value'];
            $data->conforme_id = $request->conforme['value'];
            $data->purpose_id = $request->purpose_id;
            $data->created_at = Carbon::parse($request->created_at . ' ' . $originalTime);
            $data->due_at = $request->due_at;
            $data->laboratory_id = $request->laboratory_id;
            $data->save();
            if($data){
                
                if($data->payment->discount_id != $request->discount_id){
                    if(in_array($request->discount_id, [5, 6, 7])){
                        $data->payment->update([
                            'discount_id' => $request->discount_id,
                            'status_id' => 8,
                            'paid_at' => now(),
                            'is_free' => 1
                        ]);
                        $data->status_id = 3; //update to ongoing since it is gratis
                        $data->save();
                    }else{
                        $data->payment->update([
                            'discount_id' => $request->discount_id
                        ]);
                    }
                    $this->updateTotal($request->id);
                }
             
                $this->report($request->id);
            }

            $final =  Tsr::query()
            ->with('laboratory','status','received.profile')
            ->with('customer.customer_name','conforme','customer.address.region','customer.address.district','customer.address.province','customer.address.municipality','customer.address.barangay')
            ->with('payment.status','payment.collection','payment.type','payment.discounted')
            ->where('id',$request->id)
            ->first();

            return [
                'data' => $final,
                'message' => 'TSR was successfully updated!', 
                'info' => "You've successfully updated the tsr details.",
            ];
        }else{
            return [
                'data' => [],
                'message' => 'Action Not Allowed',
                'status' => false,
                'info' => 'This TSR has already been processed and can no longer be modified.'
            ];
        }

    }

     private function updateTotal($id){
        $data = TsrPayment::with('discounted')->where('tsr_id',$id)->first();
        $subtotal = (float) trim(str_replace(',','',$data->subtotal),'₱ ');
        if($data->discount_id === 1){
            $discount = 0;
            $subtotal = $subtotal;
            $total = $subtotal;
        }else{
            $subtotal = $subtotal; 
            $discount = (float) (($data->discounted->value/100) * $subtotal);
            $total =  ((float) $subtotal - (float) $discount);
        }
        $data->subtotal = $subtotal;
        $data->discount = $discount;
        $data->total = $total;
        $data->save();
        return $data;
    }

    public function report($id){
       
        $tsr = Tsr::where('id',$id)
        ->with('services.service')
        ->with('received:id','received.profile:id,firstname,middlename,lastname,user_id')
        ->with('agency','laboratory:id,name','status:id,name,color,others')
        ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches','customer.wallet')
        ->with('customer.address:address,customer_id,region_code,province_code,district_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name','customer.address.district:code,name')
        ->with('conforme:id,name,contact_no','customer.contact:id,email,contact_no,customer_id')
        ->with('payment:tsr_id,id,total,subtotal,discount,or_number,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others','payment.collection:id,name','payment.type:id,name','payment.discounted:id,name,value')
        ->first();

        $samples = TsrSample::with(
            'samplename','sampletype',
            'analyses.testservice.method.method','analyses.testservice.testname','analyses.addfee.service'
        )->whereHas('tsr',function ($query) use ($id) {
            $query->where('id',$id);
        })->get(); 

        $groupedData = [];
        foreach ($samples as $row) {
            $sampleCode = $row['code'];
            $sampleOther = $row['name'];
            $sampleName = $row['samplename']['name'];
            $sampleType = $row['sampletype']['name'];
           
            foreach($row['analyses'] as $index=>$analysis){
                $testName = $analysis['testservice']['testname']['name'];
                $testMethod = $analysis['testservice']['method']['method']['name'];
                $testMethodShort = $analysis['testservice']['method']['method']['short'];
                $key = $sampleCode . "_" . $testName . "_" . $testMethod;
                
                if (!isset($groupedData[$key])) {
                    if(isset($analysis['addfee']) && count($analysis['addfee'])){
                        foreach ($analysis['addfee'] as $item) {
                            $fees[] = [
                                'name' => $item['service']['name'],
                                'fee' => $item['service']['fee'],
                                'quantity' => $item['quantity'],
                                'total' => $analysis['total']
                            ];
                        }
                    }else{
                        $fees = null;
                    }
                    $groupedData[$key] = [
                        "samplecode" => ($index == 0) ? $sampleCode : '',
                        "samplename" => ($index == 0) ? $sampleName : '-',
                        "sampletype" => ($index == 0) ? $sampleType : '-',
                        "sampleother" => $sampleOther,
                        "testname" => $testName,
                        "method" => $testMethod,
                        "methodShort" => $testMethodShort,
                        "count" => 0,
                        "fee" => $analysis['fee'],
                        'additional' => $fees
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
        }else if($tsr->customer->address->municipality->name == 'Iloilo City'){
            $a = $tsr->customer->address->district->name.', '.$tsr->customer->address->municipality->name;
        }else if($tsr->customer->address->province->name == 'Sulu'){
            $a = $tsr->customer->address->municipality->name.', '.$tsr->customer->address->province->name;
        }else{
            $a = $tsr->customer->address->municipality->name.', '.$tsr->customer->address->province->name;
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
                'address1' => $d.$tsr->customer->address->barangay->name.', '.$a,
                'address2' => $tsr->customer->address->barangay->name.', '.$a,
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
            if(empty($data->secret_key)) {
                $data->secret_key = $this->generatePasskey();
            }
            $data->save();
        }else{
            $data = TsrReport::create([
                'information' => json_encode($information,true),
                'secret_key' => $this->generatePasskey(),
                'tsr_id' => $id
            ]);
        }
        return true;
    }

    private function generatePasskey($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $passkey = '';
        for ($i = 0; $i < $length; $i++) {
            $passkey .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $passkey;
    }
}
