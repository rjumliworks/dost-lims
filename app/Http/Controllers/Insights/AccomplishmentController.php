<?php

namespace App\Http\Controllers\Insights;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Insights\AccomplishmentClass;


class AccomplishmentController extends Controller
{
    use HandlesTransaction;

    public function __construct(AccomplishmentClass $accomplishment){
        $this->accomplishment = $accomplishment;
    }

    public function index(Request $request){
        switch($request->option){
            case 'accomplishment':
                return $this->accomplishment->accomplish($request);
            break;
            case 'targets':
                return $this->accomplishment->targets($request);
            break;
            default: 
                return inertia('Modules/Insights/Accomplishment/Index');
        }
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
