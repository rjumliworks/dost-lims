<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Dashboard\AnalystClass;
use App\Services\Dashboard\CashierClass;
use App\Services\Dashboard\AccountantClass;

class DashboardController extends Controller
{   
    protected AnalystClass $analyst;
    protected CashierClass $cashier;
    protected DropdownClass $dropdown;
    protected AccountantClass $accountant;
    
    public function __construct(
        AnalystClass $analyst,
        CashierClass $cashier,
        DropdownClass $dropdown,
        AccountantClass $accountant
    ){
        $this->analyst = $analyst;
        $this->cashier = $cashier;
        $this->dropdown = $dropdown;
        $this->accountant = $accountant;
    }

    public function index(Request $request){
        if(!\Auth::check()){
            return inertia('Auth/Login');
        }else{
            $user = \Auth::user();
            if($user->must_change) {
                return inertia('Auth/Activation');
            }
            if(\Auth::user()->role === 'Administrator'){
                return inertia('Modules/Executive/Dashboard/Index');
            }else{
                $role = \Auth::user()
                ->myroles()
                ->where('is_primary', 1)
                ->with('role')
                ->first()?->role->name;
                switch($role){
                    case 'Accountant':
                        return inertia('Finance/Accounting/Dashboard/Index',[
                            'dropdowns' => [
                                'reminders' => $this->accountant->reminders(),
                                'tsrs' => $this->accountant->forpayment($request),
                                'collections' => $this->dropdown->dropdowns('Collection Type','Laboratory'),
                                'payments' => $this->dropdown->dropdowns('Payment Mode','n/a'),
                            ]
                        ]);
                    break;
                    case 'Cashier':
                        return inertia('Finance/Cashiering/Dashboard/Index',[
                            'dropdowns' => [
                                'reminders' => $this->accountant->reminders(),
                                'orseries' => $this->cashier->orseries(),
                                'receipts' => $this->cashier->receipts(),
                                'deposits' => $this->dropdown->dropdowns('Deposit Type','n/a'),
                                'collections' => $this->dropdown->dropdowns('Collection Type','Non-laboratory'),
                                'payments' => $this->dropdown->dropdowns('Payment Mode','n/a'),
                            ]
                        ]);
                    break;
                    case 'Laboratory Analyst':
                        return inertia('Modules/Dashboard/Analyst/Index',[
                            'reminders' => $this->analyst->reminders($request),
                            'tasks' => $this->analyst->tasks($request),
                            'laboratories' => $this->analyst->laboratories($request)
                        ]);
                    break;
                    case 'Calibration Officer':
                        return inertia('Modules/Dashboard/Analyst/Index',[
                            'reminders' => $this->analyst->reminders($request),
                            'tasks' => $this->analyst->tasks($request),
                            'laboratories' => $this->analyst->laboratories($request)
                        ]);
                    break;
                    default:
                    return inertia('Modules/Dashboard/Index',[
                        // 'dropdowns' => [
                        //     'info' => $this->cro->info($request),
                        //     'info1' => $this->cro->info1($request),
                        //     'info2' => $this->cro->info2($request),
                        //     'counts' => $this->cro->counts($request),
                        //     'reminders' => $this->cro->reminders($request),
                        //     'notices' => $this->cro->notices($request),
                        //     'statuses' => $this->cro->statuses($request),
                        //     'laboratories' => $this->dropdown->laboratories($request),
                        // ]
                    ]);
                }
            }
        }
    }

    public function search(Request $request){
        $option = $request->option;
        switch($option){
            case 'performance':
                return $this->analyst->performance($request);
            break;
        }
    }
}
