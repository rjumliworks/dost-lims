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
                case 'service':
                    return $this->save->service($request);
                break;
                case 'removefee':
                    return $this->save->removefee($request);
                break;
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

    public function update(Request $request){
        $request->validate([
            'start_at' => ['required_if:option,start'],
            'end_at' => ['required_if:option,end'],
            'date' => ['required_if:option,group'],
            'reason' => ['required_if:option,cancel']
        ]);
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'start':
                    return $this->update->start($request);
                break;
                case 'end':
                    return $this->update->end($request);
                break;
                case 'tagging':
                    return $this->update->tagging($request);
                break;
                // case 'group':
                //     return $this->update->group($request);
                // break;
                // case 'cancel':
                //     return $this->update->cancel($request);
                // break;
                // case 'delete':
                //     return $this->save->removeService($request);
                // break;
                case 'removeservice':
                    return $this->save->removeService($request);
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
