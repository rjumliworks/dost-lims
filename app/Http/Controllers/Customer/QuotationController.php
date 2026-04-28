<?php

namespace App\Http\Controllers\Customer;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use App\Services\AgencyClass;
use App\Services\Customer\Quotation\SaveClass;
use App\Services\Customer\Quotation\ViewClass;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected AgencyClass $agency;

    public function __construct(AgencyClass $agency, SaveClass $save, ViewClass $view){
        $this->save = $save;
        $this->view = $view;
        $this->agency = $agency;
    }

    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->list($request);
            break;
            default:
                return inertia('Customer/Quotation/Index',[
                    'selected' => $this->view->view(1),
                    // 'analyses' => $this->view->analyses($id),
                    'dropdowns' => [
                        'laboratories' => $this->agency->laboratories(),
                        'discounts' => $this->agency->discounts()
                    ],
                ]);
        }
    }

     public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'sample':
                    return $this->save->sample($request);
                break;
                case 'analysis':
                    return $this->save->analysis($request);
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
