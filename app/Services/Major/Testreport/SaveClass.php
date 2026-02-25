<?php

namespace App\Services\Major\Testreport;

use Hashids\Hashids;
use Carbon\Carbon;
use App\Models\UserRole;
use App\Models\ListLaboratory;
use App\Models\TsrSequence;
use App\Models\TsrSampleReport;
use App\Models\TsrSampleReportSignatory;
use Illuminate\Support\Str;

class SaveClass
{
    public function single($request){
        $laboratory_id = $request->laboratory_id;

        $lab_type = ListLaboratory::select('short')->where('id',$laboratory_id)->first();
        $c = TsrSampleReport::whereHas('sample',function ($query) use ($laboratory_id){
            $query->whereHas('tsr',function ($query) use ($laboratory_id){
                $query->where('laboratory_id',$laboratory_id);
            });
        })
        ->whereYear('created_at',date('Y'))->where('code','!=',NULL)->count();

        $code = TsrSequence::getNextCode($laboratory_id,11);

        $head = UserRole::with('user:id')
       ->where('laboratory_id',$laboratory_id)->whereHas('role',function ($query){
            $query->where('name','Technical Manager');
        })->where('is_active',1)->pluck('user_id');

        $check = TsrSampleReport::where('code',$code)->count();
        if($check == 0){
            $count = TsrSampleReport::where('sample_id',$request->id)->count();
            if($count == 0){
                $data = TsrSampleReport::create([
                    'code' => $code,
                    'sample_id' => $request->id,
                    'passkey' => $this->generatePasskey(),
                    'user_id' => \Auth::user()->id,
                    'tm_id' => $head[0]
                ]);
                $message = 'Report number was generated!';
            }else{
                $data = null;
                $message = 'The sample already has a report number.';
            }
        }else{
            $data = null;
            $message = 'Report number already generated!';
        }

        return [
            'data' => $data,
            'message' => $message, 
            'info' => "You've successfully generated the report number."
        ];
    }

    public function generatePasskey()
    {
        // Required components
        $uppercase = chr(rand(65, 90)); // A-Z
        $lowercase = chr(rand(97, 122)); // a-z
        $numbers = rand(10, 99); // two digits, e.g. "42"

        // Random 2 characters (any)
        $remaining = Str::random(2);

        // Combine all parts
        $raw = $uppercase . $lowercase . $numbers . $remaining;

        // Shuffle to randomize character order
        $passkey = Str::of(str_shuffle($raw))->substr(0, 6);

        return $passkey;
    }

    public function report($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);

        $data = TsrSampleReport::where('id',$id[0])->first();
        $attach = $this->upload($data,$request);
        $data->attachment = $attach;
        if($data->save()){
            if ($request->timestamp) {
                $alreadySigned = TsrSampleReportSignatory::where('report_id', $data->id)
                ->where('user_id', auth()->id())
                ->exists();

                if ($alreadySigned) {
                    return [
                        'data' => $data,
                        'message' => 'Already signed.',
                        'info' => 'You have already signed this report.'
                    ];
                }

                TsrSampleReportSignatory::create([
                    'report_id' => $data->id,
                    'timestamp' => $request->timestamp,
                    'user_id'   => auth()->id(),
                ]);
            }
        }
        
        return [
            'data' => $data->attachment,
            'message' => 'Testreport updated.', 
            'info' => 'Testreport details have been successfully updated.',
        ];
    }

    public function upload($data,$request){
        $name = $data->code;
        
        if($request->hasFile('pdf'))
        {   
            $pdf = $request->file('pdf');   
            $file_name = strtolower($name).'.'.$pdf->getClientOriginalExtension();
            $file_path = $pdf->storeAs('uploads/testreports', $file_name, 'public');
            $attachment = [
                'name' => $file_name,
                'file' => $file_path,
                'added_by' => \Auth::user()->id,
                'created_at' => date('M d, Y g:i a', strtotime(now()))
            ];
            return $attachment;
        }
    }
}
