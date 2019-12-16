<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Directoryxx\Finac\Model\TrxBS as BS;
use App\Http\Controllers\Controller;
use Directoryxx\Finac\Request\BSUpdate;
use Directoryxx\Finac\Request\BSStore;
use App\Models\Currency;

class TrxBSController extends Controller
{
    public function index()
    {
        return redirect()->route('bs.create');
    }

    public function approve(Request $request)
    {
		$bs = BS::where('uuid', $request->uuid);

		$bs->update([
			'approve' => 1
		]);

        return response()->json($bs->first());
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
        return view('bsview::index');
    }


	public function getTypeJson()
	{
		$bsType = TypeJurnal::where('name', 'GENERAL JOURNAL')
			->orWhere('name', 'JOURNAL ADJUSTMENT')
			->get();

		$type = [];

		for ($i = 0; $i < count($bsType); $i++) {
			$x = $bsType[$i];

			$type[$x->id] = $x->name;
		}

        return json_encode($type, JSON_PRETTY_PRINT);
	}

	public function bsaStore(Request $request)
	{
		BSA::create($request->all());
	}

    public function store(BSStore $request)
    {
		$data = $request->all();
		$data['transaction_number'] = BS::generateCode('BSTR');

        $bs = BS::create($data);
        return response()->json($bs);
    }

    public function edit(Request $request)
    {
		$data['bs']= BS::where('uuid', $request->bs)->with([
		])->first();

		if ($data['bs']->approve) {
			return redirect()->back();
		}

        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function update(BSUpdate $request, BS $bs)
    {
        $bs->update($request->all());

        return response()->json($bs);
    }

    public function destroy(BS $bs)
    {
        $bs->delete();

        return response()->json($bs);
    }

    public function api()
    {
        $bsdata = BS::all();

        return json_encode($bsdata);
    }

    public function apidetail(BS $bs)
    {
        return response()->json($bs);
    }

    public function datatables()
    {
		$data = $alldata = json_decode(BS::orderBy('id', 'DESC')->get());

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
		$bs = BS::where('uuid', $request->uuid)->first();
		$bsa = $bs->bsa;

		if ($this->checkBalance($bsa)) {
			return redirect()->route('bs.index')->with([
				'errors' => 'Debit and Credit not balance'
			]);
		}

		$debit = 0;
		$credit = 0;

		for ($i = 0; $i < count($bsa); $i++) {
			$x = $bsa[$i];
			$debit += $x->debit;
			$credit += $x->credit;
		}

		$data = [
			'bs' => $bs,
			'bsa' => $bsa,
			'debit' => $debit,
			'credit' => $credit,
		];

        $pdf = \PDF::loadView('formview::bs', $data);
        return $pdf->stream();
	}
}
