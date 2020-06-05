<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use memfisfa\Finac\Model\Invoice;

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

        $currency = Currency::where('code', $request->currency)->first();

        $query = Invoice::where('transactiondate', [$date[0], $date[1]])
            ->where('location', $request->location)
            ->where('company_department', $request->company);

        if ($request->currency) {
            $query = $query->where('currency', $currency->id);
        }

        $data['data'] = $query->get();
        
        return view('arreport-accountrhview::index', $data);
    }

}
