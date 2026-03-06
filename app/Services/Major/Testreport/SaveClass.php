<?php

namespace App\Services\Major\Testreport;
use GuzzleHttp\Client;
use TCPDF;
use setasign\Fpdi\Tcpdf\Fpdi;
use Hashids\Hashids;
use Carbon\Carbon;
use App\Models\UserRole;
use App\Models\ListLaboratory;
use App\Models\TsrSequence;
use App\Models\TsrSampleReport;
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
                if($data){
                    $data->signatory()->create([
                        'approved_by' => 3 //JTF ID
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
        $data->save();

        return [
            'data' => $data->attachment,
            'message' => 'Testreport updated.', 
            'info' => 'Testreport details have been successfully updated.',
        ];
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

                \Storage::disk('public')->put($file_path, file_get_contents($pdf->getRealPath()));
                return [
                    'name' => $file_name,
                    'file' => $file_path,
                    'added_by' => \Auth::user()->id,
                    'created_at' => now()->format('M d, Y g:i a'),
                ];
            }
            
            $response = Http::attach(
                'file',
                file_get_contents($pdf->getRealPath()),
                $file_name
            )->post('http://127.0.0.1:8000/signs');

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


       // $data = TsrSampleReport::where('id',$id[0])->first();
        // $attach = $this->upload($data,$request);
        // $data->attachment = $attach;
        // if($data->save()){
        //     // if ($request->timestamp) {
        //     //     $alreadySigned = TsrSampleReportSignatory::where('report_id', $data->id)
        //     //     ->where('user_id', auth()->id())
        //     //     ->exists();

        //     //     if ($alreadySigned) {
        //     //         return [
        //     //             'data' => $data,
        //     //             'message' => 'Already signed.',
        //     //             'info' => 'You have already signed this report.'
        //     //         ];
        //     //     }

        //     //     TsrSampleReportSignatory::create([
        //     //         'report_id' => $data->id,
        //     //         'timestamp' => $request->timestamp,
        //     //         'user_id'   => auth()->id(),
        //     //     ]);
        //     // }
        // }


        // Read PDF bytes
            // $pdfBinary = file_get_contents($pdf->getRealPath());

            // Compute HMAC
            // $secret = config('app.key');
            // $hmac = hash_hmac('sha256', $pdfBinary, $secret);

            // Prepare metadata
            // $meta = "\n%--- DOC META ---\n";
            // $meta .= "% ValidationHMAC: {$hmac}\n";
            // $meta .= "% GeneratedAt: " . now()->toDateTimeString() . "\n";
            // $meta .= "%--- END META ---\n";

            // // Insert metadata just before the last %%EOF
            // $pos = strrpos($pdfBinary, '%%EOF');
            // if ($pos !== false) {
            //     $pdfBinary = substr_replace($pdfBinary, $meta . '%%EOF', $pos, 5);
            // } else {
            //     $pdfBinary .= $meta . "%%EOF\n";
            // }

            // Save the PDF to storage