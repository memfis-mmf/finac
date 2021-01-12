<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use memfisfa\Finac\Model\CashbookA;
use memfisfa\Finac\Model\Cashbook;
use memfisfa\Finac\Model\Coa;
use App\Models\Approval;
use App\Models\Department;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use DB;

class CashbookAController extends Controller
{
    public function index()
    {
        return view('cashbooknewview::index');
    }

    public function getData()
    {
		$cashbookType = Type::where('of', 'cashbook')->get();

		$type = [];

		for ($i = 0; $i < count($cashbookType); $i++) {
			$x = $cashbookType[$i];

			$type[$x->id] = $x->name;
		}

        return json_encode($type, JSON_PRETTY_PRINT);
    }

    public function create()
    {
		$data['cashbook_ref'] = CashbookA::where('approve', 1)->get();
        return view('cashbooknewview::create', $data);
    }

	public function transactionNumber($value)
	{

		switch ($value) {
			case 'bp':
				$result = 'CBPJ';
				break;

			case 'br':
				$result = 'CBRJ';
				break;

			case 'cp':
				$result = 'CCPJ';
				break;

			case 'cr':
				$result = 'CCRJ';
				break;

			default:
				'';
				break;
		}

		return $result;
	}


    public function store(Request $request)
    {
		if (strpos($request->transactionnumber, 'PJ') !== false) {
			$request->request->add([
				'debit' => $request->amount_a,
				'credit' => 0,
			]);
		}

		if (strpos($request->transactionnumber, 'RJ') !== false) {
			$request->request->add([
				'debit' => 0,
				'credit' => $request->amount_a,
			]);
		}

		$coa = Coa::where('code', $request->code_a)->first();

		$request->request->add([
			'code' => $coa->code,
			'name' => $coa->name,
		]);

		$request->request->add([
			'description' => $request->description_a
		]);

		DB::beginTransaction();

        $cashbook = CashbookA::create($request->all());

		$cashbook_a = CashbookA::where(
			'transactionnumber',
			$request->transactionnumber
		)->get();

        $total = $this->sumTotal($request->transactionnumber);

		Cashbook::where('transactionnumber', $request->transactionnumber)
		->update([
			'totaltransaction' => $total
		]);

		DB::commit();
        return response()->json($cashbook);
    }

    public function storeAdj(Request $request)
    {
		$coa = Coa::where('code', $request->code_b)->first();

		$request->merge([
			'code' => $coa->code,
			'name' => $coa->name,
			'description' => $request->description_b,
			'debit' => $request->debit_b ?? 0,
			'credit' => $request->credit_b ?? 0,
        ]);
        
        if ($request->debit_b != 0 and $request->credit_b != 0) {
            return [
                'errors' => 'Debit and Credit cannot be filled in at the same time'
            ];
        }

        if ($request->debit_b == 0 and $request->credit_b == 0) {
            return [
                'errors' => 'Please fill in either a Debit or a Credit'
            ];
        }

		DB::beginTransaction();

        $cashbook = CashbookA::create($request->all());

        $total = $this->sumTotal($request->transactionnumber);

		Cashbook::where('transactionnumber', $request->transactionnumber)
		->update([
			'totaltransaction' => $total
		]);

		DB::commit();
        return response()->json($cashbook);
    }

    public function updateAdj(Request $request)
    {

		$request_data = [
			'description' => $request->description_b,
			'debit' => $request->debit_b,
			'credit' => $request->credit_b,
		];

		DB::beginTransaction();

        $cashbook = CashbookA::where('uuid', $request->uuid)->update($request_data);

        $total = $this->sumTotal($request->transactionnumber);

		Cashbook::where('transactionnumber', $request->transactionnumber)
		->update([
			'totaltransaction' => $total
		]);

		DB::commit();
        return response()->json($cashbook);
    }

    public function edit(CashbookA $cashbook)
    {
		$data['cashbook'] = $cashbook;
		$data['department'] = Department::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full'
		)->whereIn('code',['idr','usd'])
		->get();

