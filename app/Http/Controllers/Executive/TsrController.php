<?php

namespace App\Http\Controllers\Executive;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Executive\Tsr\ViewClass;
use App\Services\Executive\Tsr\SaveClass;

class TsrController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected DropdownClass $dropdown;

    public function __construct(ViewClass $view, SaveClass $save, DropdownClass $dropdown)
    {
        $this->view = $view;
        $this->save = $save;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request)
    {
        switch ($request->option) {
            case 'list':
                return $this->view->list($request, $this->dropdown->statuses('Request'));
            case 'codes':
                return $this->view->codes($request);
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

    public function sync(Request $request)
    {
        $request->validate([
            'from_id' => ['required', 'integer', 'exists:tsrs,id'],
            'to_id' => ['required', 'integer', 'exists:tsrs,id'],
        ]);

        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->sync($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }
}
