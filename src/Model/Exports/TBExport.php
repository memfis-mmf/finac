<?php

namespace memfisfa\Finac\Model\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;

class TBExport implements FromView
{
    protected $data;

    function __construct($data) {

        $this->data = $data;
    }

    public function view(): View
    {
        // return view('trialbalanceview::export', $this->data);
        return view('trialbalanceview::export-tree', $this->data);
    }

    public static function afterSheet(AfterSheet $event)
    {
        $columns = ['A', 'B', 'C'];

        foreach ($columns as $column) {
            $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(9999);
        }
    }
}

