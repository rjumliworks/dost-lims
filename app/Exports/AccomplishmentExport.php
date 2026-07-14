<?php

namespace App\Exports;

use App\Models\Tsr;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AccomplishmentExport implements FromView
{
    protected $month,$year,$lab;

    function __construct($month,$year,$lab) {
        $this->month = $month;
        $this->year = $year;
        $this->lab = $lab;
    }

    public function view(): View
    {
        $lists = Tsr::select('id','code','customer_id')
        ->with('customer:id,name,name_id','customer.customer_name:id,name','customer.address:address,customer_id,region_code,province_code,municipality_code,barangay_code','customer.address.region:code,name,region','customer.address.province:code,name','customer.address.municipality:code,name','customer.address.barangay:code,name')
        
        ->with('payment.type')
        ->whereMonth('created_at',$this->month)
        ->whereYear('created_at',$this->year)
        ->where('laboratory_id',$this->lab)
        ->where('status_id','!=',5)
        ->get();

    
        // dd($this->month,$this->year,$this->lab);

        foreach ($lists as $row) {

            $address = ($row['customer']['address']['address'] != '' || $row['customer']['address']['address'] != NULL) ? $row['customer']['address']['address'].', ' : '';
            if ($row['customer']['address']['municipality']['name'] == 'Zamboanga City' || $row['customer']['address']['municipality']['name'] == 'Isabela City') {
                $a = '';
            } else {
                $a = ', '.$row['customer']['address']['province']['name'];
            }

            $complete_address = $address.$row['customer']['address']['barangay']['name'].', '.$row['customer']['address']['municipality']['name'].$a;

            $code = $row['code'];
            // $customer = $row['customer']['customer_name']['name'];
            $address = $complete_address;
            $gratis =  ($row['payment']['is_free']) ? $row['payment']['discount'] : '-';

            $customer = $row['customer']['customer_name']['name'];
            if($row['customer']['name'] != 'Main'){
                $customerComplete = $row['customer']['customer_name']['name'].' - '.$row['customer']['name'];
            }else{
                $customerComplete = $row['customer']['customer_name']['name'];
            }

            $tsrs[] = [
                "code" => $code,
                "customer" => $customerComplete,
                "address" => $complete_address,
                "ornumber" => $row['payment']['or_number'],
                "subtotal" => $row['payment']['subtotal'],
                "discount" => ($row['payment']['is_free']) ? '-' : $row['payment']['discount'],
                "type" => ( $row['payment']['type']) ? $row['payment']['type']['name'] : '-',
                "total" => $row['payment']['total'],
                "gratis" => $gratis,
                "date" =>  $row['payment']['paid_at'],
            ];
        }


        return view('exports.accomplishment', [
            'lists' => $tsrs
        ]);
    }
}
