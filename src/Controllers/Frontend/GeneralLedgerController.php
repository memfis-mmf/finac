<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use memfisfa\Finac\Model\QueryFunction as QF;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        return view('generalledgerview::index');
    }

	public function convertDate($date)
	{
		$tmp_date = explode('-', $date);

		$startDate = date(
			'Y-m-d',
			strtotime(
				str_replace("/", "-", trim($tmp_date[0]))
			)
		);

		$finishDate = date(
			'Y-m-d',
			strtotime(
				str_replace("/", "-", trim($tmp_date[1]))
			)
		);

		return [
			$startDate,
			$finishDate
		];
	}
}
