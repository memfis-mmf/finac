<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use memfisfa\Finac\Model\Cashbook;
use memfisfa\Finac\Model\TrxJournal;
use App\Models\Approval;
use App\Models\Department;
use App\Models\Currency;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

//use for export
use memfisfa\Finac\Model\Exports\CashbookExport;
use Maatwebsite\Excel\Facades\Excel;

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
        return view('cashbooknewview::create');
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
				$result = '';
				break;
		}

		return $result;
	}


    public function store(Request $request)
    {
        $request->validate([
            'cashbook_type' => 'required',
            'transactiondate' => 'required',
            'personal' => 'required',
            'refno' => 'required',
            'currency' => 'required',
            'accountcode' => 'required',
            'exchangerate' => 'required'
        ]);

        // jika multi currency dicentang maka second currency nya required
        if ($request->multy_currency) {
            $request->validate([
                'second_currency' => 'required',
            ]);

            if ($request->currency == $request->second_currency) {
                return response([
                    'errors' => 'Currency and Second Currency cannot be the same'
                ]);
            }
        }

		$request->merge([
			'transactionnumber' => Cashbook::generateCode(
                    $this->transactionnumber($request->cashbook_type)
                ),
            'transactiondate' => Carbon::createFromFormat('d-m-Y', $request->transactiondate)
		]);

        $cashbook = Cashbook::create($request->all());
        return response()->json($cashbook);
    }

    public function edit(Cashbook $cashbook)
    {
        if ($cashbook->approve) {
            return abort(404);
        }

		$data['cashbook'] = $cashbook;
		$data['department'] = Department::all();
		$data['cashbook_ref'] = Cashbook::where('approve', 1)->get();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full'
		)->whereIn('code',['idr','usd'])
		->get();

		return view('cashbooknewview::edit', $data);
    }

    public function update(Request $request, Cashbook $cashbook)
    {
        if ($cashbook->approve) {
            return abort(404);
        }

        $request->validate([
            'transactiondate' => 'required',
            'personal' => 'required',
            'refno' => 'required',
            'accountcode' => 'required',
            'exchangerate' => 'required'
        ]);

        if ($request->currency == 'idr') {
            $request->merge([
                'exchangerate' => 1
            ]);
        }

        $request->merge([
            'transactiondate' => Carbon::createFromFormat('d-m-Y', $request->transactiondate)
        ]);

        $cashbook->update($request->except([
            'cashbook_type',
            'cashbook_ref',
            'currency',
            'second_currency',
        ]));

        return response()->json($cashbook);
    }

    public function destroy(Cashbook $cashbook)
    {
        if ($cashbook->approve) {
            return abort(404);
        }

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

    public function show($uuid_cashbook)
    {
        $cashbook = Cashbook::where('uuid', $uuid_cashbook)->firstOrFail();

		$data['cashbook'] = $cashbook;
		$data['cashbook_ref'] = Cashbook::where('approve', 1)->get();
		$data['department'] = Department::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full'
		)->whereIn('code',['idr','usd'])
        ->get();
        $data['page_type'] = 'show';

		return view('cashbooknewview::show', $data);
    }

    public function datatables(Request $request)
    {
		$data  = Cashbook::with([
                'cashbook_a',
                'currencies',
                'journal',
            ])
            ->select('cashbooks.*');

        if ($request->status and $request->status != 'all') {

            $status = [
                'open' => 0,
                'approved' => 1,
            ];

            $data = $data->where('approve', $status[$request->status]);
        }

        return datatables($data)
            ->filterColumn('transactiondate', function($query, $search) {
                datatables_search_date('transactiondate', $search, $query);
            })
            ->filterColumn('approved_by', function($query, $search) {
                datatables_search_approved_by($search, $query);
            })
            ->filterColumn('created_by', function($query, $search) {
                datatables_search_audits($search, $query);
            })
            ->filterColumn('updated_by', function($query, $search) {
                datatables_search_audits($search, $query);
            })
            ->addColumn('transactiondate_formated', function($row) {
                return $row->transactiondate->format('d-m-Y');
            })
            ->addColumn('transactionnumber_link', function($row) {
                return "<a href='".route('cashbook.show', $row->uuid)."'>$row->transactionnumber</a>";
            })
            ->addColumn('journal_number', function($row) {
                $journal = $row->journal;

                if ($journal) {
                    return "<a href='".route('journal.print')."?uuid=$journal->uuid'>$journal->voucher_no</a>";
                }

                return '-';
            })
            ->addColumn('approved_by', function($row) {
                return $row->approved_by;
            })
            ->addColumn('created_by', function($row) {
                return $row->created_by;
            })
            ->addColumn('cashbook_type', function($row) {
                return $row->cashbook_type;
            })
            ->addColumn('account_name', function($row) {
                return $row->account_name;
            })
            ->addColumn('status', function($row) {
                return $row->status;
            })
            ->addColumn('can_approve_fa', function($row) {
                return $this->canApproveFa();
            })
            ->addColumn('export_url', function($row) {
                return route('cashbook.export')."?uuid={$row->uuid}";
            })
            ->escapeColumns([])
            ->make(true);
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

            if (count($cashbook_a) < 1) {
				return response()->json([
					'errors' => 'Please add detail first'
				]);
            }

			$header = (object) [
				'voucher_no' => $cashbook->transactionnumber,
				// 'transaction_date' => $date_approve,
				'transaction_date' => $cashbook->transactiondate,
				'coa' => $cashbook->coa->id,
			];

            // if ($cashbook->currencies->code == 'idr') {
            //     $cashbook->exchangerate = 1;
            // }

			$total_debit = 0;
            $total_credit = 0;

            $detail = [];

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
                    '_desc' => $arr->description,
                    'id_project' => $arr->id_project
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

            if (count($detail) < 1) {
				return response()->json([
					'errors' => 'Cashbook is empty'
				]);
            }

			// add object in first array $detai
			array_unshift(
				$detail,
				(object) [
					'coa_detail' => $header->coa,
					$x_positiion => 0,
					$positiion => $total,
                    '_desc' => $cashbook->description,
				]
			);

			// $total_debit += $detail[0]->debit;
			// $total_credit += $detail[0]->credit;

			$cashbook_tmp->update([
				'approve' => 1
            ]);

			$journal_number_prefix = 'J'.substr($cashbook->transactionnumber, 1, 3);

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
            )
            ->where('approve', true)
            ->first();

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

        if (count($cashbook_a) < 1) {
            return redirect()->route('cashbook.index');
        }


		$total_second_debit = 0;
		$total_second_credit = 0;

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
				'credit' => $arr->credit,
				'second_credit' => $arr->second_credit,
				'debit' => $arr->debit,
				'second_debit' => $arr->second_debit,
				'symbol' => $cashbook->currencies->symbol,
				'_desc' => $arr->description,
			];

			$total_second_debit += $detail[count($detail)-1]->second_debit;
			$total_second_credit += $detail[count($detail)-1]->second_credit;

			$total_debit += $detail[count($detail)-1]->debit;
			$total_credit += $detail[count($detail)-1]->credit;
		}

		if (strpos($cashbook->transactionnumber, 'PJ') !== false) {
			$type = 'pj';
			$total = $total_debit - $total_credit;
			$second_total = $total_second_debit - $total_second_credit;
			$second_subtotal = $total_second_debit;
			$positiion = 'credit';
			$x_positiion = 'debit';
		}

		if (strpos($cashbook->transactionnumber, 'RJ') !== false) {
			$type = 'rj';
			$total = $total_credit - $total_debit;
			$second_total = $total_second_credit - $total_second_debit;
			$second_subtotal = $total_second_credit;
			$positiion = 'debit';
			$x_positiion = 'credit';
        }

        if (Str::contains(strtolower($cashbook->transactionnumber), ['cp'])) {
            $type_header = 'Cash Payment';
        }

        if (Str::contains(strtolower($cashbook->transactionnumber), ['cr'])) {
            $type_header = 'Cash Received';
        }

        if (Str::contains(strtolower($cashbook->transactionnumber), ['br'])) {
            $type_header = 'Bank Received';
        }

        if (Str::contains(strtolower($cashbook->transactionnumber), ['bp'])) {
            $type_header = 'Bank Payment';
        }

		// add object in first array $detai
		array_unshift(
			$detail,
			(object) [
				'coa_detail' => $cashbook->coa->code,
				'coa_name' => $cashbook->coa->name,
                "second_$x_positiion" => 0,
                "second_$positiion" => $second_total,
				$x_positiion => 0,
				$positiion => $total,
				'_desc' => $cashbook->description,
				'symbol' => $cashbook->currencies->symbol,
            ]
        );

        $total_debit += $detail[0]->debit;
        $total_credit += $detail[0]->credit;

        $cashbook->second_subtotal = $second_subtotal;

		$data = [
			'cashbook' => $cashbook,
            'detail' => $detail,
			'total_debit' => $total_debit,
			'total_credit' => $total_credit,
			'type' => $type,
			'type_header' => $type_header,
            'carbon' => Carbon::class,
            'controller' => new Controller()
        ];

        $pdf = PDF::loadView('formview::cashbook', $data);
        return $pdf->stream();
    }

    public function select2Ref(Request $request)
    {
        $cashbook = Cashbook::where('approve', true)
            ->where('transactionnumber', 'like', "%$request->q%")
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();

        $data['results'] = [];

        foreach ($cashbook as $cashbook_row) {
            $data['results'][] = [
                'id' => $cashbook_row->transactionnumber,
                'text' => $cashbook_row->transactionnumber,
            ];
        }

        return $data;
    }

    public function export(Request $request)
    {
        $cashbook = Cashbook::query();

        if ($request->uuid) {
            $cashbook = $cashbook->where('uuid', $request->uuid);
        }

        $cashbook = $cashbook->get();

        $data = [
            'controller' => new Controller(),
            'cashbook' => $cashbook
        ];

        $prefix = 'All';
        if ($request->uuid) {
            $prefix = str_replace('/', '-', $cashbook->first()->transactionnumber);
        }

        $now = Carbon::now()->format('d-m-Y');
        $name = "Cashbook {$now}";

        $name .= " {$prefix}";

        return Excel::download(new CashbookExport($data), "{$name}.xlsx");
    }
}
