<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Others\GadClass;

class GadController extends Controller
{
    public function __construct(GadClass $gad){
        $this->gad = $gad;
    }

    public function index(Request $request){
        return inertia('Others/Gad/Index');
    }

    public function workforce(Request $request){
        return inertia('Others/Gad/Workforce');
    }

    public function customers(Request $request){
        return inertia('Others/Gad/Customer',[
            'transactions' => $this->gad->transactions(),
            'numbers' => $this->gad->numbers(),
            'list' => $this->gad->chart()
        ]);
    }

    public function organizationalChart(Request $request){
        return inertia('Others/Gad/OrganizationalChart');
    }

    public function knowledgeIec(Request $request){
        return inertia('Others/Gad/KnowledgeIec');
    }
}
