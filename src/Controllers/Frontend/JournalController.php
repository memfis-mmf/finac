<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Auth;
use Illuminate\Http\Request;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Model\TrxJournal as Journal;
use memfisfa\Finac\Model\TrxJournalA as JournalA;
use memfisfa\Finac\Model\TypeJurnal;
use memfisfa\Finac\Model\JurnalA;
use memfisfa\Finac\Request\JournalUpdate;
use memfisfa\Finac\Request\JournalStore;
use memfisfa\Finac\Request\JournalAstore;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Approval;
use DataTables;
use App\Models\Project;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function index()
    {
        return redirect()->route('journal.create');
    }

	public function checkBalance($journala)
	{
		$debit = 0;
		$credit = 0;

		for ($i = 0; $i < count($journala); $i++) {
			$x = $journala[$i];
			$debit += $x->debit;
			$credit += $x->credit;
		}

		return ($debit != $credit);
	}

    public function approve(Request $request)
    {
		$journal = Journal::where('uuid', $request->uuid);
		$journala = $journal->first()->journala;

		if ($this->checkBalance($journala)) {
			return [
				'errors' => 'Debit and Credit not balance'
			];
		}

		Journal::approve($journal);

        return response()->json($journal->first());
    }

    public function unapprove(Request $request)
    {
		$journal = Journal::where('uuid', $request->uuid);
		$journala = $journal->first()->journala;

		if ($this->checkBalance($journala)) {
			return [
				'errors' => 'Debit and Credit not balance'
			];
		}

		$journal->first()->approvals()->delete();

		$journal->update([
			'approve' => false
		]);

        return response()->json($journal->first());
    }

	public function getType(Request $request)
	{
		return response()->json(TypeJurnal::all());
	}

	public function getCurrency(Request $request)
	{
		return response()->json(Currency::all());
	}

    public function create()
    {
        return view('journalview::index');
    }


	public function getTypeJson()
	{
		$journalType = TypeJurnal::where('name', 'GENERAL JOURNAL')
			->orWhere('name', 'JOURNAL ADJUSTMENT')
			->get();

		$type = [];

		for ($i = 0; $i < count($journalType); $i++) {
			$x = $journalType[$i];

			$type[$x->id] = $x->name;
		}

        return json_encode($type, JSON_PRETTY_PRINT);
	}

	public function journalaStore(Request $request)
	{
		JournalA::create($request->all());
	}

    public function store(JournalStore $request)
    {
		$code = Journal::getJournalCode($request->journal_type);

		$data = $request->all();
		$data['voucher_no'] = Journal::generateCode($code);

        $journal = Journal::create($data);
        return response()->json($journal);
    }

    public function edit(Request $request)
    {
        $data['journal']= Journal::where('uuid', $request->journal)->with([
            'type_jurnal',
            'currency',
        ])->firstOrFail();

        if ($data['journal']->approve) {
            return abort(404);
        }

        $data['journal_type'] = TypeJurnal::all();
        $data['currency'] = Currency::selectRaw(
            'code, CONCAT(name, " (", symbol ,")") as full_name'
        )->whereIn('code',['idr','usd'])
        ->get();

        return view('journalview::edit', $data);
    }

    public function update(JournalUpdate $request, Journal $journal)
    {
		if ($journal->approve) {
			return abort(404);
        }

		$voucher_no = $request->journal->voucher_no;

        $journal->update($request->all());

        return response()->json($journal);
    }

    public function destroy(Journal $journal)
    {
		if ($journal->approve) {
			return abort(404);
        }

        $journal->delete();

        return response()->json($journal);
    }

    public function api()
    {
        $journaldata = Journal::all();

        return json_encode($journaldata);
    }

    public function apidetail(Journal $journal)
    {
        return response()->json($journal);
    }

    public function datatables(Request $request)
    {
        if ($request->daterange) {
            $date = explode(' - ', $request->daterange);
            $start_date = Carbon::createFromFormat('Y-m-d', $date[0]);
            $end_date = Carbon::createFromFormat('Y-m-d', $date[1]);
        }

		$data = Journal::with([
                'type_jurnal',
                'currency',
            ])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'asc');

        if ($request->daterange) {
            $data = $data->whereBetween('transaction_date', [$start_date, $end_date]);
        }

        return DataTables::of($data)
		->addColumn('unapproved', function(Journal $journal) use ($request) {
			$html = '';

			if ($request->user()->hasRole('admin') && $journal->approve) {
				$html = '
					<a href="javascript:;"
					class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill unapprove"
					title="Unapprove" data-uuid="'.$journal->uuid.'">
						<i class="fa fa-times"></i>
					</a>
				';
			}

			return $html;
		})
		->escapeColumns([])
		->make(true);
    }

    public function old_datatables()
    {
		$data = $alldata = json_decode(Journal::with([
			'type_jurnal',
			'currency',
		])->orderBy('id', 'DESC')->get());

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
		$journal = Journal::where('uuid', $request->uuid)->first();
		$journala = $journal->journala;

		if ($this->checkBalance($journala)) {
			return redirect()->route('journal.index')->with([
				'errors' => 'Debit and Credit not balance'
			]);
		}

		$debit = 0;
		$credit = 0;

		for ($i = 0; $i < count($journala); $i++) {
			$x = $journala[$i];
			$debit += $x->debit;
			$credit += $x->credit;
		}

		$data = [
			'journal' => $journal,
			'journala' => $journala,
			'debit' => $debit,
			'credit' => $credit,
		];

        $pdf = \PDF::loadView('formview::journal', $data);
        return $pdf->stream();
	}

	public function getAccountCodeSelect2(Request $request)
	{
		$q = $request->q;

		// pengecekan apakah search by name atau code
		$param = 'name';

		if ((int) $q) {
			$param = 'code';
		}

		$coa = Coa::where($param, 'like', '%'.$q.'%')
		->where('description', 'detail')
		->get();

		$data['results'] = [];

		for ($a=0; $a < count($coa); $a++) {
			$x = $coa[$a];

			$data['results'][] = [
				'id' => $x->code,
				'text' => $x->name.' ('.$x->code.')'
			];
		}

		return $data;
	}

	public function getProjectSelect2(Request $request)
	{
        $q = $request->q;

        $projects = Project::with('aircraft', 'customer', 'approvals', 'audits')
            ->where('code', 'like', "%$q%")
            ->has('approvals', 2)
            ->latest()
            ->limit(50)
            ->get();

        $data['results'] = [];
        
        foreach ($projects as $x) {
            $data['results'][] = [
                'id' => $x->id,
                'text' => $x->code
            ];
        }

		return $data;
	}
}
