<?php

namespace App\Http\Controllers\Executive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Executive\Testservice\ViewClass;

class TestserviceController extends Controller
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
                return $this->view->list($request);
            default:
                return inertia('Executive/Testservices/Index', [
                    'dropdowns' => [
                        'regions' => $this->dropdown->regions(),
                        'statuses' => $this->dropdown->statuses('Testservice'),
                    ],
                ]);
        }
    }
}
