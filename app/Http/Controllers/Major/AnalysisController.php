<?php

namespace App\Http\Controllers\Major;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Major\Analysis\ViewClass;
use App\Services\Major\Analysis\SaveClass;
use App\Services\Major\Analysis\UpdateClass;
use App\Http\Requests\Major\AnalysisRequest;

class AnalysisController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected UpdateClass $update;

    public function __construct(ViewClass $view, SaveClass $save, UpdateClass $update){
        $this->view = $view;
        $this->save = $save;
        $this->update = $update;
    }

    public function index(Request $request){
        switch($request->option){
            case 'testservices':
                return $this->view->testservices($request);
            break;
            default:
            return '';
        }
    }

    public function store(AnalysisRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                // case 'service':
                //     return $this->save->service($request);
                // break;
                case 'fee':
                    return $this->save->fee($request);
                break;
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
}
