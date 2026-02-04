<?php

namespace App\Http\Controllers\Major;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Major\Analysis\ViewClass;
use App\Services\Major\Analysis\SaveClass;
use App\Services\Major\Analysis\UpdateClass;

class AnalysisController extends Controller
{
    use HandlesTransaction;

    public function __construct(ViewClass $view, SaveClass $save, UpdateClass $update){
        $this->view = $view;
        $this->save = $save;
        $this->update = $update;
    }

    public function index(Request $request){
        switch($request->option){
            case 'testservices':
                return $this->view->list($request);
            break;
            default:
            return '';
        }
    }
}
