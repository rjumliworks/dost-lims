<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;

class PackageController extends Controller
{
    use HandlesTransaction;

    protected DropdownClass $dropdown;

    public function __construct(DropdownClass $dropdown){
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            default:
            return inertia('Modules/Packages/Index',[
                'dropdowns' => [
                    'laboratories' => $this->dropdown->laboratories(),
                    'statuses' => $this->dropdown->statuses('Testservice')
                ],
            ]);
        }
    }
}
