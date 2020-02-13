<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use memfisfa\Finac\Model\Cashbook;
use memfisfa\Finac\Model\TrxJournal;
use App\Models\Approval;
use App\Models\Department;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use DB;

class CashbookController extends Controller
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
		$data['cashbook_ref'] = Cashbook::where('approve', 1)->get();
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
		$request->request->add([
			'transactionnumber' => Cashbook::generateCode(
				$this->transactionnumber($request->cashbook_type)
			)
		]);

        $cashbook = Cashbook::create($request->all());
        return response()->json($cashbook);
    }

    public function edit(Cashbook $cashbook)
    {
		$data['cashbook'] = $cashbook;
		$data['cashbook_ref'] = Cashbook::where('approve', 1)->get();
		$data['department'] = Department::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full_name'
		)->whereIn('code',['idr','usd'])
		->get();

		return view('cashbooknewview::edit', $data);
    }

    public function update(Request $request, Cashbook $cashbook)
    {
        $cashbook->update($request->all());

        return response()->json($cashbook);
    }

    public function destroy(Cashbook $cashbook)
    {
        $cashbook->delete();

        return response()->json($cashbook);
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
        $cashbookdata = Cashbook::all();

        return json_encode($cashbookdata);
    }

    public function apidetail(Cashbook $cashbook)
    {
        return response()->json($cashbook);
    }

    public function datatables()
    {
		$data = $alldata = json_decode(
			Cashbook::with([
				'cashbook_a',
				'currencies',
			])->orderBy('id', 'desc')->get()
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
        $cashbook  = Cashbook::where('description', '!=', 'Header')->get();


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

	public function approve(Request $request)
	{
		DB::beginTransaction();
		try {
			$cashbook_tmp = Cashbook::where('uuid', $request->uuid);
			$cashbook = $cashbook_tmp->first();

	        $cashbook->approvals()->save(new Approval([
	            'approvable_id' => $cashbook->id,
	            'is_approved' => 0,
	            'conducted_by' => Auth::id(),
	        ]));

			$cashbook_a = $cashbook->cashbook_a;

			$date_approve = $cashbook->approvals->first()
			->created_at->toDateTimeString();

			$header = (object) [
				'voucher_no' => $cashbook->transactionnumber,
				'transaction_date' => $date_approve,
				'coa' => $cashbook->coa->id,
			];

			$total_debit = 0;
			$total_credit = 0;

			for (
				$index_cashbook_a=0;
				$index_cashbook_a < count($cashbook_a);
				$index_cashbook_a++
			) {
				$arr = $cashbook_a[$index_cashbook_a];

				$detail[] = (object) [
					'coa_detail' => $arr->coa->id,
					'credit' => $arr->credit * $cashbook->exchangerate,
					'debit' => $arr->debit * $cashbook->exchangerate,
					'_desc' => 'invoice',
				];

				$total_debit += $detail[count($detail)-1]->debit;
				$total_credit += $detail[count($detail)-1]->credit;
			}

			if (strpos($cashbook->transactionnumber, 'PJ') !== false) {
				$type = 'pj';
				$total = $total_debit - $total_credit;
				$positiion = 'credit';
				$x_positiion = 'debit';
			}

			if (strpos($cashbook->transactionnumber, 'RJ') !== false) {
				$type = 'rj';
				$total = $total_credit - $total_debit;
				$positiion = 'debit';
				$x_positiion = 'credit';
			}

			// add object in first array $detai
			array_unshift(
				$detail,
				(object) [
					'coa_detail' => $header->coa,
					$x_positiion => 0,
					$positiion => $total,
					'_desc' => 'coa header',
				]
			);

			// $total_debit += $detail[0]->debit;
			// $total_credit += $detail[0]->credit;

			$cashbook_tmp->update([
				'approve' => 1
			]);

			$journal_number_prefix = explode(
				'-',
				$cashbook->transactionnumber
			)[0];

			$autoJournal = TrxJournal::autoJournal(
				$header,
				$detail,
				$journal_number_prefix,
				substr($journal_number_prefix, 1, 3)
			);

			if ($autoJournal['status']) {
				DB::commit();
			}else{
				DB::rollBack();
				return response()->json([
					'errors' => $autoJournal['message']
				]);
			}

	        return response()->json($cashbook);
		} catch (\Exception $e) {

			DB::rollBack();

			$data['errors'] = $e->getMessage();

			return response()->json($data);
		}

	}

	public function getRef(Request $request)
	{
		$cashbook = Cashbook::where(
			'transactionnumber',
			$request->transactionnumber
		)->first();

		if (!$cashbook) {
			return [
				'errors' => 'Data not found'
			];
		}

		unset($cashbook->cashbook_ref);

		return $cashbook;
	}

	public function print(Request $request)
	{
		$cashbook = Cashbook::where('uuid', $request->uuid)->first();
		$cashbook_a = $cashbook->cashbook_a;

		$total_debit = 0;
		$total_credit = 0;

		for (
			$index_cashbook_a=0;
			$index_cashbook_a < count($cashbook_a);
			$index_cashbook_a++
		) {
			$arr = $cashbook_a[$index_cashbook_a];

			$detail[] = (object) [
				'coa_detail' => $arr->coa->code,
				'coa_name' => $arr->coa->name,
				'credit' => $arr->credit * $cashbook->exchangerate,
				'debit' => $arr->debit * $cashbook->exchangerate,
				'symbol' => $cashbook->currencies->symbol,
				'_desc' => $arr->description,
			];

			$total_debit += $detail[count($detail)-1]->debit;
			$total_credit += $detail[count($detail)-1]->credit;
		}

		if (strpos($cashbook->transactionnumber, 'PJ') !== false) {
			$type = 'pj';
			$total = $total_debit - $total_credit;
			$total_all = $total_debit;
			$positiion = 'credit';
			$x_positiion = 'debit';
		}

		if (strpos($cashbook->transactionnumber, 'RJ') !== false) {
			$type = 'rj';
			$total = $total_credit - $total_debit;
			$total_all = $total_credit;
			$positiion = 'debit';
			$x_positiion = 'credit';
		}

		// add object in first array $detai
		array_unshift(
			$detail,
			(object) [
				'coa_detail' => $cashbook->coa->code,
				'coa_name' => $cashbook->coa->name,
				$x_positiion => 0,
				$positiion => $total,
				'_desc' => $cashbook->description,
				'symbol' => $cashbook->currencies->symbol,
			]
		);

		$data = [
			'cashbook' => $cashbook,
			'detail' => $detail,
			'total' => $total_all,
			'type' => $type,
		];

        $pdf = \PDF::loadView('formview::cashbook', $data);
        return $pdf->stream();
	}
}
