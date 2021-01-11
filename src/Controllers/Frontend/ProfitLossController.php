<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Carbon\Carbon;
use memfisfa\Finac\Model\QueryFunction as QF;

//use for export
use memfisfa\Finac\Model\Exports\PLExport;
use Maatwebsite\Excel\Facades\Excel;

class ProfitLossController extends Controller
{
    public function index()
    {
        return view('profitlossview::index');
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
			where m_journal.type in ('Pendapatan','Biaya')
			Order by m_journal.Code;
		";

		DB::connection()->getpdo()->exec($queryStatement);
		$data = DB::select($query);

		return $data;
	}

	public function getViewPL($tmp_data)
	{
		$pendapatan_accumulated = 0;
		$pendapatan_period = 0;
		$biaya_accumulated = 0;
		$biaya_period = 0;
		$total_accumulated = 0;
		$total_period = 0;

		for ($a=0; $a < count($tmp_data); $a++) {
			$x = $tmp_data[$a];
			$code = str_split($x->code);

			$total_accumulated += $x->CurrentBalance;
			$total_period = $x->EndingBalance;

			if (
				$tmp_data[$a]->description == "Header"
				&& $code[4] == 0
				&& $code[3] == 0
			) {
				$x->child = [];

				if (strtolower($x->Type) == 'pendapatan') {
					$_data['pendapatan'][] = $x;
					$index_parent['pendapatan'] = count($_data['pendapatan']) - 1;

					// $pendapatan_accumulated += $x->CurrentBalance;
					// $pendapatan_period = $x->EndingBalance;
				}else{
					$_data['biaya'][] = $x;
					$index_parent['biaya'] = count($_data['biaya']) - 1;

					// $biaya_accumulated += $x->CurrentBalance;
					// $biaya_period += $x->EndingBalance;
				}
			}

			if (
				$tmp_data[$a]->description == "Header"
				&& $code[4] == 0
				&& $code[3] != 0
			) {
				if (strtolower($x->Type) == 'pendapatan') {
					$_data['pendapatan'][$index_parent['pendapatan']]
					->child[] = $x;

					$pendapatan_accumulated += $x->CurrentBalance;
					$pendapatan_period += $x->EndingBalance;
				}else{
					$_data['biaya'][$index_parent['biaya']]
					->child[] = $x;

					$biaya_accumulated += $x->CurrentBalance;
					$biaya_period += $x->EndingBalance;
				}
			}
		}

		return [
			'_data' => $_data,
			'pendapatan_accumulated' => $pendapatan_accumulated,
			'pendapatan_period' => $pendapatan_period,
			'biaya_accumulated' => $biaya_accumulated,
			'biaya_period' => $biaya_period,
			'total_accumulated' => $total_accumulated,
			'total_period' => $total_period,
		];
	}

	public function viewPL(Request $request)
	{
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$tmp_data = $this->getData($beginDate, $endingDate);

		$getPL = $this->getViewPL($tmp_data);

		$data = [
			'data' => $getPL['_data'],
			'beginDate' => $beginDate,
			'endingDate' => $endingDate,
			'pendapatan_accumulated' => $getPL['pendapatan_accumulated'],
			'pendapatan_period' => $getPL['pendapatan_period'],
			'biaya_accumulated' => $getPL['biaya_accumulated'],
			'biaya_period' => $getPL['biaya_period'],
			'total_accumulated' => $getPL['total_accumulated'],
			'total_period' => $getPL['total_period'],
			'daterange' => $request->daterange
		];

        return view('profitlossview::view-pl', $data);
    }

	public function export(Request $request)
	{
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$tmp_data = $this->getData($beginDate, $endingDate);

		$getPL = $this->getViewPL($tmp_data);

		$data = [
			'data' => $getPL['_data'],
			'beginDate' => $beginDate,
			'endingDate' => $endingDate,
			'pendapatan_accumulated' => $getPL['pendapatan_accumulated'],
			'pendapatan_period' => $getPL['pendapatan_period'],
			'biaya_accumulated' => $getPL['biaya_accumulated'],
			'biaya_period' => $getPL['biaya_period'],
			'total_accumulated' => $getPL['total_accumulated'],
			'total_period' => $getPL['total_period'],
			'daterange' => $request->daterange
		];

		return Excel::download(new PLExport($data), 'PL.xlsx');
	}

