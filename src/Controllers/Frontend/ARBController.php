<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Model\AReceive;
use memfisfa\Finac\Model\AReceiveB;
use memfisfa\Finac\Request\AReceiveBUpdate;
use memfisfa\Finac\Request\AReceiveBStore;
use App\Http\Controllers\Controller;

class ARBController extends Controller
{
    public function index()
    {
        return redirect()->route('AReceiveB.create');
    }

    public function create()
    {
        return view('AReceiveBview::index');
    }

    public function store(AReceiveBStore $request)
    {
        $coa = Coa::where('uuid', $request->coa_uuid)->first();
        $ar = AReceive::where('uuid', $request->ar_uuid)->first();

        $request->request->add([
            'transactionnumber' => $ar->transactionnumber,
            'ar_id' => $ar->id,
            'code' => $coa->code,
            'name' => $coa->name,
        ]);

        $AReceiveB = AReceiveB::create($request->all());
        return response()->json($AReceiveB);
    }

    public function edit(AReceiveB $AReceiveB)
    {
        return response()->json($AReceiveB);
    }

    public function update(AReceiveBUpdate $request, AReceiveB $AReceiveB)
    {
        $arb_tmp = AReceiveB::where('uuid', $request->areceiveb);
        $arb = $arb_tmp->first();
        $ar = $arb->ar;

        $request->merge([
            'description' => $request->description_b,
            'debit' => $request->debit_b,
            'credit' => $request->credit_b,
        ]);

        $request->request->add([
            'debit_idr' => $request->debit_b * $ar->exchangerate,
            'credit_idr' => $request->credit_b * $ar->exchangerate,
        ]);

        $arb_tmp->update($request->only([
            'debit',
            'credit',
            'debit_idr',
            'credit_idr',
            'description',
        ]));

        return response()->json($AReceiveB);
    }

    public function destroy(Request $request)
    {
        AReceiveB::where('uuid', $request->areceiveb)->delete();
    }

    public function api()
    {
        $AReceiveBdata = AReceiveB::all();

        return json_encode($AReceiveBdata);
    }

    public function apidetail(AReceiveB $AReceiveB)
    {
        return response()->json($AReceiveB);
    }

    public function datatables(Request $request)
    {
        $AR = AReceive::where('uuid', $request->ar_uuid)->first();

        $data = $alldata = json_decode(
            AReceiveB::where('transactionnumber', $AR->transactionnumber)
                ->with([
                    'ar',
                    'ar.currencies',
                ])
                ->get()
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
            filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)
        ) {
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
