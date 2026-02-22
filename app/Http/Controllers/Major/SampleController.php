<?php

namespace App\Http\Controllers\Major;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\Major\Sample\ViewClass;
use App\Services\Major\Sample\SaveClass;
use App\Services\Major\Sample\DisposalClass;
use App\Http\Requests\Major\SampleRequest;

class SampleController extends Controller
{
    use HandlesTransaction;

    protected $view;
    protected $save;
    protected $disposal;

    public function __construct(ViewClass $view, SaveClass $save, DisposalClass $disposal){
        $this->view = $view;
        $this->save = $save;
        $this->disposal = $disposal;
    }

    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->view->list($request);
            break;
            default :
                return inertia('Modules/Major/Samples/Index',[
                    'counts' => $this->view->counts(),
                    'laboratories' => $this->view->laboratories()
                ]);
        }
    }

    public function store(SampleRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'delete':
                    return $this->save->delete($request);
                break;
                default:
                    return $this->save->save($request);
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->update($request);
        });
        
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function show($id){
        return inertia('Modules/Major/Samples/View',[
            'sample' => $this->view->sample($id),
            'analysts' => $this->view->analysts()
        ]);
    }

}
