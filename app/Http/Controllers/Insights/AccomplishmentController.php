<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Insights\AccomplishmentClass;


class AccomplishmentController extends Controller
{
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
}
