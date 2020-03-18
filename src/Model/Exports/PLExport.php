<?php

namespace memfisfa\Finac\Model\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;

use DB;

class PLExport implements FromView
{
    protected $data;

    function __construct($data) {

        $this->data = $data;
    }

    public function view(): View
    {
        return view('profitlossview::view-pl-export', $this->data);
    }

    public static function afterSheet(AfterSheet $event)
    {
        $columns = ['A', 'B', 'C'];

        foreach ($columns as $column) {
            $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(9999);
        }
    }
}

