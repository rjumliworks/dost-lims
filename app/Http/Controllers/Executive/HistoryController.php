<?php

namespace App\Http\Controllers\Executive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Executive\History\ViewClass;

class HistoryController extends Controller
{
    protected ViewClass $view;

    public function __construct(ViewClass $view)
    {
        $this->view = $view;
    }

    public function index(Request $request)
    {
        switch ($request->option) {
            case 'list':
                return $this->view->list($request);
            case 'tsr':
                return $this->view->tsr($request);
            default:
                return inertia('Executive/History/Index');
        }
    }
}
