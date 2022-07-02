<?php

namespace memfisfa\Finac\Model\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class GLExport implements FromView, ShouldAutoSize
{
    protected $data;

    function __construct($data) {

        $this->data = $data;
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function view(): View
    {
        return view('generalledgerview::export', $this->data);
    }

    public static function afterSheet(AfterSheet $event)
    {
        $columns = ['A', 'B', 'C'];

        foreach ($columns as $column) {
            $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(9999);
        }
    }
}

