<?php

namespace App\Http\Controllers\Finance;

use App\Models\FinanceOp;
use App\Models\FinanceItem;
use App\Models\FinanceOpItem;
use App\Models\FinanceReceipt;
use App\Models\FinanceReceiptDetail;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Http\Resources\Finance\NonlabResource;

class NonlabController extends Controller
{
    use HandlesTransaction;

    public function __construct(DropdownClass $dropdown){
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default :
            return inertia('Finance/Cashiering/Nonlab/Index',[
                'dropdowns' => [
                    'payments' => $this->dropdown->dropdowns('Payment Mode','n/a'),
                    'statuses' => $this->dropdown->statuses('Payment'),
                ]
            ]);
        }
    }

    public function lists($request){
        $data = NonlabResource::collection(
            FinanceOp::query()
            ->select('id','total','code','payment_id','status_id','collection_id','payorable_id','payorable_type','created_at','created_by')
            ->with('createdby:id','createdby.profile:user_id,firstname,lastname,middlename')
            ->with('payorable:id,name')
            ->with('payment','collection','status')
            ->with(['items' => function ($query) {
                $query->with('itemable:id,name')->where('itemable_type', 'App\Models\FinanceItem');
            }, 'activeReceipt:id,op_id,number',
                'activeReceipt.detail',
                'activeReceipt.wallet'])
            ->when($request->status, function ($query, $status) {
                $query->where('status_id',$status);
            })
            ->when($request->mode, function ($query, $mode) {
                $query->where('payment_id',$mode);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('payorable_type', 'App\Models\FinanceName') // Only for 'Customer' types
                ->whereHas('payorable', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orWhere('code', 'like', '%' . $keyword . '%')
                ->orWhereHas('or', function ($query) use ($keyword) {
                    $query->where('number', 'like', '%' . $keyword . '%');
                });
            })
            ->where('payorable_type', 'App\Models\FinanceName')
            ->where('status_id',7)
            ->orderBy('updated_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'remove':
                    return $this->remove($request);
                break;
                case 'edit':
                    return $this->edit($request);
                break;
                case 'add':
                    return $this->add($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    private function add($request){
        $item = new FinanceItem;
        $item->name = $request->name;
        $item->amount = $request->amount;
        if($item->save()){
            $d = $item->itemable()->create([
                'amount' => $request->amount,
                'op_id' => $request->id
            ]);

            if($d){
                $op = FinanceOp::find($request->id);
                $op->total = (float) str_replace(',', '', trim($op->total, '₱ ')) + (float) str_replace(',', '', trim($request->amount, '₱ '));
                $op->save();
            }
        }

        return [
            'data' => $this->getData($request->id),
            'message' => 'Item details added successfully!',
            'info' => 'Added new item in the Order of Payment.'
        ];
    }

    private function edit($request){
        $data = FinanceItem::find($request->id);
        $old_amount = $data->amount;
        $data->name = $request->name;
        $data->amount = $request->amount;
        if($data->save()){
            $item = FinanceOpItem::find($request->item_id);
            $item->amount = $request->amount;
            if($item->save()){
                $op_id = $item->op_id;
                $op = FinanceOp::find($op_id);
                $op->total = (float) str_replace(',', '', trim($op->total, '₱ ')) - (float) str_replace(',', '', trim($old_amount, '₱ '));
                if($op->save()){
                    $op->total = (float) str_replace(',', '', trim($op->total, '₱ ')) + (float) str_replace(',', '', trim($request->amount, '₱ '));
                    $op->save();

                    if($op->payment_id == 18){
                        $or_id = FinanceReceipt::where('op_id',$op_id)->value('id');
                        $detail = FinanceReceiptDetail::where('receipt_id',$or_id)->first();
                        $detail->amount = (float) str_replace(',', '', trim($detail->amount, '₱ ')) - (float) str_replace(',', '', trim($old_amount, '₱ '));
                        if($detail->save()){
                            $detail->amount = (float) str_replace(',', '', trim($detail->amount, '₱ ')) + (float) str_replace(',', '', trim($request->amount, '₱ ')); 
                            $detail->save();
                        }
                    }
                }
            }
        }

        return [
            'data' => $this->getData($op_id),
            'message' => 'Item details updated successfully!',
            'info' => 'The selected item in the Order of Payment has been updated with the new details.'
        ];
    }

    private function remove($request){
        $data = FinanceItem::find($request->id);
        $old_amount = $data->amount;
        if($data->delete()){
            $item = FinanceOpItem::find($request->item_id);
            $op_id = $item->op_id;
            if($item->delete()){
                $op = FinanceOp::find($op_id);
                $op->total = (float) str_replace(',', '', trim($op->total, '₱ ')) - (float) str_replace(',', '', trim($old_amount, '₱ '));
                $op->save();
            }
        }

        return [
            'data' => $this->getData($op_id),
            'message' => 'Item removed from Order of Payment',
            'info' => 'The selected item has been successfully removed from the Order of Payment.'
        ];
    }

    private function getData($op_id){
        return new NonlabResource(
            FinanceOp::query()
            ->select('id','total','code','payment_id','status_id','collection_id','payorable_id','payorable_type','created_at','created_by')
            ->with('createdby:id','createdby.profile:user_id,firstname,lastname,middlename')
            ->with('payorable:id,name')
            ->with('payment','collection','status')
            ->with(['items' => function ($query) {
                $query->with('itemable:id,name')->where('itemable_type', 'App\Models\FinanceItem');
            }, 'or:id,op_id,number','or.detail','or.wallet'])
            ->where('id',$op_id)
            ->first()
        );
    }
}
