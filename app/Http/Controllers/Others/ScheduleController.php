<?php

namespace App\Http\Controllers\Others;

use App\Traits\HandlesTransaction;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Services\Others\Schedules\SaveClass;
use App\Services\Others\Schedules\ViewClass;

class ScheduleController extends Controller
{
    use HandlesTransaction;

    protected $dropdown;
    protected $agency;
    protected $view;
    protected $save;

    public function __construct(DropdownClass $dropdown, AgencyClass $agency, SaveClass $save, ViewClass $view){
        $this->dropdown = $dropdown;
        $this->agency = $agency;
        $this->view = $view;
        $this->save = $save;
    }

    public function index(Request $request){
        switch($request->option){
            case 'events':
                return $this->view->events($request);
            break;
            case 'dues':
                return $this->view->dues($request);
            break;
            case 'duedate':
                return $this->view->duedate($request);
            break;
            default :
            return inertia('Others/Schedules/Index',[
                'dropdowns' => [
                    'events' => $this->dropdown->events(),
                    'laboratories' => $this->agency->laboratories()
                ]
            ]);
        }
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->save($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(Request $request, $id){
        $schedule = Schedule::findOrFail($id);

        if ($schedule->user_id !== Auth::id()) {
            abort(403, 'You are not allowed to edit this schedule.');
        }

        $result = $this->handleTransaction(function () use ($request, $schedule) {
            return $this->save->update($schedule, $request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function destroy($id)
    {
        $result = $this->handleTransaction(function () use ($id) {
            return $this->save->delete($id);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

}
