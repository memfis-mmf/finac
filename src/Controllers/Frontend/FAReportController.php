<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Support\Carbon;

//use for export
use memfisfa\Finac\Model\Exports\ARHistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class FAReportController extends Controller
{
    public function index()
    {
        return view('arreportview::index');
    }
}
