<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
		CAST(trxjournals.Transaction_Date as date) between @prmFirstDate and @prmLastDate
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

		for ($i=0; $i < count($data); $i++) {
			$x = $data[$i];

			if ($x->TypeCoa == 'ACTIVA') {
				$data[$i]->ending = $x->BeginningBalance + $x->Debit - $x->Credit;
			}

			if ($x->TypeCoa == 'PASIVA') {
				$data[$i]->ending = $x->BeginningBalance - $x->Debit + $x->Credit;
			}

			if ($x->TypeCoa == 'EKUITAS') {
				$data[$i]->ending = $x->BeginningBalance + $x->Credit - $x->Debit;
			}

			if ($x->TypeCoa == 'PENDAPATAN') {
				$data[$i]->ending = $x->BeginningBalance + $x->Credit - $x->Debit;
			}

			if ($x->TypeCoa == 'BIAYA') {
				$data[$i]->ending = $x->BeginningBalance + $x->Debit - $x->Credit;
			}
		}

		return $data;
	}

    public function datatables(Request $request)
    {
		$tmp_date = explode('-', $request->daterange);

		$startDate = trim($tmp_date[0]);
		$finishDate = trim($tmp_date[1]);

		$data = $alldata = $this->getData($startDate, $finishDate);

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

	public function print(Request $request)
	{
		$tmp_date = explode('-', $request->daterange);

		$startDate = trim($tmp_date[0]);
		$finishDate = trim($tmp_date[1]);

		$tmp_data = $this->getData($startDate, $finishDate);
		$total_data = count($tmp_data);
		$data_final = array_chunk($tmp_data, 19);

		$data = [
			'data' => $data_final,
			'total_data' => $total_data,
			'startDate' => $startDate,
			'finishDate' => $finishDate,
		];

        $pdf = \PDF::loadView('formview::trial-balance', $data);
        return $pdf->stream();
	}
}
