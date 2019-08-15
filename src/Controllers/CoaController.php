<?php

namespace Directoryxx\Finac\Controllers;

use Illuminate\Http\Request;
use Directoryxx\Finac\Model\Coa;
use Directoryxx\Finac\Request\CoaUpdate;
use App\Http\Controllers\Controller;



class CoaController extends Controller
{
    public function index()
    {
        return redirect()->route('coa.create');
    }

    public function getData(){
        $type = [
            '1' => 'AKTIVA',
            '2' => 'PASIVA',
            '3' => 'EKUITAS',
            '4' => 'PENDAPATAN',
            '5' => 'BIAYA'
        ];

        return json_encode($type,JSON_PRETTY_PRINT);







    }

    public function create()
    {
        $coa = Coa::all();
        //$submit = 'Add';
        return view('coaview::index');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'code' => 'required',
            'name' => 'required',
            'type_id' => 'required',
        ]);
        Coa::create([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type_id,
            'description' => $request->description
        ]);

        
    }

    public function edit(Coa $coa)
    {
        return response()->json($coa);
    }

    public function update(CoaUpdate $request, Coa $coa)
    {
        
        $coa->update($request->all());
        
        return response()->json($coa);
    }

    public function destroy(Coa $coa)
    {
        $coa->delete();

        return response()->json($coa);
    }

    public function getType($id){
        if ($id == 1){
            $type = [
                'id' => 1,
                'name' => 'AKTIVA',
            ];    
            return json_encode($type,JSON_PRETTY_PRINT);
        } elseif ($id == 2){
            $type = [
                'id' => 2,
                'name' => 'PASIVA',
            ];    
            return json_encode($type,JSON_PRETTY_PRINT);
        } elseif ($id == 3) {
            $type = [
                'id' => 3,
                'name' => 'EKUITAS',
            ];    
            return json_encode($type,JSON_PRETTY_PRINT);
        } elseif ($id == 4) {
            $type = [
                'id' => 4,
                'name' => 'PENDAPATAN',
            ];    
            return json_encode($type,JSON_PRETTY_PRINT);
        } elseif ($id == 5) {
            $type = [
                'id' => 5,
                'name' => 'BIAYA',
            ];    
            return json_encode($type,JSON_PRETTY_PRINT);
        }

    }

    public function datatables(){
        $data = $alldata = json_decode(Coa::All());

        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $_REQUEST);

        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch'])
                    ? $datatable['query']['generalSearch'] : '';

        if (! empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (boolean)preg_grep("/$filter/i", (array)$a);
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

        $sort  = ! empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = ! empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'RecordID';

        $meta    = [];
        $page    = ! empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = ! empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = count($data);

        usort($data, function ($a, $b) use ($sort, $field) {
            if (! isset($a->$field) || ! isset($b->$field)) {
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
}
