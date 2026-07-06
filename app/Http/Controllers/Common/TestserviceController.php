<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Http\Requests\Common\NameRequest;
use App\Services\Common\Testservice\ViewClass;
use App\Services\Common\Testservice\SaveClass;
use App\Services\Common\Testservice\UploadClass;
use App\Services\Common\Testservice\UpdateClass;

class TestserviceController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected UpdateClass $update;
    protected UploadClass $upload;
    protected DropdownClass $dropdown;
    protected AgencyClass $agency;

    public function __construct(DropdownClass $dropdown, SaveClass $save, ViewClass $view, UpdateClass $update, UploadClass $upload, AgencyClass $agency){
        $this->dropdown = $dropdown;
        $this->view = $view;
        $this->save = $save;
        $this->update = $update;
        $this->upload = $upload;
        $this->agency = $agency;
    }

    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->view->list($request);
            break;
            case 'sample':
                return $this->view->sample($request);
            break;
            case 'search':
                return $this->view->search($request);
            break;
            case 'methods':
                return $this->view->methods($request);
            break;
            case 'testservices':
                return $this->view->testservices($request);
            break;
            case 'activity-logs':
                return $this->view->activitylogs($request);
            break;
            case 'download':
                return $this->view->download($request);
            break;
            case 'print':
                return $this->view->print($request);
            break;
            default:
            return inertia('Modules/Testservices/Index',[
                'dropdowns' => [
                    'laboratories' => $this->agency->laboratories(),
                    'statuses' => $this->dropdown->statuses('Testservice')
                ],
                'counts' => $this->view->counts($this->dropdown->statuses('Testservice'))
            ]);
        }
    }

    public function store(NameRequest $request){
        $option = $request->option;
        switch($option){
            case 'add':
                return $this->save->name($request);
            break;
            case 'status':
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->save->status($request);
                });
                return back()->with([
                    'data' => $result['data'],
                    'message' => $result['message'],
                    'info' => $result['info'],
                    'status' => $result['status'],
                ]);
            break;
            case 'create':
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->save->create($request);
                });
                return back()->with([
                    'data' => $result['data'],
                    'message' => $result['message'],
                    'info' => $result['info'],
                    'status' => $result['status'],
                ]);
            break;
            case 'fee':
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->save->fee($request);
                });
                return back()->with([
                    'data' => $result['data'],
                    'message' => $result['message'],
                    'info' => $result['info'],
                    'status' => $result['status'],
                ]);
            break;
            case 'method':
                return $this->save->method($request);
            break;
            case 'sampletype':
                 $result = $this->handleTransaction(function () use ($request) {
                    return $this->save->sampletype($request);
                });
                return back()->with([
                    'data' => $result['data'],
                    'message' => $result['message'],
                    'info' => $result['info'],
                    'status' => $result['status'],
                ]);
            break;
            case 'preview':
                return $this->upload->preview($request);
            break;
            case 'upload':
                return $this->upload->save($request);
            break;
        }
    }

     public function update(NameRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'fee':
                    return $this->update->fee($request);
                break;
                case 'status':
                    return $this->update->status($request);
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
        $service = $this->view->view($id);
        return inertia('Modules/Testservices/Profile/Index',[
            'service' => $service
        ]);
    }

    public function reports(){
        return inertia('Modules/Testservices/Report',[
            'dropdowns' => [
                'laboratories' => $this->dropdown->laboratories(),
                'statuses' => $this->dropdown->statuses('Testservice'),
                'regions' => $this->dropdown->regions(),
            ],
            'region' => $this->view->region()
        ]);
    }
}
