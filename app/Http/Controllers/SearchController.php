<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownClass;

class SearchController extends Controller
{
    protected $dropdown;

    public function __construct(
            DropdownClass $dropdown
        ){
        $this->dropdown = $dropdown;
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
                return $this->dropdown->users($request->keyword,$request->agency);
            break;
            case 'payors':
                return $this->dropdown->payors($request);
            break;
        }
    }
}
