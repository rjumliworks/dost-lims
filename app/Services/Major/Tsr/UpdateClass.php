<?php

namespace App\Services\Major\Tsr;

use Carbon\Carbon;
use App\Models\Tsr;
use App\Models\TsrPayment;
use App\Models\TsrReferral;
use App\Models\TsrAmendment;
use App\Models\ListStatus;

class UpdateClass
{
    public function paid($request){
        $tsr_id = $request->id;
        $data = Tsr::find($tsr_id);
        $data->status_id = $request->status_id;
        if($data->save()){
           TsrPayment::where('tsr_id',$tsr_id)->update(['status_id' => 45]);
        }

        return [
            'data' => $data,
            'message' => 'Payment Status Updated',
            'info' => 'The TSR has been successfully marked as paid. Its status is now Ongoing, and analysts can begin processing and tagging the analyses.',
        ];
    }

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

    public function referral($request){
        $data = TsrReferral::where('id',$request->id)->first();
        $data->agency_id = $request->agency_id;
        $data->province_code = $request->province_code;
        $data->is_psto = ($request->province_code) ? 1 : 0; 
        $data->save();

        return [
            'data' => $data,
            'message' => 'Referral Updated Successfully', 
            'info' => "The referral details have been updated and saved to the TSR."
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
            $data->release_id = $request->release_id;
            if($request->has('is_referral')){
                $data->is_referral = $request->is_referral;
            }
            $data->save();

            if($request->has('is_referral')){
                if($request->is_referral){
                    $isPsto = $request->agency_id == $request->my_agency && $request->province_code;
                    $referralData = [
                        'is_psto' => $isPsto,
                        'province_code' => $isPsto ? $request->province_code : null,
                        'agency_id' => $request->agency_id,
                    ];
                    $data->referral ? $data->referral->update($referralData) : $data->createReferral($referralData);
                }elseif($data->referral){
                    $data->referral->delete();
                }
            }

            if($data){
                
                if($data->payment->discount_id != $request->discount_id){
                    if(in_array($request->discount_id, [5, 6, 7])){
                        $data->payment->update([
                            'discount_id' => $request->discount_id,
                            'status_id' => 8,
                            'paid_at' => now(),
                            'is_free' => 1
                        ]);
                        ($data->status_id == 2) ? $data->status_id = 3 : ''; //update to ongoing since it is gratis
                        $data->save();
                    }else{
                        $data->payment->update([
                            'discount_id' => $request->discount_id
                        ]);
                    }
                    $this->updateTotal($request->id);
                }
             
                \Artisan::call('report', ['id' => $request->id]);
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

    public function requestDueDateAmendment($request){
        $tsr = Tsr::findOrFail($request->id);

        $pending = TsrAmendment::where('tsr_id', $tsr->id)
            ->whereHas('status', function ($query) {
                $query->where('type', 'Amendment')->where('name', 'Pending');
            })
            ->first();

        if ($pending) {
            if ($pending->requested_by != \Auth::user()->id) {
                return [
                    'data' => [],
                    'message' => 'Update Request Not Submitted',
                    'info' => 'This TSR already has a pending due date update request awaiting review by the Technical Manager.',
                    'status' => false,
                ];
            }

            $pending->update([
                'proposed_due_at' => $request->proposed_due_at,
                'remarks' => $request->remarks,
            ]);

            return [
                'data' => $pending->toArray(),
                'message' => 'Update Request Revised',
                'info' => "Your pending due date update request has been revised and is still awaiting approval from the Technical Manager."
            ];
        }

        $status = ListStatus::where('type','Amendment')->where('name','Pending')->first();

        $amendment = TsrAmendment::create([
            'tsr_id' => $tsr->id,
            'previous_due_at' => $tsr->getRawOriginal('due_at'),
            'proposed_due_at' => $request->proposed_due_at,
            'remarks' => $request->remarks,
            'requested_by' => \Auth::user()->id,
            'status_id' => $status->id,
        ]);

        return [
            'data' => $amendment->toArray(),
            'message' => 'Update Request Submitted',
            'info' => "Your requested due date update is now pending approval from the Technical Manager."
        ];
    }

     private function updateTotal($id){
        $data = TsrPayment::with('discounted','deduction')->where('tsr_id',$id)->first();
        $subtotal = (float) trim(str_replace(',','',$data->subtotal),'₱ ');
        $deduction = 0;
        if($data->deduction){
            $deduction = (float) trim(str_replace(',','',$data->deduction->amount),'₱ ');
        }
        if($data->discount_id === 1){
            $discount = 0;
            $subtotal = $subtotal;
            $total = $subtotal - $deduction;
        }else{
            $subtotal = $subtotal; 
            $discount = (float) (($data->discounted->value/100) * $subtotal);
            $total =  ((float) $subtotal - (($data->discounted->value == 100) ? 0 : (float) $discount));
        }
        $data->subtotal = $subtotal;
        $data->discount = $discount;
        $data->total = $total;
        $data->save();
        return $data;
    }

}