		return view('cashbooknewview::edit', $data);
    }

	public function sumTotal($transactionnumber)
	{
		$cashbook_a = CashbookA::where(
			'transactionnumber',
			$transactionnumber
        )->get();

        if (count($cashbook_a) < 1) {
            return 0;
        }

        $cashbook = $cashbook_a[0]->cashbook;

        $total_debit = 0;
        $total_credit = 0;

        foreach ($cashbook->cashbook_a as $item) {
            $total_debit += $item->debit;
            $total_credit += $item->credit;
        }

        if (strpos($cashbook->transactionnumber, 'PJ') !== false) {
            $total_all = $total_debit;
        }

        if (strpos($cashbook->transactionnumber, 'RJ') !== false) {
            $total_all = $total_credit;
        }

        return $total_all;
	}

    public function update(Request $request)
    {
		if (strpos($request->transactionnumber, 'PJ') !== false) {
			$request->request->add([
				'debit' => $request->amount_a,
				'credit' => 0,
			]);
			$type = 'pj';
		}

		if (strpos($request->transactionnumber, 'RJ') !== false) {
			$request->request->add([
				'debit' => 0,
				'credit' => $request->amount_a,
			]);
			$type = 'rj';
		}

		DB::beginTransaction();

		$coa = Coa::where('code', $request->account_code_a)->first();

		$cashbook_a_tmp = CashbookA::where('uuid', $request->uuid);

		$request->request->add([
			'description' => $request->description_a
		]);

		$cashbook_a_update = $cashbook_a_tmp->update($request->only([
			'debit',
			'credit',
			'description',
		]));

        $total = $this->sumTotal($cashbook_a_tmp->first()->transactionnumber);

		Cashbook::where('transactionnumber', $cashbook_a_tmp->first()->transactionnumber)
		->update([
			'totaltransaction' => $total
		]);

		DB::commit();

        return response()->json($cashbook_a_update);
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

		$transactionnumber = CashbookA::where('uuid', $request->cashbooka)
		->first()->transactionnumber;

		if (strpos($transactionnumber, 'PJ') !== false) {
			$request->request->add([
				'debit' => $request->amount_a,
				'credit' => 0,
			]);
			$type = 'pj';
		}

		if (strpos($transactionnumber, 'RJ') !== false) {
			$request->request->add([
				'debit' => 0,
				'credit' => $request->amount_a,
			]);
		}

        $cashbook_a_delete = CashbookA::where('uuid', $request->cashbooka)
        ->delete();

        $total = $this->sumTotal($transactionnumber);

		Cashbook::where('transactionnumber', $transactionnumber)
		->update([
			'totaltransaction' => $total
		]);

		DB::commit();

        return response()->json($cashbook_a_delete);
    }

    public function getType($id)
    {
        if ($id == 1) {
            $type = [
                'id' => 1,
                'name' => 'AKTIVA',
            ];
            return json_encode($type, JSON_PRETTY_PRINT);
        } elseif ($id == 2) {
            $type = [
                'id' => 2,
                'name' => 'PASIVA',
            ];
            return json_encode($type, JSON_PRETTY_PRINT);
        } elseif ($id == 3) {
            $type = [
                'id' => 3,
                'name' => 'EKUITAS',
            ];
            return json_encode($type, JSON_PRETTY_PRINT);
        } elseif ($id == 4) {
            $type = [
                'id' => 4,
                'name' => 'PENDAPATAN',
            ];
            return json_encode($type, JSON_PRETTY_PRINT);
        } elseif ($id == 5) {
            $type = [
                'id' => 5,
                'name' => 'BIAYA',
            ];
            return json_encode($type, JSON_PRETTY_PRINT);
        }
    }

    public function api()
    {
        $cashbookdata = CashbookA::all();

        return json_encode($cashbookdata);
    }

    public function apidetail(CashbookA $cashbook)
    {
        return response()->json($cashbook);
    }

    public function datatables(Request $request)
    {
		$cashbook = Cashbook::where('uuid', $request->cashbook_uuid)->first();

		$data = $alldata = json_decode(
			CashbookA::where('transactionnumber', $cashbook->transactionnumber)
			->get()
		);

        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $_REQUEST);

        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch'])
            ? $datatable['query']['generalSearch'] : '';

        if (!empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (bool) preg_grep("/$filter/i", (array) $a);
            });

            unset($datatable['query']['generalSearch']);
        }

        $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;

        if (is_array($query)) {
            $query = array_filter($query);

            foreach ($query as $key => $val) {
                $data = $this->list_filter($data, [$key => $val]);
            }
        }

        $sort  = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'RecordID';

        $meta    = [];
        $page    = !empty($datatable['pagination']['page']) ? (int) $datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int) $datatable['pagination']['perpage'] : -1;

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

        if (isset($datatable['requestIds']) && filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) {
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

    public function basicModal()
    {
        function filterArray( $array, $allowed = [] ) {
            return array_filter(
                $array,
                function ( $val, $key ) use ( $allowed ) { // N.b. $val, $key not $key, $val
                    return isset( $allowed[ $key ] ) && ( $allowed[ $key ] === true || $allowed[ $key ] === $val );
                },
                ARRAY_FILTER_USE_BOTH
            );
        }

        function filterKeyword( $data, $search, $field = '' ) {
            $filter = '';
            if ( isset( $search['value'] ) ) {
                $filter = $search['value'];
            }
            if ( ! empty( $filter ) ) {
                if ( ! empty( $field ) ) {
                    if ( strpos( strtolower( $field ), 'date' ) !== false ) {
                        // filter by date range
                        $data = filterByDateRange( $data, $filter, $field );
                    } else {
                        // filter by column
                        $data = array_filter( $data, function ( $a ) use ( $field, $filter ) {
                            return (boolean) preg_match( "/$filter/i", $a[ $field ] );
                        } );
                    }

                } else {
                    // general filter
                    $data = array_filter( $data, function ( $a ) use ( $filter ) {
                        return (boolean) preg_grep( "/$filter/i", (array) $a );
                    } );
                }
            }

            return $data;
        }

        function filterByDateRange( $data, $filter, $field ) {
            // filter by range
            if ( ! empty( $range = array_filter( explode( '|', $filter ) ) ) ) {
                $filter = $range;
            }

            if ( is_array( $filter ) ) {
                foreach ( $filter as &$date ) {
                    // hardcoded date format
                    $date = date_create_from_format( 'm/d/Y', stripcslashes( $date ) );
                }
                // filter by date range
                $data = array_filter( $data, function ( $a ) use ( $field, $filter ) {
                    // hardcoded date format
                    $current = date_create_from_format( 'm/d/Y', $a[ $field ] );
                    $from    = $filter[0];
                    $to      = $filter[1];
                    if ( $from <= $current && $to >= $current ) {
                        return true;
                    }

                    return false;
                } );
            }

            return $data;
        }

        $columnsDefault = [
            'name'     => true,
            'id' => true,
            'code'     => true,
            'type'  => true,
            'description' => true,
            'uuid'      => true,
            'Actions'      => true,
        ];

        if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
            $columnsDefault = [];
            foreach ( $_REQUEST['columnsDef'] as $field ) {
                $columnsDefault[ $field ] = true;
            }
        }

        // get all raw data
        $cashbook  = CashbookA::where('description', '!=', 'Header')->get();


        $alldata = json_decode( $cashbook, true);

        $data = [];
        // internal use; filter selected columns only from raw data
        foreach ( $alldata as $d ) {
            $data[] = filterArray( $d, $columnsDefault );
        }

        // count data
        $totalRecords = $totalDisplay = count( $data );

        // filter by general search keyword
        if ( isset( $_REQUEST['search'] ) ) {
            $data         = filterKeyword( $data, $_REQUEST['search'] );
            $totalDisplay = count( $data );
        }

        if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
            foreach ( $_REQUEST['columns'] as $column ) {
                if ( isset( $column['search'] ) ) {
                    $data         = filterKeyword( $data, $column['search'], $column['data'] );
                    $totalDisplay = count( $data );
                }
            }
        }

        // sort
        if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
            $column = $_REQUEST['order'][0]['column'];
            $dir    = $_REQUEST['order'][0]['dir'];
            usort( $data, function ( $a, $b ) use ( $column, $dir ) {
                $a = array_slice( $a, $column, 1 );
                $b = array_slice( $b, $column, 1 );
                $a = array_pop( $a );
                $b = array_pop( $b );

                if ( $dir === 'asc' ) {
                    return $a > $b ? true : false;
                }

                return $a < $b ? true : false;
            } );
        }

        // pagination length
        if ( isset( $_REQUEST['length'] ) ) {
            $data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
        }

        // return array values only without the keys
        if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
            $tmp  = $data;
            $data = [];
            foreach ( $tmp as $d ) {
                $data[] = array_values( $d );
            }
        }

        $secho = 0;
        if ( isset( $_REQUEST['sEcho'] ) ) {
            $secho = intval( $_REQUEST['sEcho'] );
        }

        $result = [
            'iTotalRecords'        => $totalRecords,
            'iTotalDisplayRecords' => $totalDisplay,
            'sEcho'                => $secho,
            'sColumns'             => '',
            'aaData'               => $data,
        ];

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

        echo json_encode( $result, JSON_PRETTY_PRINT );
    }
}
