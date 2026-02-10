<?php

namespace App\Http\Controllers\Executive;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Executive\Agency\SaveClass;
use App\Services\Executive\Agency\ViewClass;

class AgencyController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected DropdownClass $dropdown;

    public function __construct(SaveClass $save, ViewClass $view, DropdownClass $dropdown){
        $this->view = $view;
        $this->save = $save;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->view->lists($request);
            break;
            default:
                return inertia('Executive/Agencies/Index',[
                    'members' => $this->view->members()
                ]); 
        }   
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {

            switch($request->option){
                case 'laboratories':
                    return $this->save->laboratories($request);
                break;
                case 'settings':
                    return $this->save->settings($request);
                break;
                case 'activate':
                    return $this->save->activate($request);
                break;
                case 'fee':
                    return $this->save->fee($request);
                break;
                case 'discount':
                    return $this->save->discount($request);
                break;
                case 'facility':
                    return $this->save->facility($request);
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
        $data = $this->view->view($id);
        return inertia('Executive/Agencies/Profile/Index',[
            'selected' => $data,
            'laboratories' => $this->dropdown->laboratories(),
            'discounts' =>  $this->dropdown->discounts(),
            'regions' => $this->dropdown->regions(),
        ]);
    }
}
