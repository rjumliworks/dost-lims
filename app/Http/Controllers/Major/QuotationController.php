<?php

namespace App\Http\Controllers\Major;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Services\Major\Quotation\SaveClass;
use App\Services\Major\Quotation\ViewClass;
use App\Services\Major\Quotation\UpdateClass;
use App\Http\Requests\Major\Quotation\CreateRequest;
use App\Http\Requests\Major\Quotation\UpdateRequest;

class QuotationController extends Controller
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
                return $this->view->lists($request);
            break;
            case 'print':
                return $this->view->print($request);
            break;
            default :
            return inertia('Modules/Major/Quotations/Index',[
                'dropdowns' => [
                    'laboratories' => $this->agency->laboratories(),
                    'services' => $this->agency->services(),
                    'discounts' => $this->agency->discounts(),
                    'agencies' => $this->agency->all(),
                    'statuses' => $this->dropdown->statuses('Quotation'),
                    'purposes' => $this->dropdown->dropdowns('Purpose','n/a'),
                    'releases' => $this->dropdown->datas('Release'),
                    'regions' => $this->dropdown->regions(),
                ],
                // 'facility' => \Auth::user()->profile->facility_id,
                'counts' => $this->view->counts($this->dropdown->statuses('Quotation')),
                'region' => $this->view->region()
            ]);
        }
    }

    public function store(CreateRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'validation':
                    return $this->save->validation($request);
                break;
                case 'copy':
                    return $this->save->copy($request);
                break;
                case 'sample':
                    return $this->save->sample($request);
                break;
                case 'analysis':
                    return $this->save->analysis($request);
                break;
                case 'analysisdelete':
                    return $this->save->analysisdelete($request);
                break;
                case 'sampledelete':
                    return $this->save->sampledelete($request);
                break;
                case 'removefee':
                    return $this->save->removefee($request);
                break;
                case 'fee':
                    return $this->save->fee($request);
                break;
                case 'service':
                    return $this->save->service($request);
                break;
                case 'tsr':
                    return $this->save->tsr($request);
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
        $result = $this->handleTransaction(function () use ($request) {     
            switch($request->option){
                case 'removeservice':
                    return $this->save->removeService($request);
                break;  
                case 'cancel':
                    return $this->update->cancel($request);
                break;     
                case 'update':
                    return $this->update->quotation($request);
                break;  
                case 'save': 
                    return $this->update->save($request);
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
        return inertia('Modules/Major/Quotations/Profile/Index',[
            'quotation' => $this->view->view($id),
            'analyses' => $this->view->analyses($id),
            'dropdowns' => [
                'laboratories' => $this->agency->laboratories(),
                'services' => $this->agency->services(),
                'discounts' => $this->agency->discounts(),
                'agencies' => $this->agency->all(),
                'statuses' => $this->dropdown->statuses('Request'),
                'purposes' => $this->dropdown->dropdowns('Purpose','n/a'),
                'releases' => $this->dropdown->datas('Release'),
            ],
        ]);
    }
}
