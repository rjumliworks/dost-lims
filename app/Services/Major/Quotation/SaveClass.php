<?php

namespace App\Services\Major\Quotation;

use Carbon\Carbon;
use Hashids\Hashids;
use App\Models\Tsr;
use App\Models\Quotation;
use App\Models\QuotationSample;
use App\Models\QuotationAnalysis;
use App\Models\QuotationService;

class SaveClass
{
    public function validation($request){
        return [
            'data' => '-',
            'message' => 'off', 
            'info' => "You've successfully created the new customer."
        ];
    }
    
    public function save($request)
    {
        $quotation = Quotation::create(array_merge(
            $request->quotationData(),
        ));

        if($request->is_referral){
            $quotation->createReferral($request->referralData());
        }
       
        $quotation = Quotation::find($quotation->id);
        return [
            'data' => $quotation->reference,
            'message' => 'Quotation creation was successful!', 
            'info' => "You've successfully created the new quotation."
        ];
    }

    public function tsr($request){
        $id = $request->id;
        $data = Tsr::create([
            'customer_id' => $request->customer_id,
            'conforme_id' => ($request->conforme) ? $request->conforme['value'] : $request->conforme_id,
            'purpose_id' => $request->purpose_id,
            'release_id' => $request->release_id,
            'laboratory_id' => $request->laboratory_id,
            'is_referral' => $request->is_referral,
            'status_id' => 1
        ]);
        if($request->is_referral){
            $referral = QuotationReferral::where('quotation_id',$id)->first();
            $data->referral()->create([
                'is_psto' => ($referral->province_code) ? 1 : 0,
                'province_code' => ($referral->province_code) ? $referral->province_code : null,
                'agency_id' => $referral->agency_id
            ]);
        }
        if($data){
            $data->payment()->create([
                'total' => $request->total,
                'subtotal' => $request->subtotal,
                'discount' => $request->discount,
                'discount_id' => $request->discount_id,
                'status_id' => 6,
                'is_free' =>  (in_array($request->discount_id, [5, 6, 7, 10, 11, 12])) ? 1 : 0,
                'paid_at' =>  (in_array($request->discount_id, [5, 6, 7, 10, 11, 12])) ? now() : NULL,
            ]);
            $samples = QuotationSample::with('analyses.addfee.service')->where('quotation_id',$id)->get();
           
            foreach($samples as $sample){
                $s = $data->samples()->create([
                    'name' => $sample['name'],
                    'samplename_id' => $sample['samplename_id'],
                    'sampletype_id' => $sample['sampletype_id'],
                    'category_id' => $sample['category_id'],
                    'customer_description' => $sample['customer_description'],
                    'description' => $sample['description'],
                    'tsr_id' => $data->id
                ]);
                foreach($sample['analyses'] as $analysis){
                    // dd($analysis['id']);
                    $a = $s->analyses()->create([
                        'fee' => $analysis['fee'],
                        'testservice_id' => $analysis['testservice_id'],
                        'sample_id' =>$s->id,
                        'status_id' => 10
                    ]);

                    $services = QuotationService::where('typeable_id',$analysis['id'])->where('typeable_type','App\Models\QuotationAnalysis')->get();
                    foreach($services as $service){
                        $a->addfee()->create([
                            'fee' => $service['fee'],
                            'total' => $service['total'],
                            'quantity' => $service['quantity'],
                            'service_id' => $service['service_id'],
                            'is_additional' => $service['is_additional'],
                        ]);
                    }
                }
            }
            $services = QuotationService::where('typeable_id',$id)->where('typeable_type','App\Models\Quotation')->get();
            foreach($services as $service){
                $data->services()->create([
                    'fee' => $service['fee'],
                    'total' => $service['total'],
                    'quantity' => $service['quantity'],
                    'service_id' => $service['service_id'],
                    'is_additional' => $service['is_additional'],
                ]);
            }
            $status = Quotation::where('id',$id)->update(['status_id' => 16]);
        }

        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($data->id);

        return [
            'data' => $code,
            'message' => 'TS Request creation was successful!', 
            'info' => "You've successfully created the new request."
        ];
    }

    public function sample($request){
        $count = (int) $request->count;
        for ($i = 0; $i < $count; $i++) {
            QuotationSample::create($request->all());
        }
        
        return [
            'data' => true,
            'message' => 'Sample Added Successfully', 
            'info' => "The sample has been added and is now linked to this TSR."
        ];
    }

    public function analysis($request){
        foreach($request->samples as $sample){
            foreach($request->lists as $list){
                $data = QuotationAnalysis::create(array_merge($request->all(),[
                    'testservice_id' => $list['id'],
                    'fee' => $list['fee_num'],
                    'sample_id' => $sample
                ]));
                $data = QuotationAnalysis::with('sample','testservice.method.method')->where('id',$data->id)->first();
                $total =  $this->updateTotal($data->sample->quotation_id,$list['fee']);
            }
        }
        return [
            'data' => $total,
            'message' => 'Analysis added was successful!', 
            'info' => "You've successfully created the new analysis."
        ];
    }

