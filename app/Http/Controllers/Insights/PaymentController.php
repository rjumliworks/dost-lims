<?php

namespace App\Http\Controllers\Insights;

use App\Models\Target;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Insights\Payment\BarClass;
use App\Services\Insights\Payment\MonitoringClass;
use App\Services\Insights\Payment\BreakdownClass;

class PaymentController extends Controller
{
    protected DropdownClass $dropdown;
    protected BarClass $bar;
    protected MonitoringClass $monitoring;
    protected BreakdownClass $breakdown;

    public function __construct(DropdownClass $dropdown, BarClass $bar, MonitoringClass $monitoring, BreakdownClass $breakdown){
        $this->dropdown = $dropdown;
        $this->bar = $bar;
        $this->monitoring = $monitoring;
        $this->breakdown = $breakdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'bar':
                return $this->bar->data($request);
            break;
            case 'data':
                return [
                    'collection' => $this->monitoring->collection($request),
                    'collection_summary' => $this->monitoring->collection_summary($request),
                    'status' => $this->breakdown->status($request),
                    'type' => $this->breakdown->type($request),
                    'discount_individual' => $this->breakdown->discountIndividual($request),
                    'discount_firms' => $this->breakdown->discountFirms($request),
                    'collection_breakdown' => $this->breakdown->collection($request),
                ];
            break;
            case 'status':
                return $this->breakdown->status($request);
            break;
            case 'type':
                return $this->breakdown->type($request);
            break;
            case 'discount_individual':
                return $this->breakdown->discountIndividual($request);
            break;
            case 'discount_firms':
                return $this->breakdown->discountFirms($request);
            break;
            case 'collection_breakdown':
                return $this->breakdown->collection($request);
            break;
            default:
                return inertia('Modules/Insights/Payment/Index', [
                    'current_year' => date('Y'),
                    'years' => Target::distinct()->pluck('year'),
                    'dropdowns' => [
                        'laboratories' => $this->dropdown->laboratories(),
                    ]
                ]);
        }
    }
}
