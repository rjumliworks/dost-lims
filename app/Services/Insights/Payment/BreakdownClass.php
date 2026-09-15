<?php

namespace App\Services\Insights\Payment;

use Illuminate\Support\Facades\DB;

class BreakdownClass
{
    public function status($request){
        $year = $request->year;
        $laboratory = $request->laboratory;

        return DB::table('tsr_payments')
            ->join('tsrs', 'tsr_payments.tsr_id', '=', 'tsrs.id')
            ->join('list_statuses', 'tsr_payments.status_id', '=', 'list_statuses.id')
            ->select(
                'list_statuses.name as name',
                DB::raw('COUNT(*) as count'),
                DB::raw('COALESCE(SUM(tsr_payments.total),0) as amount')
            )
            ->where('tsrs.status_id', '!=', 5)
            ->when($laboratory, fn ($q) => $q->where('tsrs.laboratory_id', $laboratory))
            ->when($year, fn ($q) => $q->whereYear('tsrs.created_at', $year))
            ->groupBy('list_statuses.id', 'list_statuses.name')
            ->orderBy('amount', 'DESC')
            ->get();
    }

    public function type($request){
        $year = $request->year;
        $laboratory = $request->laboratory;

        return DB::table('tsr_payments')
            ->join('tsrs', 'tsr_payments.tsr_id', '=', 'tsrs.id')
            ->leftJoin('list_dropdowns', 'tsr_payments.payment_id', '=', 'list_dropdowns.id')
            ->select(
                DB::raw("COALESCE(list_dropdowns.name, 'Unspecified') as name"),
                DB::raw('COUNT(*) as count'),
                DB::raw('COALESCE(SUM(tsr_payments.total),0) as amount')
            )
            ->where('tsrs.status_id', '!=', 5)
            ->when($laboratory, fn ($q) => $q->where('tsrs.laboratory_id', $laboratory))
            ->when($year, fn ($q) => $q->whereYear('tsrs.created_at', $year))
            ->groupBy('list_dropdowns.id', 'list_dropdowns.name')
            ->orderBy('amount', 'DESC')
            ->get();
    }

    public function discountIndividual($request){
        return $this->discountByType($request, 1);
    }

    public function discountFirms($request){
        return $this->discountByType($request, 0);
    }

    private function discountByType($request, $isIndividual){
        $year = $request->year;
        $laboratory = $request->laboratory;

        return DB::table('tsr_payments')
            ->join('tsrs', 'tsr_payments.tsr_id', '=', 'tsrs.id')
            ->join('list_discounts', 'tsr_payments.discount_id', '=', 'list_discounts.id')
            ->select(
                'list_discounts.name as name',
                DB::raw('COUNT(*) as count'),
                DB::raw('COALESCE(SUM(tsr_payments.discount),0) as amount')
            )
            ->where('tsrs.status_id', '!=', 5)
            ->where(function ($q) use ($isIndividual) {
                $q->where('list_discounts.is_individual', $isIndividual)
                    ->orWhere('list_discounts.name', 'Regular');
            })
            ->when($laboratory, fn ($q) => $q->where('tsrs.laboratory_id', $laboratory))
            ->when($year, fn ($q) => $q->whereYear('tsrs.created_at', $year))
            ->groupBy('list_discounts.id', 'list_discounts.name')
            ->orderBy('amount', 'DESC')
            ->get();
    }

    public function collection($request){
        $year = $request->year;
        $laboratory = $request->laboratory;

        return DB::table('tsr_payments')
            ->join('tsrs', 'tsr_payments.tsr_id', '=', 'tsrs.id')
            ->leftJoin('list_dropdowns', 'tsr_payments.collection_id', '=', 'list_dropdowns.id')
            ->select(
                DB::raw("COALESCE(list_dropdowns.name, 'Unspecified') as name"),
                DB::raw('COUNT(*) as count'),
                DB::raw('COALESCE(SUM(tsr_payments.total),0) as amount')
            )
            ->where('tsrs.status_id', '!=', 5)
            ->when($laboratory, fn ($q) => $q->where('tsrs.laboratory_id', $laboratory))
            ->when($year, fn ($q) => $q->whereYear('tsrs.created_at', $year))
            ->groupBy('list_dropdowns.id', 'list_dropdowns.name')
            ->orderBy('amount', 'DESC')
            ->get();
    }
}
