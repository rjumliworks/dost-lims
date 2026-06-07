<?php

namespace App\Services\Major\Testreport;
use GuzzleHttp\Client;
use TCPDF;
use setasign\Fpdi\Tcpdf\Fpdi;
use Hashids\Hashids;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserRole;
use App\Models\ListLaboratory;
use App\Models\TsrSample;
use App\Models\TsrSequence;
use App\Models\TsrSampleReport;
use App\Models\TsrSampleReportList;
use App\Models\TsrSampleReportSignatory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Major\Testreport\WithReportResource;

class SaveClass
{
    public function signatory($request){
        $payload = array_filter([
            'analyzed_by' => $request->analyzed_by,
            'certified_by' => $request->certified_by,
        ]);
        $data = TsrSampleReportSignatory::where('id',$request->id)->update($payload);
        return [
            'data' => $data,
            'message' => 'wew', 
            'info' => "You've successfully generated the report number."
        ];
    }

    public function multiple($request){

        $laboratory_id = $request->laboratory_id;
        $lists = $request->checked;

        $head = UserRole::with('user:id')
        ->where('laboratory_id',$laboratory_id)->whereHas('role',function ($query){
            $query->where('name','Technical Manager');
        })->where('is_active',1)->pluck('user_id');

        if($request->is_single){
            $codes = [];
            $tsr_id = TsrSample::where('id',$lists[0])->first()->tsr_id;
            $code = TsrSequence::getNextCode($laboratory_id,11);
            $check = TsrSampleReport::where('code',$code)->count();
            if($check == 0){
                $data = TsrSampleReport::create([
                    'code' => $code,
                    'tsr_id' => $tsr_id,
                    'passkey' => $this->generatePasskey(),
                    'user_id' => \Auth::user()->id,
                    'tm_id' => $head[0]
                ]);
                if($data){
                    $data->signatory()->create([
                        'approved_by' => 3, //JTF ID
                        'status_id' => 38
                    ]);
                    foreach($lists as $i => $list){
                        $tspl = TsrSampleReportList::create([
                            'sample_id' => $list,
                            'report_id' => $data->id
                        ]);
                        $codes[] = [
                            'id' => $list,
                            'code' => $code
                        ];
                    }
                }
            }
        }else{
            $codes = [];
            foreach($lists as $i => $list){
                $count = TsrSampleReportList::where('sample_id',$list)->count();
                if($count == 0){
                    $tsr_id = TsrSample::where('id',$list)->first()->tsr_id;
                    $code = TsrSequence::getNextCode($laboratory_id,11);
                    $check = TsrSampleReport::where('code',$code)->count();
                    if($check == 0){
                        $errors = [];
                        $data = TsrSampleReport::create([
                            'code' => $code,
                            'tsr_id' => $tsr_id,
                            'passkey' => $this->generatePasskey(),
                            'user_id' => \Auth::user()->id,
                            'tm_id' => $head[0]
                        ]);
                        if($data){
                            $data->signatory()->create([
                                'approved_by' => 3, //JTF ID
                                'status_id' => 38
                            ]);
                            $tspl = TsrSampleReportList::create([
                                'sample_id' => $list,
                                'report_id' => $data->id
                            ]);
                        }
                        $codes[] = [
                            'id' => $list,
                            'code' => $code
                        ];
                    }
                }else{
                    $errors[] = 'A report number has already been assigned to the sample . '.$list;
                    $codes[] = [
                        'id' => $list,
                        'code' => TsrSampleReport::where('sample_id',$list)->value('code')
                    ];
                }
            }
        }

        return [
            'data' => $codes,
            'message' => 'Report number successfully generated!',
            'info' => "The laboratory analyst result has been recorded and the report number has been created."
        ];
    }

