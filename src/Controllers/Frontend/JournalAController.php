<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\TrxJournalA as JournalA;
use memfisfa\Finac\Model\TrxJournal as Journal;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Request\JournalAUpdate;
use memfisfa\Finac\Request\JournalAStore;
use App\Http\Controllers\Controller;

class JournalAController extends Controller
{
    public function index()
    {
        return redirect()->route('journala.create');
    }

    public function create()
    {
        return view('journalaview::index');
    }

    public function store(JournalAStore $request)
    {
		$coa = Coa::where('code', $request->account_code)->first();

		$request->merge([
			'account_code' => $coa->id
		]);

        $journala = JournalA::create($request->all());

		$this->updateJournalTotalTransaction($request->voucher_no);

        return response()->json($journala);
    }

    public function edit(Request $request)
    {
		$journala = JournalA::where('uuid', $request->journala)->with([
			'coa',
			'coa.type',
		])->first();

        return response()->json($journala);
    }

    public function update(Request $request)
    {

		$journala = JournalA::where('uuid', $request->uuid)->first();

		$request->request->add([
			'debit' => null,
			'credit' => null,
		]);

		if ($request->methodpayment == 'debet') {
			$method = 'debit';
			$otherMethod = 'credit';
		}else{
			$method = 'credit';
			$otherMethod = 'debit';
		}

		$request->request->add([
			$method => $request->amount,
			$otherMethod => null,
			'description' => $request->remark
		]);

		$journala = JournalA::where('uuid', $request->uuid);

		$journala->update(
			$request->only([
				$method,
				$otherMethod,
				'description',
			])
		);

		$this->updateJournalTotalTransaction($journala->first()->voucher_no);

        return response()->json($journala);
    }

    public function destroy(JournalA $journala)
    {
        $journala->delete();

		$this->updateJournalTotalTransaction($journala->voucher_no);

        return response()->json($journala);
    }

    public function api()
    {
        $journaladata = JournalA::all();

        return json_encode($journaladata);
    }

    public function apidetail(JournalA $journala)
    {
        return response()->json($journala);
    }

    public function datatables(Request $request)
    {
		$data = $alldata = json_decode(
			JournalA::where('voucher_no', $request->voucher_no)->with([
				'coa',
				'coa.type',
			])->orderBy('id', 'DESC')->get()
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

	public function updateJournalTotalTransaction($voucher_no)
	{
		$journala = JournalA::where('voucher_no', $voucher_no)->get();

		$totalDebit = 0;
		$totalCredit = 0;
		for ($a=0; $a < count($journala); $a++) {
			$x = $journala[$a];

			$totalDebit += $x->debit;
			$totalCredit += $x->credit;
		}

		$total = ($v = $totalDebit)? $v: $totalCredit;

		Journal::where('voucher_no', $voucher_no)->update([
			'total_transaction' => $total
		]);
	}
}
