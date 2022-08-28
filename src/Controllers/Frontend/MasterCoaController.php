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

//use for export
use memfisfa\Finac\Model\Exports\CoaExport;
use Maatwebsite\Excel\Facades\Excel;

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
		$request->validate([
			'account_type' => 'required',
			'account_group' => 'required',
			'sub_account' => 'required',
			'account_no' => 'required',
			'account_name' => 'required',
		]);

        $check_coa_exist = Coa::where('code', $request->account_no)
            ->first();

        if ($check_coa_exist) {
            return [
                'status' => false,
                'message' => 'Account Number Duplicate',
                'errors' => 'Account Number Duplicate'
            ];
        }

		$data = [
			'code' => $request->account_no,
			'name' => $request->account_name,
			'type_id' => Type::where(
				'code', strtolower($request->account_type))->first()->id,
			'description' => $request->account_group
		];
			
		$coa = Coa::create($data);
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

		$request->merge([
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
			'coadepreciation',
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
	
	public function switchCoa(Request $request)
	{
		$coa = Coa::where('uuid', $request->master_coa);

		// jika coa active
		if ($coa->first()) {
			$coa->delete();
		}else{
			$coa->withTrashed()->first()->restore();
		}

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
		$data = Coa::withTrashed()
            ->with(['type'])
            ->select('coas.*');

        if ($request->status == 'active') {
            $data = $data->whereNull('deleted_at');
        }

        if ($request->status == 'non-active') {
            $data = $data->whereNotNull('deleted_at');
        }

		return datatables()->of($data)
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
                                <input type="checkbox" 
                                '.$checked.' 
                                id="coa_switch" data-uuid="'.$coa->uuid.'">
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
			'coa_depreciation',
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

	public function DepreciationPerDay(Request $request)
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
		->where('description', 'header')
		->orderBy('code', 'asc')
		->get();

		$data = [];

		foreach ($coas as $key => $item) {
			$level = strlen($item->coa_number);

			// remove coa who have 2 digit
			if ($level == 2) {
				continue;
			}

			$data[$key] = [
				'id' => $item->uuid,
				'html' => $item->coa_tree,
				'title' => $item->code.' - '.$item->name,
				'text' => $item->code.' - '.$item->name,
			];

			// if ($level == 6 && strtolower($request->group) == 'header') {
			// 	$data[$key]['disabled'] = true;
			// }

			// if ($level == 2 && strtolower($request->group) == 'detail') {
			// 	$data[$key]['disabled'] = true;
			// }
		}

		array_unshift($data, [
			'id' => '',
			'html' => '-- Select --',
			'text' => '',
		]);

		return array_values($data);
	}

	public function generateNewCoa(Request $request)
	{
		$request->validate([
			'account_type' => 'required',
			'account_group' => 'required',
			'sub_account' => 'required',
		]);

		$coa = Coa::where('uuid', $request->sub_account)->first();

		// 8 is total digit coa
		$total_zero = 8 - strlen($coa->coa_number);
		$zero = '';

		for ($i=0; $i < $total_zero; $i++) { 
			$zero .= 0;
		}

		// if user add new coa header
		if (strtolower($request->account_group) == 'header') {

			$coa_header = Coa::where(
				// substr_replace() remove last character
				'code', 
				'like', 
				substr_replace($coa->coa_number, "", -1).'%'.$zero
			)
			->where('description', 'Header')
			->orderBy('code', 'desc')
			->first();

			// substr() get last character
			$last_character_code = substr($coa_header->coa_number, -1);

			// if coa header 9 is exist
			if ($last_character_code == 9) {
				return [
					'errors' => 'You cannot add more header'
				];
			}

			$new_coa = ($coa_header->coa_number+1).$zero;
		}

		// if user add new coa detail
		if (strtolower($request->account_group) == 'detail') {
			// get last coa detail from coa header who sended from request
			$query = Coa::where('description', 'Detail')
			->orderBy('code', 'desc')
			->first();

			// get level of coa header who requested from web
			$coa_level = strlen($coa->coa_number);

			if ($coa_level == 4) {
				$max_code = 9;
				$query = $query->where('code', 'like', $coa->coa_number.'000%');
			}

			if ($coa_level == 5) {
				$max_code = 999;
				$query = $query->where('code', 'like', $coa->coa_number.'%');
			}

			if ($coa_level == 6) {
				$max_code = 99;
				$query = $query->where('code', 'like', $coa->coa_number.'%');
			}

			$coa_detail = $query->orderBy('code', 'desc')->first();

			if ($coa_detail) {
				$last_character_code = substr($coa_detail->code, -2);

				if ((int)$last_character_code == $max_code) {
					return [
						'errors' => 'You cannot add more detail in coa '.$coa->code
					];
				}

				$code = (int)$coa_detail->code + 1;
			}else{ // if coa detail doesn't exist
				$code = $coa->coa_number.substr_replace($zero, "", -1).'1';
			}

			$new_coa = $code;
		}

		return $new_coa;
    }
    
    public function export(Request $request)
    {
        $query = Coa::orderBy('code', 'asc')->withTrashed();

        if ($request->uuid) {
            $query = $query->where('uuid', $request->uuid);
        }

        $coa = $query->get();

        $data = [
            'datas' => $coa
        ];

        $name = 'Chart Of Account';
        
        if ($request->uuid) {
            $name .= '-'.$coa->code;
        }

        return Excel::download(new CoaExport($data), $name.'.xlsx');
    }
}