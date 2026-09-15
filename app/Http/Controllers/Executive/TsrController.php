<?php

namespace App\Http\Controllers\Executive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Executive\Tsr\ViewClass;

class TsrController extends Controller
{
    protected ViewClass $view;
    protected DropdownClass $dropdown;

    public function __construct(ViewClass $view, DropdownClass $dropdown)
    {
        $this->view = $view;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request)
    {
        switch ($request->option) {
            case 'list':
                return $this->view->list($request, $this->dropdown->statuses('Request'));
            default:
                return inertia('Executive/Tsrs/Index', [
                    'dropdowns' => [
                        'agencies' => $this->dropdown->agencies(),
                        'laboratories' => $this->dropdown->laboratories(),
                        'statuses' => $this->dropdown->statuses('Request'),
                        'years' => $this->dropdown->years(),
                    ],
                ]);
        }
    }
}
