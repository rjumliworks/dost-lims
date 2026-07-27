<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\FromView;

class PezaExport implements FromView
{
    protected $region,$province,$municipality,$barangay;

    function __construct($region,$province,$municipality,$barangay) {
        $this->region = $region;
        $this->province = $province;
        $this->municipality = $municipality;
        $this->barangay = $barangay;
    }

    public function view(): View
    {
        
        // Subquery: payments per TSR (correctly grouped)
        $tsrPayments = \DB::table('tsr_payments')
            ->select('tsr_id', \DB::raw('SUM(total) as total'))
            ->where('status_id', 7)
            ->groupBy('tsr_id');

        // Subquery: service count per TSR (optional if needed separately)
        $tsrServices = \DB::table('tsr_analyses')
            ->join('tsr_samples', 'tsr_samples.id', '=', 'tsr_analyses.sample_id')
            ->select('tsr_samples.tsr_id', \DB::raw('COUNT(tsr_analyses.id) as service_count'))
            ->groupBy('tsr_samples.tsr_id');

        // Main query
        $lists = Customer::select(
                'customers.id',
                'customers.name',
                'customers.is_main',
                'customer_names.name as customer_name',
                'customer_names.has_branches as has_branches',
                'customer_contacts.email',
                'customer_contacts.contact_no',
                \DB::raw('COUNT(DISTINCT tsrs.id) as count'),
                \DB::raw('SUM(tsr_pay.total) as total'),
                \DB::raw('SUM(COALESCE(tsr_services.service_count, 0)) as services')
            )
            ->join('tsrs', 'customers.id', '=', 'tsrs.customer_id')
            ->leftJoinSub($tsrPayments, 'tsr_pay', function ($join) {
                $join->on('tsrs.id', '=', 'tsr_pay.tsr_id');
            })
            ->leftJoinSub($tsrServices, 'tsr_services', function ($join) {
                $join->on('tsrs.id', '=', 'tsr_services.tsr_id');
            })
            ->join('customer_names', 'customers.name_id', '=', 'customer_names.id')
            ->leftJoin('customer_contacts', 'customers.id', '=', 'customer_contacts.customer_id')
            ->whereHas('address', function ($query) {
                if (!empty($this->region)) {
                    $query->where('region_code', $this->region);
                }
                if (!empty($this->province)) {
                    $query->where('province_code', $this->province);
                }
                if (!empty($this->municipality)) {
                    $query->where('municipality_code', $this->municipality);
                }
                if (!empty($this->barangay)) {
                    $query->where('barangay_code', $this->barangay);
                }
            })
            ->whereYear('tsrs.created_at', now()->year)
            ->where('industry_id','!=',22) //GOVERNMENT
            ->groupBy(
                'customers.id',
                'customers.name',
                'customers.is_main',
                'customer_names.name',
                'customer_names.has_branches',
                'customer_contacts.email',
                'customer_contacts.contact_no',
            )
            ->orderByDesc('total')
            ->get();

        $tsrs = [];
        foreach ($lists as $row) {
            $name = ($row['name'] == 'Main') ? '' : ' - '.$row['name'];
            $tsrs[] = [
                "name" => $row['customer_name'].' '.$name,
                "email" => $this->decrypt($row['email']),
                "contact_no" => $this->decrypt($row['contact_no']),
                "count" => $row['count'],
                "services" => $row['services'],
                "total" => $row['total']
            ];
        }

        return view('exports.peza', [
            'lists' => $tsrs
        ]);
    }

    private function decrypt($value)
    {
        if (empty($value)) {
            return $value;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

}
