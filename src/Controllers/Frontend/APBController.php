<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Model\APayment;
use memfisfa\Finac\Model\APaymentB;
use memfisfa\Finac\Request\APaymentBUpdate;
use memfisfa\Finac\Request\APaymentBStore;
use App\Http\Controllers\Controller;

class APBController extends Controller
{
    public function index()
    {
        return redirect()->route('APaymentB.create');
    }

    public function create()
    {
        return view('APaymentBview::index');
    }

    public function store(APaymentBStore $request)
    {
        $coa = Coa::where('uuid', $request->coa_uuid)->first();
        $ap = APayment::where('uuid', $request->ap_uuid)->firstOrFail();
        if ($ap->approve) {
            return abort(404);
        }

        $request->request->add([
            'transactionnumber' => $ap->transactionnumber,
            'ap_id' => $ap->id,
            'code' => $coa->code,
            'name' => $coa->name,
        ]);

        $APaymentB = APaymentB::create($request->all());
        return response()->json($APaymentB);
    }

    public function edit(APaymentB $APaymentB)
    {
        $ap = $APaymentB->ap;
        if ($ap->approve) {
            return abort(404);
        }
        return response()->json($APaymentB);
    }

    public function update(APaymentBUpdate $request, $apb_uuid)
    {
        $apb_tmp = APaymentB::where('uuid', $apb_uuid);
        $apb = $apb_tmp->first();
        $ap = $apb->ap;

        if ($ap->approve) {
            return abort(404);
        }

        if ($request->debit_b != 0 and $request->credit_b != 0) {
            return [
                'errors' => 'Cannot fill debit and credit at once'
            ];
        }

        if ($request->debit_b == 0 and $request->credit_b == 0) {
            return [
                'errors' => 'Fill at least one debit or credit'
            ];
        }

        $request->merge([
            'description' => $request->description_b,
            'debit' => $request->debit_b,
            'credit' => $request->credit_b,
            'id_project' => $request->id_project_detail,
        ]);

        $request->request->add([
            'debit_idr' => $request->debit_b * $ap->exchangerate,
            'credit_idr' => $request->credit_b * $ap->exchangerate,
        ]);

        $apb_tmp->update($request->only([
            'debit',
            'credit',
            'debit_idr',
            'credit_idr',
            'description',
            'id_project',
        ]));

        return response()->json($apb);
    }

    public function destroy(Request $request)
    {
        $apb = APaymentB::where('uuid', $request->apaymentb)->first();
        $ap = $apb->ap;
        if ($ap->approve) {
            return abort(404);
        }

        APaymentB::where('uuid', $request->apaymentb)->forceDelete();
    }

    public function api()
    {
        $APaymentBdata = APaymentB::all();

        return json_encode($APaymentBdata);
    }

    public function apidetail(APaymentB $APaymentB)
    {
        return response()->json($APaymentB);
    }

    public function datatables(Request $request)
    {
        $AP = APayment::where('uuid', $request->ap_uuid)->first();

        $data = $alldata = json_decode(
            APaymentB::where('ap_id', $AP->id)
                ->with([
                    'ap',
                    'ap.currencies',
                    'project',
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
