<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

//use for export
use memfisfa\Finac\Model\Exports\TBExport;
use Maatwebsite\Excel\Facades\Excel;
use memfisfa\Finac\Model\Coa;

class TrialBalanceController extends Controller
{
    public function index()
    {
        return view('trialbalanceview::index');
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

    public function datatables(Request $request)
    {
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$data = $alldata = $this->getData($beginDate, $endingDate);

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
        ini_set('max_excecution_time', -1);
        ini_set('memory_limit', -1);
        set_time_limit(-1);

		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$data_final = $this->getData($beginDate, $endingDate);
		$total_data = count($data_final);

		$data = [
			'data' => $data_final,
			'total_data' => $total_data,
			'startDate' => $beginDate,
			'finishDate' => $endingDate,
		];

        $pdf = \PDF::loadView('formview::trial-balance', $data);
		$pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
	}

	public function export(Request $request)
	{
		$date = $this->convertDate($request->daterange);

		$beginDate = $date[0];
		$endingDate = $date[1];

		$tmp_data = $this->getData($beginDate, $endingDate);
        $total_data = count($tmp_data);
        $total_beginning = 0;
        $total_debit = 0;
        $total_credit = 0;
        $total_period = 0;
        $total_ending = 0;
        
        foreach ($tmp_data as $tmp_data_index => $tmp_data_row) {
            // calculate period balance
            $tmp_data_row->period_balance = 
                $tmp_data_row->Debit - $tmp_data_row->Credit;

            // calculate every total
            if (strtolower($tmp_data_row->description) == 'header') {
                $total_beginning += $tmp_data_row->LastBalance;
                $total_debit += $tmp_data_row->Debit;
                $total_credit += $tmp_data_row->Credit;
                $total_period += $tmp_data_row->period_balance;
            }

            // jika coa tidak ada (bisa aja udah kehapus)
            if (! Coa::where('code', $tmp_data_row->code)->first()) {
                unset($tmp_data[$tmp_data_index]);
                continue;
            }

            $tmp_data_row->level = Coa::where('code', $tmp_data_row->code)->first()->coa_number;
        }

        $total_ending = $total_beginning + $total_debit - $total_credit;

        $tmp_data = array_filter($tmp_data);
        $tmp_data = collect($tmp_data);
        $tmp_data = $tmp_data->groupBy('level');

        $data_final = [];
        foreach ($tmp_data as $tmp_data_row) {
            $data_final[] = $tmp_data_row;
        }

        $data_final = collect($data_final);

        //re arange code
        foreach ($data_final as $data_final_index => $data_final_row) {
            // jika bukan loopingan pertama
            if ($data_final_index > 0) {
                // semakin kecil angka levelnya, semakin tinggi tingkatannya
                // jika data sekarang itu masuk ke header baru (parent)
                if (strlen($data_final[$data_final_index-1][0]->level) > strlen($data_final_row[0]->level)) {
                    $tmp_array = [$data_final->filter(function($row) use($data_final_row) {
                            if ($row[0]->level == ($data_final_row[0]->level - 1)) {
                                return $row;
                            }
                        })->first()
                    ];

                    if (! @$tmp_array[0]) {
                        continue;
                    }

                    $tmp_array[0]->first()->code = "Total {$tmp_array[0]->first()->name}";
                    $tmp_array[0]->first()->name = "";
                    $tmp_array[0]->first()->description = "Header total";

                    $data_final->splice($data_final_index-1, 0, $tmp_array);
                }
            }
        }

        $data_final->transform(function($row) {
            foreach ($row as $row_data) {
                if ($row_data->description == 'Header') {
                    $row_data->code = $row_data->name;
                    $row_data->name = null;
                }
            }
            
            return $row;
        });

		$data = [
            'controller' => new Controller(),
			'data' => $data_final,
			'total_data' => $total_data,
			'total_beginning' => $total_beginning,
			'total_debit' => $total_debit,
			'total_credit' => $total_credit,
			'total_period' => $total_period,
			'total_ending' => $total_ending,
			'startDate' => $beginDate,
			'finishDate' => $endingDate,
        ];

        // return view('trialbalanceview::export', $data);
		return Excel::download(new TBExport($data), 'TB.xlsx');
	}
}
