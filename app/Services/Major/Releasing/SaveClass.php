<?php

namespace App\Services\Major\Releasing;

use App\Models\Tsr;
use App\Jobs\SmsJob;
use App\Models\TsrRelease;
use App\Http\Resources\Major\Releasing\IndexResource;
class SaveClass
{
    public function save($request){
        $count = TsrRelease::where('tsr_id',$request->tsr_id)->count();
        if($count === 0){
            $data = TsrRelease::create(array_merge($request->all(),[
                'status_id' => 26
            ]));
            $contact = Tsr::with('customer.contact')->where('id',$request->tsr_id)->first()?->customer?->contact?->contact_no;
            $code = Tsr::where('id',$request->tsr_id)->first()?->code;
            $message = "Good day. This message is from the Department of Science and Technology- Regional Standards and Testing Laboratory. (DOST-RSTL). \n\nWe are pleased to inform you that the Test/Calibration Report for the Technical Service Request Number `$code` is now ready for pick up at the DOST IX Office, Pettit Barracks, Zamboanga City starting 4:00 PM today and the succeeding weekdays (except public holidays and Fridays) between 8:00 AM- 5:00 PM. \n\nKindly present the Customer’s Copy of the Technical Service Request and Valid ID when claiming, and filled-out authorization slip if applicable.\n\nThank you!"; 
            dispatch(new SmsJob($contact, $message));
        }else{
            $data = [];
        }
        return [
            'data' => $data,
            'message' => 'TSR ready to release successful!', 
            'info' => "You've successfully mark tsr for release."
        ];
    }

    public function update($request){
        $data = TsrRelease::where('id',$request->id)->update([
            'released_at' => $request->released_at,
            'user_id' => \Auth::user()->id,
            'status_id' => 27
        ]);

        $data = TsrRelease::with('tsr.customer:id,name_id,name,is_main','tsr.customer.customer_name:id,name,has_branches')
            ->with('user.profile')
            ->where('id',$request->id)->first();
            
        return [
            'data' => new IndexResource($data),
            'message' => 'TSR was released successful!', 
            'info' => "You've successfully released the tsr."
        ];
    }
}
