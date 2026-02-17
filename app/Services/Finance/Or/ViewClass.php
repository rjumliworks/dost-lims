<?php

namespace App\Services\Finance\Or;
 
use NumberFormatter;
use App\Models\FinanceOp;
use App\Models\FinanceReceipt;
use App\Models\AgencyConfiguration;
use App\Http\Resources\Finance\OrResource;

class ViewClass
{
    public function __construct()
    {
        $this->configuration = AgencyConfiguration::with('agency')->first();
    }

    public function list($request){
        $data = OrResource::collection(
            FinanceOp::query()
            ->select('id','total','code','payment_id','status_id','collection_id','payorable_id','payorable_type','created_at','created_by')
            ->with('createdby:id','createdby.profile:user_id,firstname,lastname,middlename')
            ->with('payorable:id,name,name_id','payorable.customer_name:id,name')
            ->with('payment','collection','status')
            ->with(['items' => function ($query) {
                $query->with('itemable:id,code')->where('itemable_type', 'App\Models\Tsr');
            }, 'or:id,op_id,number','or.detail','or.wallet'])
            ->when($request->status, function ($query, $status) {
                $query->where('status_id',$status);
            })
            ->when($request->mode, function ($query, $mode) {
                $query->where('payment_id',$mode);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('payorable_type', 'App\Models\Customer') // Ensures only 'Customer' types are filtered
                ->whereHasMorph('payorable', ['App\Models\Customer'], function ($query) use ($keyword) {
                    $query->whereHas('customer_name', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                })
                ->orWhere('code', 'like', '%' . $keyword . '%')
                ->orWhereHas('or', function ($query) use ($keyword) {
                    $query->where('number', 'like', '%' . $keyword . '%');
                });
            })
            ->where('payorable_type', 'App\Models\Customer')
            ->where('status_id',7)
            ->orderBy('updated_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function print($request){
        $id = $request->id;
        $items = [];
        $data = FinanceReceipt::with('op.payorable','op.items.itemable','agency','op.collection','op.payment','transaction','detail')->where('id',$id)->first();
        // return Excel::download(new OrExport($id), 'or.xlsx');
        if($data){
            $customer = ($data->op->payorable->customer_name) ? $data->op->payorable->customer_name->name : $data->op->payorable->name; 
            if($data->op->payorable->customer_name){
                $sub = ($data->op->payorable->name == 'Main') ? '' : ' - '.$data->op->payorable->name;
                foreach($data->op->items as $item){
                    $items[] = [
                        'name' => $item->itemable->code,
                        'amount' => $item->itemable->payment->total
                    ];
                }
                if($data->transaction){
                    $items[] = [
                        'name' => 'Credited to Customer Wallet',
                        'amount' => $data->transaction->amount
                    ];
                    $total = (float) str_replace(',', '', trim($data->op->total, '₱ ')) + (float) str_replace(',', '', trim($data->transaction->amount, '₱ ')); 
                    $total = number_format($total,2,'.',',');
                }else{
                    $total = $data->op->total;
                }
                
            }else{
                $sub = '';
                foreach($data->op->items as $item){
                    $items[] = [
                        'name' => $item->itemable->name,
                        'amount' => $item->itemable->amount
                    ];
                }
                $total = $data->op->total;
            }
        }
        $val = trim($data->op->total, '₱ ');
        $val = (float) str_replace(',', '', $val);

        // Split whole number and decimal
        $wholeNumber = floor($val);
        $decimalPart = round(($val - $wholeNumber) * 100); // get 2-digit cents

        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $wholeText = $formatter->format($wholeNumber);

        if ($decimalPart > 0) {
            $numberInWords = ucwords($wholeText) . " and " . sprintf('%02d', $decimalPart) . "/100 Pesos Only";
        } else {
            $numberInWords = ucfirst($wholeText) . " Pesos Only";
        }

        $array = [
            'agency' => $this->configuration->agency->name,
            'customer' => $customer.$sub,
            'word' => $numberInWords,
            'date' => $data->created_at,
            'detail' => ($data->detail) ? $data->detail : null,
            'total' => $data->op->total,
            'items' => $items,
            'payment' => $data->op->payment->name,
        ];
       
        $pdf = \PDF::loadView('finance.receipts.r9',$array)->setPaper([0, 0, 300, 641.68], 'portrait');
        return $pdf->stream($data->number.'.pdf');
    }
}
