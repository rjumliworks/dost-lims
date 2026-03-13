<?php

namespace App\Http\Controllers\Insights;

use App\Models\Target;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'top':
            break;
            default: 
                return inertia('Modules/Insights/Customer/Index',[
                    'year' => date('Y'),
                    'years' => Target::distinct()->pluck('year')
                ]);
        }
    }
}
