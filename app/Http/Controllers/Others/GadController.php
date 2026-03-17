<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GadController extends Controller
{
    public function index(Request $request){
        return inertia('Others/Gad/Index');
    }

    public function workforce(Request $request){
        return inertia('Others/Gad/Workforce');
    }

    public function customers(Request $request){
        return inertia('Others/Gad/Customer');
    }

    public function organizationalChart(Request $request){
        return inertia('Others/Gad/OrganizationalChart');
    }

    public function knowledgeIec(Request $request){
        return inertia('Others/Gad/KnowledgeIec');
    }
}
