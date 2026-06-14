<?php

namespace App\Http\Controllers\Major;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use Illuminate\Support\Facades\Storage;
use App\Services\Major\Testreport\ViewClass;
use App\Services\Major\Testreport\SaveClass;
use App\Models\UserRole;

class TestreportController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;

    public function __construct(ViewClass $view, SaveClass $save){
        $this->view = $view;
        $this->save = $save;
    }

    public function index(Request $request){
        $laboratory = UserRole::where('user_id', auth()->id())->where('is_active', 1)->pluck('laboratory_id');
        switch($request->option){
            case 'list':
                return $this->view->list($request,$laboratory);
            break;
            case 'samples':
                return $this->view->samples($request);
            break;
            case 'reports':
                return $this->view->reports($request);
            break;
            case 'qrcode':
                return $this->view->qrcode($request);
            break;
            default :
                return inertia('Modules/Major/Testreports/Index',[
                    'count' => $this->view->count(),
                    'laboratories' => $this->view->laboratories()
                ]);
        }
    }

    public function store(Request $request){

   
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'single':
                    return $this->save->single($request);
                break;
                case 'multiple':
                    return $this->save->multiple($request);
                break;
                case 'report':
                    return $this->save->report($request);
                break;
                case 'reupload':
                    return $this->save->reupload($request);
                break;
                case 'signatory':
                    return $this->save->signatory($request);
                break;
                default: 
                    // return $this->save->signpdf($request);
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function show($id){
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

        return inertia('Modules/Major/Testreports/View',[
            'testreport' => $this->view->testreport($id),
            'analysts' => $this->view->analysts($id),
            'signature' => $signature
        ]);
    }
}
