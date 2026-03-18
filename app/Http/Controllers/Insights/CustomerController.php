<?php

namespace App\Http\Controllers\Insights;

use App\Models\Target;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Insights\Customer\BarClass;
use App\Services\Insights\Customer\DataClass;
use App\Services\Insights\Customer\LocationClass;
use App\Services\Insights\Customer\DiscountClass;

class CustomerController extends Controller
{
    public function __construct(BarClass $bar, DataClass $data, LocationClass $location, DiscountClass $discount){
        $this->bar = $bar;
        $this->data = $data;
        $this->location = $location;
        $this->discount = $discount;

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
            case 'location':
                return $this->location->data($request);
            break;
            case 'discount':
                return $this->discount->data($request);
            break;
            default: 
                return inertia('Modules/Insights/Customer/Index',[
                    'year' => date('Y'),
                    'years' => Target::distinct()->pluck('year')
                ]);
        }
    }

    public function location(Request $request){
        return inertia('Modules/Insights/Customer/Location',[
            'year' => date('Y'),
            'years' => Target::distinct()->pluck('year')
        ]);
    }

    public function discount(Request $request){
        return inertia('Modules/Insights/Customer/Discount',[
            'year' => date('Y'),
            'years' => Target::distinct()->pluck('year')
        ]);
    }
}
