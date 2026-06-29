<?php

namespace App\Http\Controllers\Insights;

use App\Models\Target;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Services\Insights\Customer\TopClass;
use App\Services\Insights\Customer\BarClass;
use App\Services\Insights\Customer\DataClass;
use App\Services\Insights\Customer\LocationClass;
use App\Services\Insights\Customer\DiscountClass;
use App\Services\Insights\Customer\RequestingClass;

class CustomerController extends Controller
{
    public function __construct(AgencyClass $agency, DropdownClass $dropdown, BarClass $bar, DataClass $data, LocationClass $location, DiscountClass $discount, TopClass $top, RequestingClass $requesting){
        $this->bar = $bar;
        $this->top = $top;
        $this->data = $data;
        $this->agency = $agency;
        $this->location = $location;
        $this->discount = $discount;
        $this->dropdown = $dropdown;
        $this->requesting = $requesting;

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
                    'high_request' => $this->data->high_request($request),
                    'high_spend' => $this->data->high_spend($request),
                    'customer_province' => $this->data->customer_province($request),
                    'firms_industry' => $this->data->firms_industry($request),
                    'firms_subindustry' => $this->data->firms_subindustry($request),
                    'firms_purpose' => $this->data->firms_purpose($request)
                ];
            break;
            case 'top':
                return $this->top->fetch($request);
            break;
            case 'location':
                return $this->location->data($request);
            break;
            case 'discounts':
                return $this->discount->data($request);
            break;
            case 'discount':
                return $this->discount->per($request);
            break;
             case 'request':
                return $this->requesting->data($request);
            break;
            default: 
                return inertia('Modules/Insights/Customer/Index',[
                    'current_year' => date('Y'),
                    'years' => Target::distinct()->pluck('year'),
                    'dropdowns' => [
                        'classes' => $this->dropdown->dropdowns('Class','n/a'),
                        'sexs' => $this->dropdown->dropdowns('Sex','n/a'),
                        'individuals' => $this->dropdown->dropdowns('Individual','n/a')
                    ]
                ]);
        }
    }

    public function location(Request $request){
        return inertia('Modules/Insights/Customer/Location',[
            'year' => date('Y'),
            'years' => Target::distinct()->pluck('year')
        ]);
    }

    public function discounts(Request $request){
        return inertia('Modules/Insights/Customer/Discount',[
            'year' => date('Y'),
            'years' => Target::distinct()->pluck('year'),
            'laboratories' => $this->agency->laboratories(),
        ]);
    }

    public function discount(Request $request){
        return inertia('Modules/Insights/Customer/PerDiscount',[
            'year' => date('Y'),
            'years' => Target::distinct()->pluck('year'),
            'laboratories' => $this->agency->laboratories(),
            'discounts' => $this->agency->discounts(),
        ]);
    }

    public function requesting(Request $request){
        return inertia('Modules/Insights/Customer/Request',[
            'year' => date('Y'),
            'years' => Target::distinct()->pluck('year'),
        ]);
    }
}
