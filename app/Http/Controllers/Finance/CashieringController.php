<?php

namespace App\Http\Controllers\Finance;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Finance\OrseriesClass;
use App\Services\Finance\NameClass;
use App\Http\Requests\Finance\CashieringRequest;

class CashieringController extends Controller
{
    use HandlesTransaction;

    public function __construct(OrseriesClass $orseries, NameClass $name, DropdownClass $dropdown){
        $this->orseries = $orseries;
        $this->name = $name;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->name->lists($request);
            break;
            case 'names':
                return $this->name->lists($request);
            break;
            case 'orseries':
                return $this->orseries->lists($request);
            break;
        }   
    }

    public function store(CashieringRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'name':
                    return $this->name->save($request);
                break;
                case 'orseries':
                    return $this->orseries->save($request);
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
                case 'orseries':
                    return $this->orseries->update($request);
                break;
                case 'name':
                    return $this->name->update($request);
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

    public function orseries(){
        return inertia('Finance/Cashiering/Orseries/Index');
    }

    public function names(){
        return inertia('Finance/Cashiering/Names/Index');
    }
}
