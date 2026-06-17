<?php

namespace App\Http\Controllers\Major;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Major\ReleaseRequest;
use App\Services\Major\Releasing\SaveClass;
use App\Services\Major\Releasing\ViewClass;

class ReleasingController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;

    public function __construct(SaveClass $save, ViewClass $view){
        $this->view = $view;
        $this->save = $save;
    }
    
    public function index(Request $request){
        switch($request->option){
            case 'list':
                // return $this->releasing->lists($request);
                return $this->view->list($request);
            break;
            case 'filter':
                // return $this->releasing->filter($request);
            break;
             case 'search':
                return $this->view->search($request->keyword);
                // return $this->releasing->filter($request);
            break;
        }
    }

     public function store(ReleaseRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->save($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(ReleaseRequest $request){
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
}
