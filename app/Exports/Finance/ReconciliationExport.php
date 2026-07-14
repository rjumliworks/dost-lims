<?php

namespace App\Exports\Finance;

use App\Models\FinanceOp;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReconciliationExport implements FromView
{
    protected $month,$year,$laboratory;

    function __construct($month,$year,$laboratory) {
        $this->month = $month;
        $this->year = $year;
        $this->laboratory = $laboratory;
    }

    public function view(): View {
        $lists = FinanceOp::select('id','total','code','payment_id','payorable_id','payorable_type','created_at','created_by')
        ->with('createdby:id','createdby.profile:user_id,firstname,lastname,middlename')
        ->with('payorable:id,name,name_id','payorable.customer_name:id,name')
        ->with('payment')
        ->with(['items' => function ($query) {
            $query->with('itemable:id,code','itemable.payment')->where('itemable_type', 'App\Models\Tsr');
        }, 'activeReceipt:id,op_id,number','activeReceipt.detail','activeReceipt.wallet'])
        ->where('payorable_type', 'App\Models\Customer')
        ->where('status_id',7)
        ->whereMonth('created_at',$this->month)
        ->whereYear('created_at',$this->year)
        ->get();



        $ops = [];

        foreach ($lists as $row) {
            $name = ($row['payorable']['name'] == 'Main') ? '' : ' - '.$row['payorable']['name'];
            $customer = $row['payorable']['customer_name']['name'].$name;
            $created = $row['createdby']['profile']['firstname'].' '.$row['createdby']['profile']['middlename'][0].'. '.$row['createdby']['profile']['lastname'];
            if($row['payment']['name'] == 'Cash' || $row['payment']['name'] == 'Wallet'){
                $amount = $row['total'];
                $excess = '-';
            }else{
                $amount = $row['activeReceipt']['detail']['amount'];
                if($row['activeReceipt']['wallet']){
                    $excess = $row['activeReceipt']['wallet']['amount'];
                }else{
                    $excess = '-';
                }
            }
            $total = 0;
            foreach($row['items'] as $index=>$a){
                $wew= trim(str_replace(',','',$a['itemable']['payment']['total']),'₱ ');
                $total = $total + $wew;
            }

            $ops[] = [
                "date" => $row['created_at'],
                "opnumber" => $row['code'],
                "customer" => $customer,
                "references" => $row['items'],
                "ornumber" => $row['activeReceipt']['number'],
                "rstlamount" => $total,
                "opamount" => $row['total'],
                "oramount" => $amount,
                "excess" => $excess,
                "created" => $created
            ];

            $totalOrAmount = collect($ops)->sum(function($item) {
                return floatval(
                    str_replace(['₱', ','], '', $item['oramount'])
                );
            });
        }

        return view('exports.reconciliation', [
            'lists' => $ops,
            'total_or' => $totalOrAmount
        ]);
    }
}
