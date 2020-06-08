<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use memfisfa\Finac\Model\AReceive;
use memfisfa\Finac\Model\Invoice;
use stdClass;
use DB;

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

    public function arHistory(Request $request)
    {
        $date = $this->convertDate($request->daterange);
        
        $department = Department::where('uuid', $request->department)->first();

        $query_ar = DB::table('a_receives')
            ->select(
                'invoices.transactionnumber', 
                'invoices.transactiondate', 
                'invoices.description', 
                'customers.name as customerName', 
                'quotations.number as quotationNumber'
            )
            ->join(
                'a_receive_a', 
                'a_receive_a.transactionnumber', 
                '=', 
                'a_receives.transactionnumber'
            )
            ->join('invoices', 'a_receive_a.id_invoice', '=', 'invoices.id')
            ->join('quotations', 'invoices.id_quotation', '=', 'quotations.id')
            ->join('customers', 'invoices.id_customer', '=', 'customers.id')
            ->where('a_receives.approve', true)
            ->whereBetween('invoices.transactiondate', [$date[0], $date[1]])
            ->where('invoices.location', $request->location)
            ->where('invoices.company_department', $department->name);

        if ($request->currency) {
            $currency = Currency::where('id', $request->currency)->first();
            $query_ar = $query_ar->where('invoices.currency', $currency->id);
        }

        $data = $query_ar->get();

        $currency = '-';

        if ($request->currency) {
            $currency = Currency::find($request->currency)->name;
        }

        $data = [
            'data' => $data,
            'department' => $department,
            'currency' => $currency,
            'location' => $request->location,
            'date' => $date,
        ];
        
        return view('arreport-accountrhview::index', $data);
    }

}