    public function single($request){
        $laboratory_id = $request->laboratory_id;

        $head = UserRole::with('user:id')
        ->where('laboratory_id',$laboratory_id)->whereHas('role',function ($query){
            $query->where('name','Technical Manager');
        })->where('is_active',1)->pluck('user_id');

        // $lab_type = ListLaboratory::select('short')->where('id',$laboratory_id)->first();
        // $c = TsrSampleReport::whereHas('sample',function ($query) use ($laboratory_id){
        //     $query->whereHas('tsr',function ($query) use ($laboratory_id){
        //         $query->where('laboratory_id',$laboratory_id);
        //     });
        // })
        // ->whereYear('created_at',date('Y'))->where('code','!=',NULL)->count();

        $code = TsrSequence::getNextCode($laboratory_id,11);

        $head = UserRole::with('user:id')
        ->where('laboratory_id',$laboratory_id)->whereHas('role',function ($query){
            $query->where('name','Technical Manager');
        })->where('is_active',1)->pluck('user_id');

        $check = TsrSampleReport::where('code',$code)->count();
        if($check == 0){
            $count = TsrSampleReportList::where('sample_id',$request->id)->count();
            // $count = TsrSampleReport::where('sample_id',$request->id)->count();
            if($count == 0){
                $tsr_id = TsrSample::where('id',$request->id)->first()->tsr_id;
                $data = TsrSampleReport::create([
                    'code' => $code,
                    'tsr_id' => $tsr_id,
                    'passkey' => $this->generatePasskey(),
                    'user_id' => \Auth::user()->id,
                    'tm_id' => $head[0]
                ]);
                if($data){
                    TsrSampleReportList::create([
                        'sample_id' => $request->id,
                        'report_id' => $data->id
                    ]);
                }
                if($data){
                    $data->signatory()->create([
                        'approved_by' => 3, //JTF ID
                        'status_id' => 38
                    ]);
                }
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

        if(isset($attach['error']) && $attach['error']){
            return [
                'data' => [],
                'message' => 'Failed to signed the PDF',
                'info' => $attach['message'],
                'status' => false
            ];
        }

        $data->attachment = $attach;
        if($data->save()){
            $signatory = TsrSampleReportSignatory::where('report_id', $data->id)->first();
            if($request->role == 'analyzed'){
                $signatory->update([
                    'analyzed_date' => now(),
                    'status_id' => 39
                    // 'analyzed_timestamp' => $request->timestamp
                ]);
            }

            if($request->role == 'certified'){
                $signatory->update([
                    'certified_date' => now(),
                    'status_id' => 40
                    // 'certified_timestamp' => $request->timestamp
                ]);
            }

            if($request->role == 'approved'){
                $signatory->update([
                    'approved_date' => now(),
                    'status_id' => 42
                    // 'approved_timestamp' => $request->timestamp
                ]);
            }
        }

        return [
            'data' => $data->attachment,
            'message' => 'Testreport updated.', 
            'info' => 'Testreport details have been successfully updated.',
        ];
    }

     public function reupload($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);
        $data = TsrSampleReport::where('id',$id[0])->first();
        $name = $data->code;
        $attach = null;

        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $extension = strtolower($pdf->getClientOriginalExtension());
            $file_name = strtolower($name) . '.' . $extension;
            $file_path = 'uploads/testreports/' . $file_name;

            $response = Http::attach(
                'file',
                file_get_contents($pdf->getRealPath()),
                $file_name
            )->post('http://127.0.0.1:8000/normalize',[
                'verification_url' => url('/verification/'.$data->reference)
            ]);

            if (!$response->successful()) {
                return [
                    'error' => true,
                    'message' => 'Normalization failed'
                ];
            }

            $normalizedPdf = $response->body();

            \Storage::disk('public')->put($file_path, $normalizedPdf);
            $signatory = TsrSampleReportSignatory::where('report_id', $data->id)->first();
            $signatory->analyzed_date = null;
            $signatory->certified_date = null;
            $signatory->approved_date = null;
            $signatory->status_id = 38;
            $signatory->save(); 
            $attach = [
                'name' => $file_name,
                'file' => $file_path,
                'added_by' => \Auth::user()->id,
                'created_at' => now()->format('M d, Y g:i a'),
            ];
        }

        $data->attachment = $attach;

        if($data->save()){
            return [
                'data' => $data->attachment,
                'message' => 'Testreport updated.', 
                'info' => 'Testreport details have been successfully updated.',
            ];
        }
    }

    public function upload($data, $request)
    {
        $name = $data->code;

        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $extension = strtolower($pdf->getClientOriginalExtension());
            $file_name = strtolower($name) . '.' . $extension;
            $file_path = 'uploads/testreports/' . $file_name;
            
            if ($data->attachment == null) {

                $response = Http::attach(
                    'file',
                    file_get_contents($pdf->getRealPath()),
                    $file_name
                )->post('http://127.0.0.1:8000/normalize',[
                    'verification_url' => url('/verification/'.$data->reference)
                ]);

                if (!$response->successful()) {
                    return [
                        'error' => true,
                        'message' => 'Normalization failed'
                    ];
                }

                $normalizedPdf = $response->body();

                \Storage::disk('public')->put($file_path, $normalizedPdf);
                $signatory = TsrSampleReportSignatory::where('report_id', $data->id)->first();
                $signatory->analyzed_date = null;
                $signatory->certified_date = null;
                $signatory->approved_date = null;
                $signatory->status_id = 38;
                $signatory->save(); 
                return [
                    'name' => $file_name,
                    'file' => $file_path,
                    'added_by' => \Auth::user()->id,
                    'created_at' => now()->format('M d, Y g:i a'),
                ];
            }

            $user = User::with('certificate')->where('id', auth()->id())->first();
            $p12Content = Storage::disk('s3')->get($user->certificate->file);

            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) mkdir($tempDir, 0755, true);

            $tempP12Path = $tempDir . '/' . basename($user->certificate->file);
            file_put_contents($tempP12Path, $p12Content);

            $signatureBytes = Storage::disk('s3')->get($user->certificate->signature);
            $tempDir2 = storage_path('app/temp');
            if (!file_exists($tempDir2)) mkdir($tempDir2, 0755, true);

            $tempSignaturePath = $tempDir2 . '/' . basename($user->certificate->signature);
            file_put_contents($tempSignaturePath, $signatureBytes);

            $response = Http::attach(
                'file',
                file_get_contents($pdf->getRealPath()),
                $file_name
            )->attach(
                'signature_file',  // <- match FastAPI parameter name
                file_get_contents($tempSignaturePath),
                basename($tempSignaturePath)
            )->post('http://127.0.0.1:8000/sign',[
                'p12_file' => $tempP12Path,
                'p12_pass' => $user->certificate->password,
                'field_name' => $request->role,
                'page_number' => $request->page,        // Page number from Vue
                'box_x0' => $request->box_x0,
                'box_y0' => $request->box_y0,
                'box_x1' => $request->box_x1,
                'box_y1' => $request->box_y1,
            ]);

            if (!$response->successful()) {
                return [
                    'error' => true,
                    'message' => $response->json('message')
                ]; // throw new \Exception($response);
            }

            $signedPdf = $response->body();

            \Storage::disk('public')->put($file_path,$signedPdf);

            return [
                'name' => $file_name,
                'file' => $file_path,
                'added_by' => \Auth::user()->id,
                'created_at' => now()->format('M d, Y g:i a'),
            ];
        }

        return null;
    }
}


       