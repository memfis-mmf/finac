<?php

namespace memfisfa\Finac\Model\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TBExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    protected $data;

    function __construct($data) {

        $this->data = $data;
    }


    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function view(): View
    {
        return view('trialbalanceview::export', $this->data);
        // return view('trialbalanceview::export-tree', $this->data);
    }
}

