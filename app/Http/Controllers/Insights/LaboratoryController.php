<?php

namespace App\Http\Controllers\Insights;

use App\Models\Target;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AgencyClass;
use App\Services\Insights\Laboratory\BreakdownClass;
use App\Services\Insights\Laboratory\SummaryClass;

class LaboratoryController extends Controller
{
    protected AgencyClass $agency;
    protected BreakdownClass $breakdown;
    protected SummaryClass $summary;

    public function __construct(AgencyClass $agency, BreakdownClass $breakdown, SummaryClass $summary){
        $this->agency = $agency;
        $this->breakdown = $breakdown;
        $this->summary = $summary;
    }

    public function index(Request $request){
        switch($request->option){
            case 'breakdown':
                return $this->breakdown->data($request);
            break;
            case 'data':
                return [
                    'summary' => $this->summary->data($request),
                ];
            break;
            default:
                return inertia('Modules/Insights/Laboratory/Index', [
                    'current_year' => date('Y'),
                    'years' => Target::distinct()->pluck('year'),
                    'dropdowns' => [
                        'laboratories' => $this->agency->laboratories(),
                    ]
                ]);
        }
    }
}
