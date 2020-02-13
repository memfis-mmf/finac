<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use memfisfa\Finac\Model\QueryFunction as QF;

class BalanceSheetController extends Controller
{
    public function index()
    {
        return view('balancesheetview::index');
    }

	public function show(Request $request)
	{
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$tmp_data = $this->getData($beginDate, $endingDate);
		$viewGL = $this->getViewGL($tmp_data);

		$data = [
			'beginDate' => $beginDate,
			'endingDate' => $endingDate,
			'data' => $viewGL['data'],
			'totalActiva' => $viewGL['totalActiva'],
			'totalPasiva' => $viewGL['totalPasiva']
		];

        return view('balancesheetview::view', $data);
	}

	public function getViewGL($tmp_data)
	{
		$totalActiva = 0;
		$totalPasiva = 0;

		for (
			$index_tmp_data=0;
			$index_tmp_data < count($tmp_data);
			$index_tmp_data++
		) {
			$arr = $tmp_data[$index_tmp_data];

			if (strlen($arr->COA) == 2) {
				if ($arr->Type == 'activa') {
					$data['activa'][] = $arr;
					$index = count($data['activa'])-1;
					$data['activa'][$index]->total = 0;
				}else{
					$data['pasiva'][] = $arr;
					$index = count($data['pasiva'])-1;
					$data['pasiva'][$index]->total = 0;
				}
			}

			if (strlen($arr->COA) > 2 && strlen($arr->COA) < 5) {
				if ($arr->Type == 'activa') {
					$data['activa'][$index]->child[] = $arr;
					$data['activa'][$index]->total += $arr->CurrentBalance;
				}else{
					$data['pasiva'][$index]->child[] = $arr;
					$data['pasiva'][$index]->total += $arr->CurrentBalance;
				}
			}

			if (strlen($arr->COA) > 1 && strlen($arr->COA) < 5) {
				if ($arr->Type == 'activa') {
					$totalActiva += $arr->CurrentBalance;
				}else{
					$totalPasiva += $arr->CurrentBalance;
				}
			}
		}

		return [
			'data' => $data,
			'totalActiva' => $totalActiva,
			'totalPasiva' => $totalPasiva
		];
	}

	public function convertDate($date)
	{
		$tmp_date = explode('-', $date);

		$startDate = date(
			'Y-m-d',
			str_replace("/", "-", strtotime(trim($tmp_date[0])))
		);

		$finishDate = date(
			'Y-m-d',
			str_replace("/", "-", strtotime(trim($tmp_date[1])))
		);

		return [
			$startDate,
			$finishDate
		];
	}

	public function getData($beginDate, $endingDate)
	{
		$queryStatement = '
			SET @BeginDate = "'.$beginDate.'";
			SET @EndingDate = "'.$endingDate.'";
		';

		$query = "
			SELECT
			 m_journal.*,
			IFNULL(IFNULL((a.LastBalance),(b.LastBalance)),0) as LastBalance,
			IFNULL(IFNULL((a.CurrentBalance),(b.CurrentBalance)),0) as CurrentBalance,
			IFNULL(IFNULL((a.EndingBalance),(b.EndingBalance)),0) as EndingBalance
			from
			m_journal
			left join
			(
			select
			Query.AccountCode,
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
			IFNULL(sum(Query.LastBalance),0) as LastBalance,
			IFNULL(sum(Query.CurrentBalance),0) as CurrentBalance,
			IFNULL(sum(Query.EndingBalance),0) as EndingBalance
			from (select @StartDate:=@BeginDate a) start,(select @EndDate:=@EndingDate b) end , neraca as Query
			left join m_journal on
			substring(Query.AccountCode,1,LENGTH(m_journal.COA)) = m_journal.COA
			GROUP BY
			m_journal.COA
			) b on b.AccountCode = m_journal.COA and m_journal.Description = 'Header'
			where m_journal.type not in ('Pendapatan','Biaya')
			Order by m_journal.Code;
		";

		DB::connection()->getpdo()->exec($queryStatement);
		$data = DB::select($query);

		return $data;
	}

	public function print(Request $request)
	{
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$tmp_data = $this->getData($beginDate, $endingDate);

		return $tmp_data;
	}
}
