<?php

namespace App\Http\Controllers\Finance;

use App\Services\DropdownClass;
use App\Services\Finance\Op\ViewClass;
use App\Services\Finance\Op\SaveClass;
use App\Services\Finance\Op\UpdateClass;
use App\Services\Finance\Op\PrintClass;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Finance\OpRequest;

class OpController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected PrintClass $print;
    protected UpdateClass $update;
    protected DropdownClass $dropdown;

    public function __construct(
        DropdownClass $dropdown,
        SaveClass $save,
        ViewClass $view,
        UpdateClass $update,
        PrintClass $print
    ){
        $this->dropdown = $dropdown;
        $this->save = $save;
        $this->view = $view;
        $this->update = $update;
        $this->print = $print;
    }

    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->view->list($request);
            break;
            case 'customers':
                return $this->view->search($request);
            break;
            case 'tsrs':
                return $this->view->tsrs($request);
            break;
            case 'print':
                return $this->print->op($request);
            break;
            default :
            return inertia('Finance/Accounting/OrderPayments/Index',[
                'dropdowns' => [
                    'payments' => $this->dropdown->dropdowns('Payment Mode','n/a'),
                    'statuses' => $this->dropdown->statuses('Payment'),
                ]
            ]);
        }
    }

    public function store(OpRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'op':
                    return $this->save->op($request);
                break;
                case 'delete':
                    // return $this->op->delete($request);
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

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'op':
                    // return $this->op->update($request);
                break;
                case 'remove':
                    return $this->update->remove($request);
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
