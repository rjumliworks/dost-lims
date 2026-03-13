<?php

namespace App\Http\Controllers\Insights;

use App\Models\Target;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Insights\Customer\BarClass;
use App\Services\Insights\Customer\DataClass;

class CustomerController extends Controller
{
    public function __construct(BarClass $bar, DataClass $data){
        $this->bar = $bar;
        $this->data = $data;
    }

    public function index(Request $request){
        switch($request->option){
            case 'bar':
                return $this->bar->data($request);
            break;
            case 'data':
                return [
                    'summary_count' => $this->data->summary_count($request),
                    'summary_type' => $this->data->summary_type($request),
                ];
            break;
            default: 
                return inertia('Modules/Insights/Customer/Index',[
                    'year' => date('Y'),
                    'years' => Target::distinct()->pluck('year')
                ]);
        }
    }
}
