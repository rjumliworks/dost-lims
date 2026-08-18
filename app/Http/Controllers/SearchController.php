<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\AgencyClass;

class SearchController extends Controller
{
    protected $dropdown;
    protected $agency;

    public function __construct(
            DropdownClass $dropdown,
            AgencyClass $agency
        ){
        $this->dropdown = $dropdown;
        $this->agency = $agency;
    }

    public function search(Request $request){
        $option = $request->option;
        switch($option){
            case 'provinces':
                return $this->dropdown->provinces($request->code);
            break;
            case 'municipalities':
                return $this->dropdown->municipalities($request->code);
            break;
            case 'barangays':
                return $this->dropdown->barangays($request->code);
            break;
            case 'tsrsamples':
                return $this->dropdown->tsrsamples($request->keyword);
            break;
            case 'users':
                return $this->dropdown->users($request->keyword);
            break;
            case 'payors':
                return $this->dropdown->payors($request);
            break;
            case 'tsrs':
                return $this->dropdown->tsrs($request);
            break;
            case 'laboratories':
                return $this->agency->laboratories($request->facility);
            break;
        }
    }
}
