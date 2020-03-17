<?php

namespace memfisfa\Finac\Model\Exports;

use memfisfa\Finac\Model\Coa;
use Maatwebsite\Excel\Concerns\FromArray;

class BSExport implements FromView
{
    public function view(): View
    {
        return view('balancesheetview::view', [
            
        ]);
    }
}

