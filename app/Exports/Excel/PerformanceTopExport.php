<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PerformanceTopExport implements FromView
{
    protected $rows, $title;

    function __construct($rows, $title) {
        $this->rows = $rows;
        $this->title = $title;
    }

    public function view(): View
    {
        return view('exports.performance-top', [
            'rows' => $this->rows,
            'title' => $this->title
        ]);
    }
}
