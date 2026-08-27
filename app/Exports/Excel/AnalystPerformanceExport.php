<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AnalystPerformanceExport implements FromView
{
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.analyst-performance', $this->data);
    }
}
