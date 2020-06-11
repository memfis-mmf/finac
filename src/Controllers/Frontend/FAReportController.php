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
use memfisfa\Finac\Model\AReceiveA;

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

        $ar = AReceive::where('approve', true)->get();

        $data = [];

        // 1 ar banyak invoice dengan customer yang sama
        $data = [];
        foreach ($ar as $arRow) {
            $ara = $arRow->ara;

            foreach ($ara as $araRow) {
                $query_invoice = $araRow->invoice()
                    ->with(['customer'])
                    ->whereBetween('transactiondate', [$date[0], $date[1]])
                    ->where('location', $request->location);

                if ($request->currency) {
                    $query_invoice = $query_invoice
                        ->where('currency', $request->currency);
                }

                if ($request->customer) {
                    $query_invoice = $query_invoice
                        ->where('id_customer', $request->customer);
                }
                
                $invoice = $query_invoice
                    ->where('company_department', $department->name)->get();
                    

                if (count($invoice) > 0) {
                    $data[] = $invoice;
                }
            }

        }

        $currency_data = Currency::find($request->currency);

        $currency = 
            (@$currency_data)? strtoupper($currency_data->code): 'All';
        @$symbol = $currency_data->symbol;

        $data = [
            'data' => $data,
            'currency' => $currency,
            'symbol' => $symbol,
            'department' => $department,
            'location' => $request->location,
            'date' => $date,
        ];
        
        return view('arreport-accountrhview::index', $data);
    }

}