    public function analysisdelete($request){
        $id = $request->id;
        $quotation_id = $request->quotation_id;
        $data = QuotationAnalysis::find($id);
        $fee = (float) trim(str_replace(',','',$data->fee),'₱ ');
        if($data->delete()){
            $service = QuotationService::where('typeable_type','App\Models\TsrAnalysis')->where('typeable_id',$id)->first();
            $total_service = ($service) ? (float) trim(str_replace(',','',$service->total),'₱ ') : 0;
            $payment = Quotation::with('discounted')->where('id',$quotation_id)->first();
            $subtotal = (float) trim(str_replace(',','',$payment->subtotal),'₱ ');
            $total = (float) trim(str_replace(',','',$payment->total),'₱ ');
            if($payment->discount_id === 1){
                $discount = 0;
                $subtotal = $subtotal - $fee - $total_service;
                $total = $total - $fee - $total_service;
            }else{
                $subtotal = $subtotal - $fee - $total_service;
                $discount = (float) (($payment->discounted->value/100) * $subtotal);
                $total =  ((float) $subtotal - (float) $discount);
            }
            $payment->subtotal = $subtotal;
            $payment->discount = $discount;
            $payment->total = $total;
            $payment->save();
        }
        return [
            'data' => $payment->total,
            'message' => 'Test service was removed successful!', 
            'info' => "You've successfully remove the sample."
        ];
    }

    public function sampledelete($request){
        $id = $request->id;
        $quotation_id = $request->quotation_id;
        $data = QuotationSample::find($id);
        $fee = $data->analyses()->sum('fee');
        if($data->delete()){
            $payment = Quotation::with('discounted')->where('id',$quotation_id)->first();
            $subtotal = (float) trim(str_replace(',','',$payment->subtotal),'₱ ');
            $total = (float) trim(str_replace(',','',$payment->total),'₱ ');
            if($payment->discount_id === 1){
                $discount = 0;
                $subtotal = $subtotal - $fee;
                $total = $total - $fee;
            }else{
                $subtotal = $subtotal - $fee;
                $discount = (float) (($payment->discounted->value/100) * $subtotal);
                $total =  ((float) $subtotal - (float) $discount);
            }
            $payment->subtotal = $subtotal;
            $payment->discount = $discount;
            $payment->total = $total;
            $payment->save();
        }
        return [
            'data' => $payment->total,
            'message' => 'Sample Deletion Successful', 
            'info' => "The selected sample has been deleted successfully and is no longer linked to this Quotation."
        ];
    }

    public function fee($request){
        $data = QuotationAnalysis::findOrFail($request->id);
        $grandTotal = 0;

        foreach($request->services as $service){
            $fee = str_replace(['₱', ','], '', $service['fee']);
            $quantity = $service['quantity'];
            $total = $fee * $quantity;
            $data->addfee()->create([
                'service_id' => $service['id'],
                'fee' => $fee,
                'total' => $total,
                'quantity' => $quantity,
                'is_additional' => 1
            ]);
            $grandTotal += $total;
        }
        $total = $this->updateTotal($request->quotation_id, $grandTotal);
        return [
            'data' => $total,
            'message' => 'Additional Fee Added Successfully', 
            'info' => "Additional fee has been added and linked to this TSR as an add-on."
        ];
    }

    public function removefee($request){
        $data= QuotationService::where('id', $request->id)->where('is_additional', 1)->firstOrFail();
        $fee = (float) trim(str_replace(',','',$data->total),'₱ ');
        if($data->delete()){
            $service = QuotationService::where('typeable_type','App\Models\QuotationAnalysis')->where('typeable_id',$request->id)->first();
            $total_service = ($service) ? (float) trim(str_replace(',','',$service->total),'₱ ') : 0;
            $payment = Quotation::with('discounted')->where('id',$request->quotation_id)->first();
            $subtotal = (float) trim(str_replace(',','',$payment->subtotal),'₱ ');
            $total = (float) trim(str_replace(',','',$payment->total),'₱ ');
            if($payment->discount_id === 1){
                $discount = 0;
                $subtotal = $subtotal - $fee - $total_service;
                $total = $total - $fee - $total_service;
            }else{
                $subtotal = $subtotal - $fee - $total_service;
                $discount = (float) (($payment->discounted->value/100) * $subtotal);
                $total =  ((float) $subtotal - (float) $discount);
            }
            $payment->subtotal = $subtotal;
            $payment->discount = $discount;
            $payment->total = $total;
            $payment->save();
        }

        return [
            'data' => $total,
            'message' => 'Additional Fee removed Successfully', 
            'info' => "Additional fee has been remove and unlinked to this TSR as an add-on."
        ];
    }

