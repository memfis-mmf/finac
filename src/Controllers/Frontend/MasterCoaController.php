<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use memfisfa\Finac\Model\Coa;
use App\Models\Type;
use Carbon\Carbon;
use DB;
use Auth;
use DataTables;

class MasterCoaController extends Controller
{
    public function index()
    {
        return view('mastercoaview::index');
    }

    public function create()
    {
        return view('mastercoaview::create');
    }

    public function store(Request $request)
    {
        $coa = Coa::create($request->all());
        return response()->json($coa);
    }

    public function edit(Request $request)
    {
        return view('mastercoaview::edit');
    }

    public function update(Request $request)
    {
		$coa_tmp = Coa::where('uuid', $request->coa);
		$coa = $coa_tmp->first();

		$request->request->add([
			'warrantystart' => $this->convertDate(
				$request->daterange_master_coa
			)[0],
			'warrantyend' => $this->convertDate(
				$request->daterange_master_coa
			)[1],
		]);

		$list = [
			'name',
			'description',
			'manufacturername',
			'productiondate',
			'brandname',
			'modeltype',
			'location',
			'serialno',
			'company_department',
			'grnno',
			'pono',
			'supplier',
			'povalue',
			'salvagevalue',
			'usefullife',
			'coaacumulated',
			'coaexpense',
			'warrantystart',
			'warrantyend',
		];

        $coa_tmp->update($request->only($list));

        return response()->json($coa);
    }

    public function destroy(Coa $coa)
    {
        $coa->delete();

        return response()->json($coa);
    }

    public function api()
    {
        $coadata = Coa::all();

        return json_encode($coadata);
    }

    public function apidetail(Coa $coa)
    {
        return response()->json($coa);
	}
	
	public function coaDatatables(Request $request)
	{
		$data = Coa::withTrashed();

		return DataTables::of($data)
		->addColumn('status', function(Coa $coa) use ($request) {

			$checked = 'checked';

			if (!$coa->active) {
				$checked = '';
			}
			
			// make switch
			$html = '
				<div>
					<span class="m-switch 
							m-switch--outline 
							m-switch--icon
							m-switch--md">
						<label>
							<input type="checkbox" '.$checked.' id="switch_coa">
							<span></span>
						</label>
					</span>

				</div>
			';

			return $html;
		})
		->escapeColumns([])->make(true);
	}

	// I don't know if this function is used or not, 
	// but I'm afraid to delete it, just leave it
    public function datatables()
    {
		$data = $alldata = json_decode(Coa::with([
			'type',
			'type.coa',
			'coa_accumulate',
			'coa_expense',
		])->get());

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

	public function autoJournalDepreciation(Request $request)
	{
		$coa = Coa::where('approve', 1)->get();

		DB::beginTransaction();

		for ($index_coa=0; $index_coa < $coa; $index_coa++) {
			$arr = $coa[$index_coa];

			$date_approve = $arr->approvals->first()
			->created_at->toDateTimeString();

			$depreciationStart = new Carbon($date_approve);
			$depreciationEnd = $depreciationStart->addMonths($arr->usefullife);

			$day = $depreciationEnd->diff($depreciationStart)->days;

			$value_per_day = ($arr->povalue - $arr->salvagevalue) / $day;

			$last_day_this_month = new Carbon('last day of this month');
			$first_day_this_month = new Carbon('first day of this month');

			if (Carbon::now() != $depreciationEnd) {
				if (Carbon::now() == $last_day_this_month) {
					$this->scheduledJournal($arr, $value_per_day);
				}
			}else{
				$value_last_count = $depreciationEnd
				->diff($first_day_this_month)
				->days * $value_per_day;

				$this->scheduledJournal($arr, $value_last_count);
			}
		}

		DB::commit();
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

	public function getSubaccount(Request $request)
	{
		$coas = Type::where(
			'name',
			strtoupper($request->coa_type)
		)->first()
		->coas()
		->where('description', $request->group)
		->get();

		foreach ($coas as $key) {
			if (strlen($key->coa_number) > 2) {
				$data[] = json_decode($key);
			}
		}

		dd($data);

	}
}
