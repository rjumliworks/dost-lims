<?php

namespace App\Http\Controllers\Major;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\Major\Testreport\ViewClass;
use App\Services\Major\Testreport\SaveClass;

class TestreportController extends Controller
{
    use HandlesTransaction;

    protected $view;
    protected $save;

    public function __construct(ViewClass $view, SaveClass $save){
        $this->view = $view;
        $this->save = $save;
    }

    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->view->list($request);
            break;
            case 'samples':
                return $this->view->samples($request);
            break;
            default :
                return inertia('Modules/Major/Testreports/Index',[
                    'count' => $this->view->count()
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
        return inertia('Modules/Major/Testreports/View',[
            'testreport' => $this->view->testreport($id)
        ]);
    }
}
