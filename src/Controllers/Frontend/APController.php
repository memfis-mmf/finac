<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Auth;
use Illuminate\Http\Request;
use memfisfa\Finac\Model\APayment;
use memfisfa\Finac\Model\APaymentA;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Model\TrxPayment;
use memfisfa\Finac\Request\APaymentUpdate;
use memfisfa\Finac\Request\APaymentStore;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Currency;
use memfisfa\Finac\Model\TrxJournal;
use App\Models\Approval;

class APController extends Controller
{
    public function index()
    {
        return redirect()->route('apayment.create');
    }

    public function create()
    {
        return view('accountpayableview::index');
    }

    public function store(APaymentStore $request)
    {
		$vendor = Vendor::where('id', $request->id_supplier)->first();
		if (!$vendor) {
			return [
				'errors' => 'Supplier not found'
			];
		}

		$request->merge([
			'id_supplier' => $vendor->id
		]);

		$coa = Coa::where('code', $request->accountcode)->first();

		$code = 'CCPJ';

		if (strpos($coa->name, 'Bank') !== false) {
			$code = 'CBPJ';
		}

		$request->request->add([
			'approve' => 0,
			'transactionnumber' => APayment::generateCode($code),
		]);

        $apayment = APayment::create($request->all());
        return response()->json($apayment);
    }

    public function edit(Request $request)
    {
		$data['data'] = APayment::where(
			'uuid', $request->apayment
		)->with([
			'currency',
		])->first();

		//if data already approved
		if ($data['data']->approve) {
			return redirect()->back();
		}

		$data['vendor'] = Vendor::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full_name'
		)->whereIn('code',['idr','usd'])
		->get();

		$data['debt_total_amount'] = TrxPayment::where(
			'id_supplier',
			$data['data']->id_supplier
		)->sum('grandtotal');

		$apayment = APayment::where('id_supplier', $data['data']->id_supplier)
			->get();

		$payment_total_amount = 0;

		for ($i = 0; $i < count($apayment); $i++) {
			$x = $apayment[$i];

			for ($j = 0; $j < count($x->apa); $j++) {
				$y = $x->apa[$j];

				$payment_total_amount += $y->debit;
			}
		}

		$data['payment_total_amount'] = $payment_total_amount;
		$data['debt_balance'] = (
			$data['debt_total_amount'] - $data['payment_total_amount']
		);

        return view('accountpayableview::edit', $data);
    }

    public function update(APaymentUpdate $request, APayment $apayment)
    {
		$request->merge([
			'description' => $request->ap_description
		]);

        $apayment->update($request->all());

        return response()->json($apayment);
    }

    public function destroy(APayment $apayment)
    {
        $apayment->delete();

        return response()->json($apayment);
    }

    public function api()
    {
        $apaymentdata = APayment::all();

        return json_encode($apaymentdata);
    }

    public function apidetail(APayment $apayment)
    {
        return response()->json($apayment);
    }

    public function datatables()
    {
        $data = $alldata = json_decode(APayment::orderBy('id', 'desc')->get());

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

    public function coaDatatables()
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
        $coa  = Coa::where('description', 'Detail')->get();


        $alldata = json_decode( $coa, true);

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

    public function SIModalDatatables(Request $request)
    {
		$ap = APayment::where('uuid', $request->ap_uuid)->first();

		$trxpayment_grn = TrxPayment::where('currency', $ap->currency)
			->where('id_supplier', $request->id_vendor)
			->where('x_type', 'GRN')
			->get();

		$arr = [];
		$index_arr = 0;

		for ($i=0; $i < count($trxpayment_grn); $i++) {
			$x = $trxpayment_grn[$i];

			for ($j=0; $j < count($x->trxpaymenta); $j++) {
				$z = $x->trxpaymenta[$j];

				$arr[$index_arr] = json_decode($x);
				$arr[$index_arr]->transaction_number = $z->grn->number;
				$arr[$index_arr]->uuid = $z->grn->uuid;
				$index_arr++;
			}
		}

		$trxpayment_non_grn = TrxPayment::where('currency', $ap->currency)
			->where('id_supplier', $request->id_vendor)
			->where('x_type', 'NON GRN')
			->get();

        $data = $alldata = array_merge($arr, json_decode($trxpayment_non_grn));

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

    public function approve(Request $request)
    {
		$data = APayment::where('uuid', $request->uuid);

		$AP_header = $data->first();
		$AP_detail = $AP_header->apa;

        $AP_header->approvals()->save(new Approval([
            'approvable_id' => $AP_header->id,
            'conducted_by' => Auth::id(),
            'note' => @$request->note,
            'is_approved' => 1
        ]));

		TrxJournal::insertFromAP($AP_header, $AP_detail);

		$data->update([
			'approve' => 1
		]);

        return response()->json($data->first());
    }

	function print(Request $request)
	{
		$ap = APayment::where('uuid', $request->uuid)->first();
		$apa = $ap->apa()->with([
			'coa'
		])->get();
		$to = $ap->vendor;

		$data = [
			'data' => $ap,
			'apa' => array_chunk(json_decode($apa), 10),
			'to' => $to,
		];

		$pdf = \PDF::loadView('formview::ar-ap', $data);
		return $pdf->stream();
	}

}
