<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerRequestingExport implements FromView
{
    protected $year, $laboratories;

    function __construct($year, $laboratories) {
        $this->year = $year;
        $this->laboratories = $laboratories;
    }

    public function view(): View
    {
        return view('exports.customer-requesting', [
            'year' => $this->year,
            'laboratories' => $this->laboratories
        ]);
    }
}
