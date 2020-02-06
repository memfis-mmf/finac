<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use memfisfa\Finac\Model\QueryFunction as QF;
use memfisfa\Finac\Model\Coa;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        return view('generalledgerview::index');
    }

	public function show(Request $request)
	{
		$code = explode(',', $request->data);
		$data['coa'] = Coa::whereIn('code', $code)->get();

		dd($request->all());

		return view('generalledgerview::show', $data);
	}

	public function getData($beginDate, $endingDate)
	{

		$queryStatement ='
			SET @BeginDate = "'.$beginDate.'";
			SET @EndingDate = "'.$endingDate.'";
		';

		$query = "
			SELECT
			m_journal.*,
			IFNULL(IFNULL((a.Debit),(b.Debit)),0) as Debit,
			IFNULL(IFNULL((a.Credit),(b.Credit)),0) as Credit,
			IFNULL(IFNULL((a.LastBalance),(b.LastBalance)),0) as LastBalance,
			IFNULL(IFNULL((a.CurrentBalance),(b.CurrentBalance)),0) as CurrentBalance,
			IFNULL(IFNULL((a.EndingBalance),(b.EndingBalance)),0) as EndingBalance
			from
			m_journal
			left join
			(
			select
			Query.AccountCode,
			IFNULL(sum(Query.Debit),0) as Debit,
			IFNULL(sum(Query.Credit),0) as Credit,
			IFNULL(sum(Query.LastBalance),0) as LastBalance,
			IFNULL(sum(Query.CurrentBalance),0) as CurrentBalance,
			IFNULL(sum(Query.EndingBalance),0) as EndingBalance
			from (select @StartDate:=@BeginDate a) start,(select @EndDate:=@EndingDate b) end , neraca as Query
			group by Query.AccountCode
			) a on a.AccountCode = m_journal.Code and m_journal.Description = 'Detail'
			left join
			(
			select
			m_journal.COA as AccountCode,
			IFNULL(sum(Query.Debit),0) as Debit,
			IFNULL(sum(Query.Credit),0) as Credit,
			IFNULL(sum(Query.LastBalance),0) as LastBalance,
			IFNULL(sum(Query.CurrentBalance),0) as CurrentBalance,
			IFNULL(sum(Query.EndingBalance),0) as EndingBalance
			from (select @StartDate:=@BeginDate a) start,(select @EndDate:=@EndingDate b) end , neraca as Query
			left join m_journal on
			substring(Query.AccountCode,1,LENGTH(m_journal.COA)) = m_journal.COA
			GROUP BY
			m_journal.COA
			) b on b.AccountCode = m_journal.COA and m_journal.Description = 'Header'

			Order by m_journal.Code;
		";

		DB::connection()->getpdo()->exec($queryStatement);
		$data = DB::select($query);

		return $data;
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
