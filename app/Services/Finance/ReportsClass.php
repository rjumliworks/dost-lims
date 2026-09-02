<?php

namespace App\Services\Finance;

use App\Models\Customer;
use App\Models\FinanceReceipt;
use App\Models\FinanceDeposit;
use App\Models\FinanceDepositList;
use App\Models\AgencyFund;
use App\Models\ListAccount;
use App\Exports\Finance\CashReceiptsExport;
use App\Http\Resources\DefaultResource;
use Maatwebsite\Excel\Facades\Excel;

class ReportsClass
{
    public function accounts()
    {
        $user = \Auth::user();

        return ListAccount::where('agency_id', $user->profile->agency_id)
            ->where('is_active', 1)
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code,
                    'account' => $item->account,
                ];
            });
    }

    public function funds()
    {
        $user = \Auth::user();

        return AgencyFund::with('agency:id,name,code')
            ->where('agency_id', $user->profile->agency_id)
            ->where('is_active', 1)
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->id,
                    'name' => $item->source,
                    'source' => $item->source,
                    'code' => $item->code,
                    'agency_name' => $item->agency->name ?? '',
                    'agency_code' => $item->agency->code ?? '',
                ];
            });
    }

    public function cashReceipts($request)
    {
        $month_name = $request->month ?: date('F');
        $month = \DateTime::createFromFormat('F', ucfirst(strtolower($month_name)))->format('m');
        $year = $request->year ?: date('Y');
        $user = \Auth::user();

        $receipts = FinanceReceipt::select('id','number','op_id','orseries_id','deposit_id','is_deposit','is_cancelled','created_by','created_at')
            ->with([
                'op' => function ($query) {
                    $query->select('id','total','payment_id','collection_id','payorable_id','payorable_type','status_id')
                        ->with('payment:id,name', 'collection:id,name')
                        ->with(['payorable' => function ($morphTo) {
                            $morphTo->morphWith([
                                Customer::class => ['customer_name:id,name'],
                            ]);
                        }]);
                },
                'detail:id,receipt_id,amount',
                'depositList.deposit:id,date',
            ])
            ->where('is_cancelled', 0)
            ->whereHas('op', function ($q) use ($request) {
                $q->where('status_id', 7)
                    ->when($request->nature, function ($q2, $nature) {
                        $q2->whereHas('collection', function ($q3) use ($nature) {
                            $q3->where('name', $nature);
                        });
                    })
                    ->when($request->payment, function ($q2, $payment) {
                        $q2->whereHas('payment', function ($q3) use ($payment) {
                            $q3->where('name', $payment);
                        });
                    });
            })
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        $rows = [];
        $totals = ['collection' => 0, 'btr' => 0, 'trust' => 0, 'undeposited' => 0];

        foreach ($receipts as $receipt) {
            $op = $receipt->op;
            if (! $op) {
                continue;
            }

            $payor = $this->payorName($op);
            $amount = $this->receiptAmount($op, $receipt);

            $isTrust = $op->payment && in_array($op->payment->name, ['Online Transfer', 'Bank Deposit']);
            $isBtr = $op->payment && in_array($op->payment->name, ['Cash', 'Cheque']);
            $isDeposited = (bool) $receipt->depositList;

            $btr = null;
            $trust = null;
            $undeposited = null;

            if ($isTrust) {
                $trust = $amount;
                $totals['trust'] += $amount;
            } elseif ($isBtr) {
                $btr = $amount;
                $totals['btr'] += $amount;
            } else {
                $undeposited = $amount;
                $totals['undeposited'] += $amount;
            }

            $totals['collection'] += $amount;

            $rows[] = [
                'id' => $receipt->id,
                'date' => $receipt->created_at,
                'reference' => $receipt->number,
                'payor' => $payor,
                'nature' => $op->collection->name ?? '',
                'collection' => number_format($amount, 2),
                'btr' => $btr !== null ? number_format($btr, 2) : null,
                'trust' => $trust !== null ? number_format($trust, 2) : null,
                'undeposited' => $undeposited !== null ? number_format($undeposited, 2) : null,
                'is_deposited' => $isTrust || $isDeposited,
                'deposit_date' => $receipt->depositList->deposit->date ?? null,
                'can_deposit' => $isBtr && ! $isDeposited,
            ];
        }

        return [
            'header' => [
                'officer' => $user->profile->fullname ?? $user->name,
                'station' => $user->profile->agency->name ?? '',
                'month' => \DateTime::createFromFormat('!m', $month)->format('F'),
                'year' => $year,
            ],
            'rows' => $rows,
            'totals' => [
                'collection' => number_format($totals['collection'], 2),
                'btr' => number_format($totals['btr'], 2),
                'trust' => number_format($totals['trust'], 2),
                'undeposited' => number_format($totals['undeposited'], 2),
            ],
        ];
    }

    public function cashReceiptsPrint($request)
    {
        $data = $this->cashReceipts($request);

        $pdf = \PDF::loadView('finance.reports.cash-receipts', $data)->setPaper('legal', 'landscape');

        return $pdf->stream('cash-receipts-record-'.strtolower($data['header']['month']).'-'.$data['header']['year'].'.pdf');
    }

    public function cashReceiptsExcel($request)
    {
        $data = $this->cashReceipts($request);

        $filename = 'cash-receipts-record-'.strtolower($data['header']['month']).'-'.$data['header']['year'].'.xlsx';

        return Excel::download(new CashReceiptsExport($data), $filename);
    }

    public function depositBtr($request)
    {
        $user = \Auth::user();
        $ids = $request->ids ?: [];

        $receipts = FinanceReceipt::whereIn('id', $ids)
            ->where('is_cancelled', 0)
            ->whereDoesntHave('depositList')
            ->with('op:id,total,payment_id', 'op.payment:id,name', 'detail:id,receipt_id,amount')
            ->get();

        if ($receipts->isEmpty()) {
            return [
                'data' => null,
                'message' => 'Nothing to deposit',
                'info' => 'Please select at least one undeposited BTR receipt.',
                'status' => false,
            ];
        }

        $total = 0;
        foreach ($receipts as $receipt) {
            $total += $this->receiptAmount($receipt->op, $receipt);
        }

        $numbers = $receipts->pluck('number')->map(fn ($n) => (int) $n)->sort();

        $deposit = FinanceDeposit::create([
            'start' => (string) $numbers->first(),
            'end' => (string) $numbers->last(),
            'total' => $total,
            'deposit_id' => 26,
            'orseries_id' => $receipts->first()->orseries_id,
            'created_by' => $user->id,
            'agency_id' => $user->profile->agency_id,
            'date' => $request->date ?: date('Y-m-d'),
            'account_id' => $request->account_id,
            'funding_id' => $request->funding_id,
        ]);

        foreach ($receipts as $receipt) {
            FinanceDepositList::create([
                'finance_deposit_id' => $deposit->id,
                'finance_receipt_id' => $receipt->id,
            ]);
        }

        FinanceReceipt::whereIn('id', $receipts->pluck('id'))->update([
            'is_deposit' => 1,
        ]);

        return [
            'data' => $deposit,
            'message' => 'Deposit recorded',
            'info' => 'The selected official receipts have been grouped under the '.$deposit->date.' bank deposit.',
            'status' => true,
        ];
    }

    public function deposits($request)
    {
        $user = \Auth::user();

        $deposits = FinanceDeposit::with('deposit:id,name')
            ->where('agency_id', $user->profile->agency_id)
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('start', 'like', "%{$keyword}%")
                        ->orWhere('end', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('date', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate($request->count ?: 10);

        $deposits->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'start' => $item->start,
                'end' => $item->end,
                'total' => $item->total,
                'type' => $item->deposit->name ?? '',
                'date' => date('F d, Y', strtotime($item->date)),
                'count' => $item->lists()->count(),
            ];
        });

        return DefaultResource::collection($deposits);
    }

    public function depositView($request)
    {
        return $this->depositBundle($request->id);
    }

    public function depositPrint($request)
    {
        $data = $this->depositBundle($request->id);

        if (! $data['deposit']) {
            abort(404);
        }

        $pdf = \PDF::loadView('finance.reports.deposit-slip', $data)->setPaper('legal', 'portrait');

        return $pdf->stream('deposit-slip-'.$data['deposit']['start'].'-'.$data['deposit']['end'].'.pdf');
    }

    private function depositBundle($id)
    {
        $deposit = FinanceDeposit::with('deposit:id,name', 'createdby.profile', 'account:id,name,code,account', 'funding.agency:id,name,code')->find($id);

        if (! $deposit) {
            return ['deposit' => null, 'receipts' => [], 'breakdown' => []];
        }

        $lists = FinanceDepositList::where('finance_deposit_id', $deposit->id)
            ->with([
                'receipt' => function ($query) {
                    $query->select('id', 'number', 'op_id', 'created_at')
                        ->with([
                            'op' => function ($q) {
                                $q->select('id', 'total', 'payment_id', 'collection_id', 'payorable_id', 'payorable_type')
                                    ->with('payment:id,name', 'collection:id,name')
                                    ->with(['payorable' => function ($morphTo) {
                                        $morphTo->morphWith([
                                            Customer::class => ['customer_name:id,name'],
                                        ]);
                                    }]);
                            },
                            'detail:id,receipt_id,amount',
                        ]);
                },
            ])
            ->get();

        $receipts = [];
        $breakdown = ['cash' => 0, 'cheque' => 0];

        foreach ($lists as $list) {
            $receipt = $list->receipt;
            $op = $receipt->op;
            $amount = $this->receiptAmount($op, $receipt);

            $receipts[] = [
                'date' => $receipt->created_at,
                'reference' => $receipt->number,
                'payor' => $this->payorName($op),
                'nature' => $op->collection->name ?? '',
                'payment' => $op->payment->name ?? '',
                'amount' => number_format($amount, 2),
            ];

            if ($op->payment && $op->payment->name === 'Cash') {
                $breakdown['cash'] += $amount;
            } elseif ($op->payment && $op->payment->name === 'Cheque') {
                $breakdown['cheque'] += $amount;
            }
        }

        $dateRange = FinanceReceipt::whereIn('id', $lists->pluck('finance_receipt_id'))
            ->selectRaw('MIN(created_at) as min_date, MAX(created_at) as max_date')
            ->first();

        return [
            'deposit' => [
                'id' => $deposit->id,
                'start' => $deposit->start,
                'end' => $deposit->end,
                'total' => $deposit->total,
                'type' => $deposit->deposit->name ?? '',
                'date' => date('F d, Y', strtotime($deposit->date)),
                'account' => $deposit->account->account ?? '',
                'account_name' => $deposit->account->name ?? '',
                'account_code' => $deposit->account->code ?? '',
                'funding_source' => $deposit->funding->source ?? '',
                'fund_code' => $deposit->funding->code ?? '',
                'agency_credited' => $deposit->funding->agency->name ?? '',
                'agency_code' => $deposit->funding->agency->code ?? '',
                'collecting_officer' => $deposit->createdby->profile->fullname ?? ($deposit->createdby->name ?? ''),
                'date_collected' => $dateRange && $dateRange->min_date
                    ? ($dateRange->min_date === $dateRange->max_date
                        ? date('m/d/Y', strtotime($dateRange->min_date))
                        : date('m/d/Y', strtotime($dateRange->min_date)).' - '.date('m/d/Y', strtotime($dateRange->max_date)))
                    : '',
            ],
            'receipts' => $receipts,
            'breakdown' => [
                'cash' => number_format($breakdown['cash'], 2),
                'cheque' => number_format($breakdown['cheque'], 2),
            ],
        ];
    }

    private function payorName($op)
    {
        if ($op->payorable_type === 'App\Models\Customer' && $op->payorable) {
            $suffix = ($op->payorable->name == 'Main') ? '' : ' - '.$op->payorable->name;
            return ($op->payorable->customer_name->name ?? '').$suffix;
        }

        return $op->payorable->name ?? '';
    }

    private function receiptAmount($op, $receipt)
    {
        if ($op->payment && in_array($op->payment->name, ['Cash', 'Wallet'])) {
            return (float) str_replace(',', '', trim($op->total, '₱ '));
        }

        return $receipt->detail
            ? (float) str_replace(',', '', trim($receipt->detail->amount, '₱ '))
            : (float) str_replace(',', '', trim($op->total, '₱ '));
    }
}
