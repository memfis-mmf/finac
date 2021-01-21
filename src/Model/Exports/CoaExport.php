<?php

namespace memfisfa\Finac\Model\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class CoaExport implements FromView, ShouldAutoSize
{
    protected $data;

    function __construct($data) {

        $this->data = $data;
    }

    public function view(): View
    {
        ini_set('memory_limit', '-1');

        return view('mastercoaview::export', $this->data);
    }

    public static function afterSheet(AfterSheet $event)
    {
        $columns = ['A', 'B', 'C'];

        foreach ($columns as $column) {
            $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(9999);
        }
    }
}