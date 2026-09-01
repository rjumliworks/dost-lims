<?php

namespace App\Services\Finance;

use App\Models\Customer;
use App\Models\FinanceReceipt;
use Illuminate\Support\Str;

class ReportsClass
{
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
            ])
            ->where('is_cancelled', 0)
            ->where('created_by', $user->id)
            ->whereHas('op', function ($q) {
                $q->where('status_id', 7);
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

            if ($op->payorable_type === 'App\Models\Customer' && $op->payorable) {
                $suffix = ($op->payorable->name == 'Main') ? '' : ' - '.$op->payorable->name;
                $payor = ($op->payorable->customer_name->name ?? '').$suffix;
            } else {
                $payor = $op->payorable->name ?? '';
            }

            if ($op->payment && in_array($op->payment->name, ['Cash', 'Wallet'])) {
                $amount = (float) str_replace(',', '', trim($op->total, '₱ '));
            } else {
                $amount = $receipt->detail
                    ? (float) str_replace(',', '', trim($receipt->detail->amount, '₱ '))
                    : (float) str_replace(',', '', trim($op->total, '₱ '));
            }

            $isOnline = $op->payment && Str::contains(strtolower($op->payment->name), 'online');

            $btr = null;
            $trust = null;
            $undeposited = null;

            if ($isOnline) {
                $btr = $amount;
                $totals['btr'] += $amount;
            } elseif ($receipt->is_deposit) {
                $trust = $amount;
                $totals['trust'] += $amount;
            } else {
                $undeposited = $amount;
                $totals['undeposited'] += $amount;
            }

            $totals['collection'] += $amount;

            $rows[] = [
                'date' => $receipt->created_at,
                'reference' => $receipt->number,
                'payor' => $payor,
                'nature' => $op->collection->name ?? '',
                'collection' => number_format($amount, 2),
                'btr' => $btr !== null ? number_format($btr, 2) : null,
                'trust' => $trust !== null ? number_format($trust, 2) : null,
                'undeposited' => $undeposited !== null ? number_format($undeposited, 2) : null,
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
}
