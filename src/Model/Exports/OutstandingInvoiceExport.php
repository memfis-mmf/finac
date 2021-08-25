<?php

namespace memfisfa\Finac\Model\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OutstandingInvoiceExport implements FromView, ShouldAutoSize
{
    protected $data;

    function __construct($data) {

        $this->data = $data;
    }

    public function view(): View
    {
        return view('arreport-outstandingview::export', $this->data);
    }
}

