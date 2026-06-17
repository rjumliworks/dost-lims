<?php

namespace App\Http\Controllers\Major;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Http\Requests\Major\ReleaseRequest;
use App\Services\Major\Releasing\SaveClass;
use App\Services\Major\Releasing\ViewClass;

class ReleasingController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected AgencyClass $agency;
    protected DropdownClass $dropdown;

    public function __construct(SaveClass $save, ViewClass $view, AgencyClass $agency,  DropdownClass $dropdown){
        $this->view = $view;
        $this->save = $save;
        $this->dropdown = $dropdown;
        $this->agency = $agency;
        
    }
    
    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->view->list($request);
            break;
            case 'filter':
                
            break;
            case 'search':
                return $this->view->search($request->keyword);
            break;
            default:
                return inertia('Modules/Major/Releasing/Index',[
                    'dropdowns' => [
                        'laboratories' => $this->agency->laboratories(),
                        'releases' => $this->dropdown->datas('Release'),
                        'regions' => $this->dropdown->regions(),
                        'years' => $this->dropdown->years()
                    ],
                ]);
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
