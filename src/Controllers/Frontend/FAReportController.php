<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use memfisfa\Finac\Model\AReceive;
use memfisfa\Finac\Model\Invoice;
use stdClass;
use DB;
use memfisfa\Finac\Model\AReceiveA;

//use for export
use memfisfa\Finac\Model\Exports\ARHistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class FAReportController extends Controller
{
    public function index()
    {
        return view('arreportview::index');
    }

	public function convertDate($date)
	{
		$tmp_date = explode('-', $date);

		$start = new Carbon(str_replace('/', "-", trim($tmp_date[0])));
		$startDate = $start->format('Y-m-d');

		$end = new Carbon(str_replace('/', "-", trim($tmp_date[1])));
		$endDate = $end->format('Y-m-d');

		return [
			$startDate,
			$endDate
		];
    }

    public function getArHistory($request)
    {
        $date = $this->convertDate($request->daterange);

        $customer = Customer::with([
                'invoice' => function($invoice) {
                    $invoice
                        ->with([
                            'quotations:id,number'
                        ])
                        ->where('approve', true);
                }
            ])
            ->whereHas('invoice', function($invoice) {
                $invoice->where('approve', true);
            })
            ->get();

        $data = [
            'customer' => $customer,
            'date' => $date,
            'request' => $request
        ];

        return $data;
    }

    public function arHistory(Request $request)
    {
        if (
            !$request->daterange 
        ) {
            return redirect()->back();
        }

        $data = $this->getArHistory($request);
        $data['export'] = route('fa-report.ar-history-export', $request->all());
        
        return view('arreport-accountrhview::index', $data);
    }

    public function arHistoryExport(Request $request)
    {
        $data = $this->getArHistory($request);

        $startDate = Carbon::parse($data['date'][0])->format('d F Y');
        $endDate = Carbon::parse($data['date'][1])->format('d F Y');

        // return view('arreport-accountrhview::export', $data);
		return Excel::download(new ARHistoryExport($data), "AR History $startDate - $endDate.xlsx");
    }

}
