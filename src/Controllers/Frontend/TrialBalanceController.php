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

		$data_final = $this->getData($beginDate, $endingDate);
        $total_beginning = 0;
        $total_debit = 0;
        $total_credit = 0;
        $total_period = 0;
        $total_ending = 0;
        
        foreach ($data_final as $data_final_index => $data_final_row) {
            // calculate period balance
            $data_final_row->period_balance = 
                $data_final_row->Debit - $data_final_row->Credit;

            // calculate every total
            if (strtolower($data_final_row->description) == 'header') {
                $total_beginning += $data_final_row->LastBalance;
                $total_debit += $data_final_row->Debit;
                $total_credit += $data_final_row->Credit;
                $total_period += $data_final_row->period_balance;
            }

            // jika coa tidak ada (bisa aja udah kehapus)
            if (! Coa::where('code', $data_final_row->code)->first()) {
                unset($data_final[$data_final_index]);
                continue;
            }

            $data_final_row->level = Coa::where('code', $data_final_row->code)->first()->coa_number;
            $data_final_row->total_child = Coa::where('code', $data_final_row->code)->first()->total_child;
        }

        $data_final = array_values($data_final);

        $new_data = [];
        $iteration = [];

        foreach ($data_final as $data_final_index => $data_final_row) {

            if ($data_final_row->total_child > 0) {
                $iteration[$data_final_row->level] = [
                    "total_child" => $data_final_row->total_child,
                    "counting" => $data_final_row->total_child,
                    "coa" => $data_final_row->code,
                    "name" => $data_final_row->name,
                ];

                krsort($iteration);
            }

            // insert to new array
            foreach (array_keys((array)$data_final_row) as $data_final_row_index) {
                $new_data_temp[$data_final_row_index] = $data_final_row->$data_final_row_index;
            }
            $new_data[] = (object) $new_data_temp;

            foreach ($iteration as $iteration_index => $iteration_row) {
                if ($iteration_row['counting'] == 0) {
                    $parent_index = $data_final_index - $iteration_row['total_child'];
                    $parent_index = ($parent_index < 0)? 0: $parent_index;
                    $parent_data = $data_final[$parent_index];

                    foreach (array_keys((array)$parent_data) as $parent_data_index) {
                        $new_data_temp[$parent_data_index] = $parent_data->$parent_data_index;
                    }
                    $new_data[] = (object) $new_data_temp;

                    $new_data[count($new_data)-1]->code = 'Total '.$parent_data->name;
                    $new_data[count($new_data)-1]->name = '';
                    $new_data[count($new_data)-1]->description = 'header total';

                    // add new blank row
                    foreach (array_keys((array)$parent_data) as $parent_data_index) {
                        $new_data_temp[$parent_data_index] = ' ';
                    }
                    $new_data[] = (object) $new_data_temp;

                    unset($iteration[$iteration_index]);
                }
            }

            foreach ($iteration as $iteration_index => $iteration_row) {
                $iteration[$iteration_index]['counting'] = $iteration_row['counting'] - 1;
            }
        }

        foreach ($new_data as $new_data_row) {
            if ($new_data_row->description == 'Header') {
                $new_data_row->code = $new_data_row->name;
                $new_data_row->name = null;

                $new_data_row->Debit = '';
                $new_data_row->Credit = '';
                $new_data_row->LastBalance = '';
                $new_data_row->PeriodBalance = '';
                $new_data_row->EndingBalance = '';
            }
        }

		$data = [
            'controller' => $this,
			'data' => $new_data,
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

    public function generate_data_export()
    {
        # code...
    }
}
