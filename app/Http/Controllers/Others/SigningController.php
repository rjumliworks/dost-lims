<?php

namespace App\Http\Controllers\Others;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SigningController extends Controller
{
    use HandlesTransaction;

    public function index(Request $request){
        switch($request->option){
            case 'items':
                return $this->view->items($request);
            break;
            default :
            return inertia('Others/Signing/Index');
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
}
