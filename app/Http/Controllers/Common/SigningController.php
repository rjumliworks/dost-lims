<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use Illuminate\Support\Facades\Storage;
use App\Services\Common\Signing\ViewClass;

class SigningController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;

    public function __construct(ViewClass $view){
        $this->view = $view;
    }

    public function index(Request $request){
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

        switch($request->option){
            default:
            return inertia('Modules/Signing/Index',[
                'reports' => $this->view->reports($request),
                'signature' => $signature
            ]);
        }
    }
}
