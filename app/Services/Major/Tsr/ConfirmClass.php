<?php

namespace App\Services\Major\Tsr;

use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrSequence;

class ConfirmClass
{
    public function save($request){
        $tsr = Tsr::with('payment','samples')->where('id',$request->id)->first();
        if ($tsr->code) {
            return [
                'data' => $tsr,
                'message' => 'TSR already confirmed.',
                'info' => null,
            ];
        }

        $code = TsrSequence::getNextCode($tsr->laboratory_id,9);

        $tsr->update([
            'code' => $code,
            'due_at' => $request->due_at,
            'status_id' => (in_array($tsr->payment->discount_id, [5, 6, 7, 10, 11, 12])) ? 3 : $request->status_id
        ]);

        foreach ($tsr->samples as $sample) {

            if ($sample->code) {
                continue;
            }
            $sample->update([
                'code' => TsrSequence::getNextCode($tsr->laboratory_id,10)
            ]);
        }

         if($request->is_government){
            $tsr->status_id = 3;
            $tsr->save();
            $tsr->payment()->update(['status_id' => 18]);
        }

        return [
            'data' => $tsr,
            'message' => 'TSR was successfully confirmed!', 
            'info' => "You've successfully updated the tsr status.",
        ];
    }
}
