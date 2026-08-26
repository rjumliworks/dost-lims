<?php

namespace App\Services\Common\Signing;

use Hashids\Hashids;
use App\Models\User;
use App\Models\TsrSampleReport;
use App\Models\TsrSampleReportSignatory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ViewClass
{
    public function reports($request){
        $user_id = \Auth::user()->id;
        $data = TsrSampleReport::with('tsr:id,code,due_at',
        'signatory.analyzed:id','signatory.analyzed.profile',
        'signatory.certified:id','signatory.certified.profile',
        'signatory.approved:id','signatory.approved.profile',
        'lists.sample:id,code','user:id','user.profile')
        ->whereHas('signatory', function ($q) use ($user_id) {
            $q->where(function ($query) use ($user_id){
                $query->where('analyzed_by', $user_id)->where('status_id', 38);
            })->orWhere(function ($query) use ($user_id){
                $query->where('certified_by', $user_id)->where('status_id', 39);
            })->orWhere(function ($query) use ($user_id){
                $query->where('approved_by', $user_id)->where('status_id', 40);
            });
        })->get();

        return $data;
    }

    public function save($request){
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
            $isLastPage = $request->page == $request->total_pages;

            if($request->role == 'analyzed' && $isLastPage){
                $signatory->update([
                    'analyzed_date' => now(),
                    'status_id' => 39
                ]);
            }

            if($request->role == 'certified' && $isLastPage){
                $signatory->update([
                    'certified_date' => now(),
                    'status_id' => 40
                ]);
            }

            if($request->role == 'approved' && $isLastPage){
                $signatory->update([
                    'approved_date' => now(),
                    'status_id' => 42
                ]);
            }
        }

        $data = TsrSampleReport::with('tsr:id,code,due_at',
        'signatory.analyzed:id','signatory.analyzed.profile',
        'signatory.certified:id','signatory.certified.profile',
        'signatory.approved:id','signatory.approved.profile',
        'lists.sample:id,code','user:id','user.profile')
        ->where('id',$id[0])
        ->first();

        return [
            'data' => $data,
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

                $response = Http::attach(
                    'file',
                    file_get_contents($pdf->getRealPath()),
                    $file_name
                )->post('http://127.0.0.1:8000/normalize',[
                    'verification_url' => url('/verification/sample/'.$data->reference)
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

            $user = User::with('certificate', 'profile')->where('id', auth()->id())->first();
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
                'field_name' => $request->role . '_' . $request->page,
                'page_number' => $request->page,        // Page number from Vue
                'box_x0' => $request->box_x0,
                'box_y0' => $request->box_y0,
                'box_x1' => $request->box_x1,
                'box_y1' => $request->box_y1,
                'signer_name' => $user->profile?->pnpki_name,
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
