<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Directoryxx\Finac\Model\TrxJournal as Journal;
use Directoryxx\Finac\Model\TypeJurnal;
use Directoryxx\Finac\Model\JurnalA;
use Directoryxx\Finac\Request\JournalUpdate;
use Directoryxx\Finac\Request\JournalStore;
use Directoryxx\Finac\Request\JournalAstore;
use App\Http\Controllers\Controller;
use App\Models\Currency;

class TrialBalanceController extends Controller
{
    public function index()
    {
        return view('trialbalanceview::index');
    }

	public function getData($startDate, $finishDate)
	{
		$query = "select
		memfis.coas.code as AccountCode,
		memfis.coas.name as AccountName,
		memfis.types.name as TypeCoa,
		memfis.coas.Description as Tipe,
		(
		CASE WHEN
		CAST(trxjournals.Transaction_Date as date) < $startDate
		THEN
		(
		CASE WHEN
		memfis.types.name = 'ACTIVA' or memfis.types.name = 'BIAYA'
		THEN
		SUM(Debit-Credit)
		ELSE
		SUM(Credit-Debit)
		END
		)
		ELSE
		0
		END
		) as BeginningBalance,
		(
		CASE WHEN
		CAST(trxjournals.Transaction_Date as date) between $startDate and $finishDate
		THEN
		SUM(Debit)
		ELSE
		0
		END
		) Debit,
		(
		CASE WHEN
		CAST(trxjournals.Transaction_Date as date) between $startDate and $finishDate
		THEN
		SUM(Credit)
		ELSE
		0
		END
		) Credit
		from memfis.coas
		left join memfis.types on (types.`of`= 'coa') and (memfis.coas.type_id = memfis.types.id)
		left join trxjournala on trxjournala.account_code = memfis.coas.code
		left join trxjournals on trxjournals.voucher_no = trxjournala.voucher_no
		group by memfis.coas.code
		order by memfis.coas.code";

		$data = DB::select($query);
		return $data;
	}

	public function print(Request $request)
	{
		$tmp_date = explode('-', $request->daterange);

		$startDate = trim($tmp_date[0]);
		$finishDate = trim($tmp_date[1]);

		$data = [
			'data' =>  $this->getData($startDate, $finishDate),
			'startDate' => $startDate,
			'finishDate' => $finishDate,
		];

		dd($data);

        $pdf = \PDF::loadView('formview::trial-balance', $data);
        return $pdf->stream();
	}
}
