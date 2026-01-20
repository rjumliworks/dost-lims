<?php

namespace App\Http\Controllers\Major;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Services\Major\Tsr\SaveClass;
use App\Services\Major\Tsr\ViewClass;
use App\Services\Major\Tsr\UpdateClass;
use App\Http\Requests\Major\Tsr\CreateRequest;
use App\Http\Requests\Major\Tsr\UpdateRequest;

class TsrController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected UpdateClass $update;
    protected AgencyClass $agency;
    protected DropdownClass $dropdown;

    public function __construct(AgencyClass $agency, DropdownClass $dropdown, SaveClass $save, ViewClass $view, UpdateClass $update){
        $this->dropdown = $dropdown;
        $this->agency = $agency;
        $this->view = $view;
        $this->save = $save;
        $this->update = $update;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                
            break;
            case 'print':
                return $this->view->print($request);
            break;
            default :
            return inertia('Modules/Major/Tsrs/Index',[
                'dropdowns' => [
                    'laboratories' => $this->agency->laboratories(),
                    'services' => $this->agency->services(),
                    'discounts' => $this->agency->discounts(),
                    'agencies' => $this->agency->all(),
                    'statuses' => $this->dropdown->statuses('Request'),
                    'purposes' => $this->dropdown->dropdowns('Purpose','n/a'),
                    'regions' => $this->dropdown->regions(),
                ],
                // 'facility' => \Auth::user()->profile->facility_id,
                'counts' => $this->view->counts($this->dropdown->statuses('Request')),
                'region' => $this->view->region()
            ]);
        }
    }

    public function store(CreateRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'copy':
                    return $this->save->copy($request);
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

    public function update(UpdateRequest $request){

    }

    public function show($id){

    }
}