	public function detailPL(Request $request)
	{
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$tmp_data = $this->getData($beginDate, $endingDate);

		$pendapatan_accumulated = 0;
		$pendapatan_period = 0;
		$biaya_accumulated = 0;
		$biaya_period = 0;
		$total_accumulated = 0;
		$total_period = 0;

		for ($a=0; $a < count($tmp_data); $a++) {
			$x = $tmp_data[$a];
			$code = str_split($x->code);

			$total_accumulated += $x->CurrentBalance;
			$total_period = $x->EndingBalance;

			// parent
			if (
				$tmp_data[$a]->description == "Header"
				&& $code[4] == 0
				&& $code[3] == 0
			) {
				$x->child = [];

				if ($x->Type == 'pendapatan') {
					$_data['pendapatan'][] = $x;
					$index_parent['pendapatan'] = count($_data['pendapatan']) - 1;

					$pendapatan_accumulated += $x->CurrentBalance;
					$pendapatan_period = $x->EndingBalance;
				}else{
					$_data['biaya'][] = $x;
					$index_parent['biaya'] = count($_data['biaya']) - 1;

					$biaya_accumulated += $x->CurrentBalance;
					$biaya_period += $x->EndingBalance;
				}
			}

			// child
			if (
				$tmp_data[$a]->description == "Header"
				&& $code[4] == 0
				&& $code[3] != 0
			) {
				$x->grandchild = [];

				if ($x->Type == 'pendapatan') {
					$_data['pendapatan'][$index_parent['pendapatan']]
					->child[] = $x;

					$index_child['pendapatan'] = count(
						$_data['pendapatan'][$index_parent['pendapatan']]->child
					) - 1;

					$pendapatan_accumulated += $x->CurrentBalance;
					$pendapatan_period += $x->EndingBalance;
				}else{
					$_data['biaya'][$index_parent['biaya']]
					->child[] = $x;
					$index_child['biaya'] = count(
						$_data['biaya'][$index_parent['pendapatan']]->child
					) - 1;

					$biaya_accumulated += $x->CurrentBalance;
					$biaya_period += $x->EndingBalance;
				}
			}

			// grand child
			if (
				$tmp_data[$a]->description == "Header"
				&& $code[4] != 0
				&& $code[3] != 0
			) {
				if ($x->Type == 'pendapatan') {
					$_data['pendapatan'][$index_parent['pendapatan']]
					->child[$index_child['pendapatan']]->grandchild[] = $x;

					$pendapatan_accumulated += $x->CurrentBalance;
					$pendapatan_period += $x->EndingBalance;
				}else{
					$_data['biaya'][$index_parent['biaya']]
					->child[$index_child['biaya']]->grandchild[] = $x;

					$biaya_accumulated += $x->CurrentBalance;
					$biaya_period += $x->EndingBalance;
				}
			}
		}

		$data = [
			'data' => $_data,
			'beginDate' => $beginDate,
			'endingDate' => $endingDate,
			'pendapatan_accumulated' => $pendapatan_accumulated,
			'pendapatan_period' => $pendapatan_period,
			'biaya_accumulated' => $biaya_accumulated,
			'biaya_period' => $biaya_period,
			'total_accumulated' => $total_accumulated,
			'total_period' => $total_period,
			'daterange' => $request->daterange
		];

        return view('profitlossview::detail-pl', $data);
	}

