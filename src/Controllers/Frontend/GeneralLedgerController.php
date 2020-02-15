<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use memfisfa\Finac\Model\QueryFunction as QF;
use memfisfa\Finac\Model\Coa;
use Carbon\Carbon;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        return view('generalledgerview::index');
    }

	public function show(Request $request)
	{
		$code = explode(',', $request->data);
		$coa = Coa::whereIn('code', $code)->get();

		$coa_code = '';

		for ($i=0; $i < count($coa); $i++) {

			if ($i == count($coa)-1) {
				$coa_code .= $coa[$i]->code;
			}else{
				$coa_code .= $coa[$i]->code.',';
			}

		}

		$date = $this->convertDate($request->date);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$coa = '%%';

		if ($coa_code) {
			$coa = $coa_code;
		}

		$data = [
			'data' => $this->getData($beginDate, $endingDate, $coa),
			'beginDate' => $beginDate,
			'endingDate' => $endingDate,
			'coa' => $coa,
		];

		return view('generalledgerview::show', $data);
	}

	public function getData($beginDate, $endingDate, $coa)
	{

		$queryStatement ='
			SET @startDate = "'.$beginDate.'";
			SET @EndDate = "'.$endingDate.'";
			SET @Coa = "'.$coa.'";
		';

		$query = "
			select
			DATE_ADD(@startDate, INTERVAL -1 DAY) as TransactionDate,
			'Saldo Awal' as VoucherNo,
			' ' as VoucherNo,
			m_journal.code as AccountCode,
			m_journal.Name as Name,
			IFNULL(
			(select sum(debit-Credit) from trxjournala
			left join trxjournals on trxjournals.Voucher_No=trxjournala.Voucher_No
			where
			cast(trxjournals.Transaction_Date as date) < @startDate
			and
			trxjournala.account_code = m_journal.id
			)
			,0)
			AS SaldoAwal,
			0 AS Debit,
			0 AS Credit,
			'Saldo Awal' AS Description
			from m_journal
			where
			m_journal.description = 'Detail'
			and
			m_journal.code in (".$coa.")
			UNION ALL
			select
			trxjournals.transaction_date as TransactionDate,
			trxjournals.voucher_no as VoucherNo,
			trxjournals.ref_no as RefNo,
			m_journal.code as AccountCode,
			m_journal.Name as Name,
			0 AS SaldoAwal ,
			trxjournala.Debit AS Debit,
			trxjournala.Credit AS Credit,
			trxjournala.description AS Description
			from
			trxjournals
			left join trxjournala
			on trxjournals.voucher_no = trxjournala.voucher_no
			left join m_journal
			on trxjournala.account_code = m_journal.id
			where cast(trxjournals.transaction_date as date) between @startdate and @enddate
			and m_journal.code in (".$coa.")

			order by AccountCode,transactiondate asc
		";

		DB::connection()->getpdo()->exec($queryStatement);
		$data = DB::select($query);

		return $data;
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

	public function showDatatables(Request $request)
    {
		$_data = $this->getData(
			$request->beginDate,
			$request->endingDate,
			$request->coa
		);

		for ($i=0; $i < count($_data); $i++) {
			$arr = $_data[$i];

			$_data[$i]->type = Coa::where(
				'code',
				$arr->AccountCode
			)->first()->type->code;

			if ($_data[$i]->type == 'activa') {
				$_data[$i]->SaldoAkhir = $arr->SaldoAwal + $arr->Debit - $arr->Credit;
			}

			if ($_data[$i]->type == 'pasiva') {
				$_data[$i]->SaldoAkhir = $arr->SaldoAwal - $arr->Debit + $arr->Credit;
			}

			if ($_data[$i]->type == 'ekuitas') {
				$_data[$i]->SaldoAkhir = $arr->SaldoAwal + $arr->Credit - $arr->Debit;
			}

			if ($_data[$i]->type == 'pendapatan') {
				$_data[$i]->SaldoAkhir = $arr->SaldoAwal + $arr->Credit - $arr->Debit;
			}

			if ($_data[$i]->type == 'biaya') {
				$_data[$i]->SaldoAkhir = $arr->SaldoAwal + $arr->Debit - $arr->Credit;
			}
		}

		$data = $alldata = $_data;

		$datatable = array_merge([
			'pagination' => [], 'sort' => [], 'query' => []
		], $_REQUEST);

		$filter = isset($datatable['query']['generalSearch']) &&
			is_string($datatable['query']['generalSearch']) ?
			$datatable['query']['generalSearch'] : '';

        if (!empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (bool) preg_grep("/$filter/i", (array) $a);
            });

            unset($datatable['query']['generalSearch']);
        }

		$query = isset($datatable['query']) &&
			is_array($datatable['query']) ? $datatable['query'] : null;

        if (is_array($query)) {
            $query = array_filter($query);

            foreach ($query as $key => $val) {
                $data = $this->list_filter($data, [$key => $val]);
            }
        }

		$sort  = !empty($datatable['sort']['sort']) ?
			$datatable['sort']['sort'] : 'asc';
		$field = !empty($datatable['sort']['field']) ?
			$datatable['sort']['field'] : 'RecordID';

        $meta    = [];
		$page    = !empty($datatable['pagination']['page']) ?
			(int) $datatable['pagination']['page'] : 1;
		$perpage = !empty($datatable['pagination']['perpage']) ?
			(int) $datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = count($data);

        usort($data, function ($a, $b) use ($sort, $field) {
            if (!isset($a->$field) || !isset($b->$field)) {
                return false;
            }

            if ($sort === 'asc') {
                return $a->$field > $b->$field ? true : false;
            }

            return $a->$field < $b->$field ? true : false;
        });

        if ($perpage > 0) {
            $pages  = ceil($total / $perpage);
            $page   = max($page, 1);
            $page   = min($page, $pages);
            $offset = ($page - 1) * $perpage;

            if ($offset < 0) {
                $offset = 0;
            }

            $data = array_slice($data, $offset, $perpage, true);
        }

        $meta = [
            'page'    => $page,
            'pages'   => $pages,
            'perpage' => $perpage,
            'total'   => $total,
        ];

		if (
			isset($datatable['requestIds']) &&
			filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN))
		{
            $meta['rowIds'] = array_map(function ($row) {
                return $row->RecordID;
            }, $alldata);
        }

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

        $result = [
            'meta' => $meta + [
                'sort'  => $sort,
                'field' => $field,
            ],
            'data' => $data,
        ];

        echo json_encode($result, JSON_PRETTY_PRINT);
    }
}
