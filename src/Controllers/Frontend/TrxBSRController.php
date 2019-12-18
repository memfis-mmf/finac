<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Directoryxx\Finac\Model\TrxBSR as BSR;
use App\Http\Controllers\Controller;
use Directoryxx\Finac\Request\BSRUpdate;
use Directoryxx\Finac\Request\BSRStore;
use App\Models\Currency;

class TrxBSRController extends Controller
{
    public function index()
    {
        return redirect()->route('bsr.create');
    }

    public function approve(Request $request)
    {
		$bsr = BSR::where('uuid', $request->uuid);

		$header = $bsr->first();

		$detail[] = (object) [
			'code' => $header->coad
		];

		$detail[] = (object) [
			'code' => $header->coac
		];

		Journal::insertFromBSR($header, $detail);

		$bsr->update([
			'approve' => 1
		]);

        return response()->json($bsr->first());
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
        return view('bsrview::index');
    }


	public function getTypeJson()
	{
		$bsrType = TypeJurnal::where('name', 'GENERAL JOURNAL')
			->orWhere('name', 'JOURNAL ADJUSTMENT')
			->get();

		$type = [];

		for ($i = 0; $i < count($bsrType); $i++) {
			$x = $bsrType[$i];

			$type[$x->id] = $x->name;
		}

        return json_encode($type, JSON_PRETTY_PRINT);
	}

	public function bsraStore(Request $request)
	{
		BSRA::create($request->all());
	}

    public function store(BSRStore $request)
    {
		$data = $request->all();

        $bsr = BSR::create($data);
        return response()->json($bsr);
    }

    public function edit(Request $request)
    {
		$data['bsr']= BSR::where('uuid', $request->bsr)->with([
		])->first();

		if ($data['bsr']->approve) {
			return redirect()->back();
		}

        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function update(BSRUpdate $request, BSR $bsr)
    {
        $bsr->update($request->all());

        return response()->json($bsr);
    }

    public function destroy(BSR $bsr)
    {
        $bsr->delete();

        return response()->json($bsr);
    }

    public function api()
    {
        $bsrdata = BSR::all();

        return json_encode($bsrdata);
    }

    public function apidetail(BSR $bsr)
    {
        return response()->json($bsr);
    }

    public function datatables()
    {
		$data = $alldata = json_decode(BSR::orderBy('id', 'DESC')->get());

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
		$bsr = BSR::where('uuid', $request->uuid)->first();

		$debit = 0;
		$credit = 0;

		for ($i = 0; $i < count($bsra); $i++) {
			$x = $bsra[$i];
			$debit += $x->debit;
			$credit += $x->credit;
		}

		$data = [
			'bsr' => $bsr,
			'bsra' => $bsra,
			'debit' => $debit,
			'credit' => $credit,
		];

        $pdf = \PDF::loadView('formview::bsr', $data);
        return $pdf->stream();
	}
}