	public function printViewPL(Request $request)
	{
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$tmp_data = $this->getData($beginDate, $endingDate);

		$getPL = $this->getViewPL($tmp_data);

		$data = [
			'data' => $getPL['_data'],
			'beginDate' => $beginDate,
			'endingDate' => $endingDate,
			'pendapatan_accumulated' => $getPL['pendapatan_accumulated'],
			'pendapatan_period' => $getPL['pendapatan_period'],
			'biaya_accumulated' => $getPL['biaya_accumulated'],
			'biaya_period' => $getPL['biaya_period'],
			'total_accumulated' => $getPL['total_accumulated'],
			'total_period' => $getPL['total_period'],
		];

        $pdf = \PDF::loadView('formview::view-pl', $data);
        return $pdf->stream();
    }

	public function printDetailPL(Request $request)
	{
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$tmp_data = $this->getData($beginDate, $endingDate);

		$pendapatan_accumulated = 0;
		$pendapatan_period = 0;
		$biaya_accumulated = 0;
		$biaya_period = 0;
		$total_accumulated = 0;
		$total_period = 0;

		for ($a=0; $a < count($tmp_data); $a++) {
			$x = $tmp_data[$a];
			$code = str_split($x->code);

			$total_accumulated += $x->CurrentBalance;
			$total_period = $x->EndingBalance;

			// parent
			if (
				$tmp_data[$a]->description == "Header"
				&& $code[4] == 0
				&& $code[3] == 0
			) {
				$x->child = [];

				if ($x->Type == 'pendapatan') {
					$_data['pendapatan'][] = $x;
					$index_parent['pendapatan'] = count($_data['pendapatan']) - 1;

					$pendapatan_accumulated += $x->CurrentBalance;
					$pendapatan_period = $x->EndingBalance;
				}else{
					$_data['biaya'][] = $x;
					$index_parent['biaya'] = count($_data['biaya']) - 1;

					$biaya_accumulated += $x->CurrentBalance;
					$biaya_period += $x->EndingBalance;
				}
			}

			// child
			if (
				$tmp_data[$a]->description == "Header"
				&& $code[4] == 0
				&& $code[3] != 0
			) {
				$x->grandchild = [];

				if ($x->Type == 'pendapatan') {
					$_data['pendapatan'][$index_parent['pendapatan']]
					->child[] = $x;

					$index_child['pendapatan'] = count(
						$_data['pendapatan'][$index_parent['pendapatan']]->child
					) - 1;

					$pendapatan_accumulated += $x->CurrentBalance;
					$pendapatan_period += $x->EndingBalance;
				}else{
					$_data['biaya'][$index_parent['biaya']]
					->child[] = $x;
					$index_child['biaya'] = count(
						$_data['biaya'][$index_parent['pendapatan']]->child
					) - 1;

					$biaya_accumulated += $x->CurrentBalance;
					$biaya_period += $x->EndingBalance;
				}
			}

			// grand child
			if (
				$tmp_data[$a]->description == "Header"
				&& $code[4] != 0
				&& $code[3] != 0
			) {
				if ($x->Type == 'pendapatan') {
					$_data['pendapatan'][$index_parent['pendapatan']]
					->child[$index_child['pendapatan']]->grandchild[] = $x;

					$pendapatan_accumulated += $x->CurrentBalance;
					$pendapatan_period += $x->EndingBalance;
				}else{
					$_data['biaya'][$index_parent['biaya']]
					->child[$index_child['biaya']]->grandchild[] = $x;

					$biaya_accumulated += $x->CurrentBalance;
					$biaya_period += $x->EndingBalance;
				}
			}
		}

		$data = [
			'data' => $_data,
			'beginDate' => $beginDate,
			'endingDate' => $endingDate,
			'pendapatan_accumulated' => $pendapatan_accumulated,
			'pendapatan_period' => $pendapatan_period,
			'biaya_accumulated' => $biaya_accumulated,
			'biaya_period' => $biaya_period,
			'total_accumulated' => $total_accumulated,
			'total_period' => $total_period,
			'daterange' => $request->daterange
		];

        $pdf = \PDF::loadView('formview::detail-pl', $data);
        return $pdf->stream();
	}
}
