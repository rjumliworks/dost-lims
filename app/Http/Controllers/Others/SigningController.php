<?php

namespace App\Http\Controllers\Others;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\Others\Signing\ViewClass;

class SigningController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;

    public function __construct(ViewClass $view){
        $this->view = $view;
    }

    public function index(Request $request){
        switch($request->option){
            default :
                $user = auth()->user(); // or your target user
                $signature = null;

                if ($user->certificate && $user->certificate->signature) {
                    // Get S3 bytes
                    $signatureBytes = Storage::disk('s3')->get($user->certificate->signature);

                    // Get MIME type
                    $mime = Storage::disk('s3')->mimeType($user->certificate->signature);

                    // Convert to base64
                    $signature = 'data:' . $mime . ';base64,' . base64_encode($signatureBytes);
                }
                return inertia('Others/Signing/Index',[
                    'signature' => $signature
                ]);
        }
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'report':
                    return $this->view->save($request);
                break;
                case 'normalize':
                    return $this->view->normalizeOnly($request);
                break;
                case 'sign':
                    return $this->view->signOnly($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }
}
