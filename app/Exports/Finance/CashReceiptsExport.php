<?php

namespace App\Exports\Finance;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CashReceiptsExport implements FromView
{
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function view(): View {
        return view('exports.cashreceipts', $this->data);
    }
}
