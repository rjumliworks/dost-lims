<?php

namespace App\Http\Controllers\Insights;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Insights\ExcelClass;
use App\Services\Insights\AccomplishmentClass;


class AccomplishmentController extends Controller
{
    use HandlesTransaction;

    protected ExcelClass $excel;
    protected AccomplishmentClass $accomplishment;

    public function __construct(AccomplishmentClass $accomplishment, ExcelClass $excel){
        $this->accomplishment = $accomplishment;
        $this->excel = $excel;
    }

    public function index(Request $request){
        switch($request->option){
            case 'accomplishment':
                return $this->accomplishment->accomplish($request);
            break;
            case 'targets':
                return $this->accomplishment->targets($request);
            break;
            case 'assistance-breakdown':
                return $this->accomplishment->assistanceBreakdown($request);
            break;
            case 'location':
                return $this->excel->location($request);
            break;
            case 'discount':
                return $this->excel->discount($request);
            break;
            case 'perdiscount':
                return $this->excel->perdiscount($request);
            break;
            case 'request':
                return $this->excel->requesting($request);
            break;
             case 'peza':
                return $this->accomplishment->peza($request);
            break;
            default: 
                return inertia('Modules/Insights/Accomplishment/Index');
        }
    }

    public function figures(){
        return inertia('Modules/Insights/Accomplishment/Figures');
    }

     public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {     
            switch($request->option){
                case 'target':
                    return $this->accomplishment->target($request);
                break; 
                case 'overall':
                    return $this->accomplishment->overall($request);
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