    public function service($request){
        $data = Quotation::findOrFail($request->id);
        $data->services()->create([
            'service_id' => $request->service['value'],
            'fee' => $request->service['fee'],
            'quantity' => $request->quantity,
            'total' => $request->total,
        ]);
        $total = $this->updateTotal($request->id,$request->total);
        return [
            'data' => $total,
            'message' => 'Additional Service Added Successfully', 
            'info' => "The selected service has been added and linked to this TSR as an add-on."
        ];
    }

     public function removeService($request){
        $data = QuotationService::find($request->id);
        $fee = (float) trim(str_replace(',','',$data->total),'₱ ');
        if($data->delete()){
            $payment = Quotation::with('discounted')->where('id',$request->quotation_id)->first();
            $subtotal = (float) trim(str_replace(',','',$payment->subtotal),'₱ ');
            $total = (float) trim(str_replace(',','',$payment->total),'₱ ');
            if($payment->discount_id === 1){
                $discount = 0;
                $subtotal = $subtotal - $fee;
                $total = $total - $fee;
            }else{
                $subtotal = $subtotal - $fee;
                $discount = (float) (($payment->discounted->value/100) * $subtotal);
                $total =  ((float) $subtotal - (float) $discount);
            }
            $payment->subtotal = $subtotal;
            $payment->discount = $discount;
            $payment->total = $total;
            $payment->save();
        }

        return [
            'data' => $total,
            'message' => 'Additional Service Removed Successfully',
            'info' => 'The selected additional service has been removed from this TSR.'
        ];
    }

    public function copy($request){
        $old = Quotation::with('referral','services','samples.analyses.addfee')->where('id',$request->id)->first();
        $data = Quotation::create([
            'status_id' => 14,
            'total' => $old->total,
            'subtotal' => $old->subtotal,
            'discount' => $old->discount,
            'purpose_id' => $old->purpose_id,
            'customer_id' =>$old->customer_id,
            'conforme_id' => $old->conforme_id,
            'release_id' => $old->release_id,
            'discount_id' => $old->discount_id,
            'laboratory_id' => $old->laboratory_id,
            'created_by' => \Auth::user()->id,
            'is_onsite' => $old->is_onsite,
            'is_referral' => $old->is_referral,
            'created_at'  => Carbon::now(),
        ]);
        
        if($old->is_referral){  
            $data->referral()->create([
                'is_psto' => $old->referral->is_psto, 
                'province_code' => $old->referral->province_code,
                'agency_id' => $old->referral->agency_id
            ]);
        }

        if(count($old->services) > 0){
            foreach($old->services as $service){
                $data->services()->create([
                    'fee' => $service->fee,
                    'total' => $service->total,
                    'quantity' => $service->quantity,
                    'service_id' => $service->service_id,
                    'is_additional' => $service->is_additional
                ]);
            }
        }

        foreach($old->samples as $sample){
            $s = $data->samples()->create([
                'name' => $sample->name,
                'samplename_id' => $sample->samplename_id,
                'sampletype_id' => $sample->sampletype_id,
                'category_id' => $sample->category_id,
                'customer_description' => $sample->customer_description,
                'description' => $sample->description,
            ]);
            foreach($sample->analyses as $analysis){
                $a = $s->analyses()->create([
                    'fee' => $analysis->fee,
                    'testservice_id' => $analysis->testservice_id
                ]);
               
                foreach($analysis->addfee as $fee){
                    $a->addfee()->create([
                        'fee' => $fee->fee,
                        'total' => $fee->total,
                        'quantity' => $fee->quantity,
                        'service_id' => $fee->service_id,
                        'is_additional' => $fee->is_additional
                    ]);
                }
            }
        }

        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($data->id);

        return [
            'data' => $code,
            'message' => 'qUOTATION creation was successful!', 
            'info' => "You've successfully created the new quotation."
        ];
    }

    private function updateTotal($id,$fee){
        $data = Quotation::with('discounted')->where('id',$id)->first();
        $fee = (float) trim(str_replace(',','',$fee),'₱ ');
        $subtotal = (float) trim(str_replace(',','',$data->subtotal),'₱ ');
        if($data->discount_id === 1){
            $discount = 0;
            $subtotal = $subtotal + $fee;
            $total = $subtotal;
        }else{
            $subtotal = $subtotal + $fee;
            $discount = (float) (($data->discounted->value/100) * $subtotal);
            $total =  ((float) $subtotal - (float) $discount);
        }
        $data->subtotal = $subtotal;
        $data->discount = $discount;
        $data->total = $total;
        $data->save();
        return $data->total;
    }
}
