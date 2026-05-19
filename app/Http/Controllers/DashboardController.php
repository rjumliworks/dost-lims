<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Dashboard\CroClass;
use App\Services\Dashboard\AnalystClass;
use App\Services\Dashboard\CashierClass;
use App\Services\Dashboard\AccountantClass;
use App\Services\Dashboard\CommonClass;
use App\Services\Dashboard\LabHeadClass;
use App\Services\Dashboard\ReleasingClass;
use App\Services\AgencyClass;

class DashboardController extends Controller
{   
    protected CommonClass $common;
    protected CroClass $cro;
    protected LabHeadClass $labhead;
    protected AnalystClass $analyst;
    protected CashierClass $cashier;
    protected DropdownClass $dropdown;
    protected AccountantClass $accountant;
    protected AgencyClass $agency;
    protected ReleasingClass $releasing;
    
    public function __construct(
        CommonClass $common,
        LabHeadClass $labhead,
        CroClass $cro,
        AnalystClass $analyst,
        CashierClass $cashier,
        DropdownClass $dropdown,
        AccountantClass $accountant,
        AgencyClass $agency,
        ReleasingClass $releasing
    ){
        $this->common = $common;
        $this->labhead = $labhead;
        $this->cro = $cro;
        $this->analyst = $analyst;
        $this->cashier = $cashier;
        $this->dropdown = $dropdown;
        $this->accountant = $accountant;
        $this->agency = $agency;
        $this->releasing = $releasing;
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
                            'counts' => $this->accountant->counts($this->dropdown->dropdowns('Payment Mode','n/a')),
                            'dropdowns' => [
                                'reminders' => $this->accountant->reminders($request),
                                'collection' => $this->accountant->collection($request),
                                'collection_summary' => $this->accountant->collection_summary($request),
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
                    case 'Customer Relation Officer':
                        return inertia('Modules/Dashboard/Cro/Index',[
                            'dropdowns' => [
                                'laboratories' => $this->agency->laboratories(),
                            ]
                        ]);
                    break;
                    case 'Laboratory Head':
                        return inertia('Modules/Dashboard/LabHead/Index',[
                            'dropdowns' => [
                                'laboratories' => $this->agency->laboratories(),
                            ]
                        ]);
                    break;
                     case 'Releasing Officer':
                        return inertia('Modules/Dashboard/Releasing/Index',[
                            'dropdowns' => [
                                'laboratories' => $this->agency->laboratories(),
                                'modes' => $this->dropdown->datas('Release')
                            ]
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

    public function fetch(Request $request){
        $option = $request->option;
        switch($option){
            case 'cro':
                return array_merge(
                    $this->cro->dashboard($request),
                    $this->common->calendar($request)
                );
            break;
            case 'labhead':
                return array_merge(
                    $this->labhead->dashboard($request),
                    $this->common->calendar($request)
                );
            break;
            case 'performance':
                return $this->analyst->performance($request);
            break;
            case 'tsr':
                
            break;
            case 'releasing':
                return $this->releasing->dashboard($request,$this->dropdown->datas('Release'));
            break;
        }
    }
}
