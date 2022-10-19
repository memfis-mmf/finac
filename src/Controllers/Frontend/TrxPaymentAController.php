<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\TrxPaymentA as TrxPaymentA;
use memfisfa\Finac\Request\TrxPaymentAUpdate;
use memfisfa\Finac\Request\TrxPaymentAStore;
use App\Http\Controllers\Controller;
use memfisfa\Finac\Model\TrxPayment;

class TrxPaymentAController extends Controller
{
    public function index()
    {
        return redirect()->route('trxpaymenta.create');
    }

    public function create()
    {
        return view('trxpaymentaview::index');        
    }

    public function store(TrxPaymentAStore $request)
    {
        $si = TrxPayment::where('transaction_number', $request->transaction_number)
            ->first();
        
        if ($si->approve) {
            return abort(404);
        }

        $trxpaymenta = TrxPaymentA::create($request->all());
        return response()->json($trxpaymenta);
    }

    public function edit(TrxPaymentA $trxpaymenta)
    {
        $si = $trxpaymenta->si;
        if ($si->approve) {
            return abort(404);
        }
        return response()->json($trxpaymenta);
    }

    public function update(TrxPaymentAUpdate $request, TrxPaymentA $trxpaymenta)
    {
        $si = $trxpaymenta->si;
        if ($si->approve) {
            return abort(404);
        }

        $trxpaymenta->update($request->all());

        return response()->json($trxpaymenta);
    }

    public function destroy(TrxPaymentA $trxpaymenta)
    {
        $si = $trxpaymenta->si;
        if ($si->approve) {
            return abort(404);
        }

        $trxpaymenta->forceDelete();

        $total = TrxPaymentA::where(
                'transaction_number',
                $si->transaction_number
            )
            ->get()
            ->sum(function($row) {
                return $row->total + ($row->total * ($row->tax_percent / 100));
            });

		if ($si->currency == 'idr') {
			$amount = [
				'grandtotal_foreign' => $total,
				'grandtotal' => $total
			];
		}else{
			$amount = [
				'grandtotal_foreign' => $total,
				'grandtotal' => ($total*$si->exchange_rate)
			];
        }

        $si->update($amount);

        return response()->json($trxpaymenta);
    }

    public function api()
    {
        $trxpaymentadata = TrxPaymentA::all();

        return json_encode($trxpaymentadata);
    }

    public function apidetail(TrxPaymentA $trxpaymenta)
    {
        return response()->json($trxpaymenta);
    }

    public function datatables()
    {
		$data = $alldata = json_decode(
			TrxPaymentA::with([
				'grn'
			])->orderBy('id', 'DESC')
            ->get()
            ->transform(function($row) {
                $row->total_formated = $this->currency_format(memfisRound($row->si->currencies->code, $row->total));
                $row->total_idr_formated = $this->currency_format(memfisRound('idr', $row->total_idr));

                return $row;
            })
		);

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
