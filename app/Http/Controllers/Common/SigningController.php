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
        $user = auth()->user();
        $signature = null;

        if ($user->certificate && $user->certificate->signature) {
            $signatureBytes = Storage::disk('s3')->get($user->certificate->signature);
            $mime = Storage::disk('s3')->mimeType($user->certificate->signature);
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

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'report':
                    return $this->view->save($request);
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
