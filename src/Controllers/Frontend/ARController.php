<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Directoryxx\Finac\Model\ARecieve;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Directoryxx\Finac\Helpers\CashbookGenerateNumber;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use Directoryxx\Finac\Model\Coa;
use App\Models\Approval;

class ARController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('arview::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arview::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Customer::where('name',$request->customer)->first();
        $accountcode = Coa::where('name', $request->coa)->first();
        $arsuggest = 'AR-MMF/' . Carbon::now()->format('Y/m');
        $currency_substring = substr($request->currency, 0, strpos($request->currency, ' ('));
        $currency = Currency::where('name',$currency_substring)->first();
        $arcount = ARecieve::where('transactionnumber', 'like', $arsuggest . '%')->withTrashed()->count();
        $arno = CashbookGenerateNumber::generate('AR-MMF/', $arcount + 1);
        $ar = ARecieve::create([
            'id_branch' => 1,
            'approve' => 0,
            'transactionnumber' => $arno,
            'transactiondate' => $request->date,
            'id_customer' => $customer->id,
            'accountcode' => $accountcode->id,
            'refno' => $request->refno,
            'currency' => $currency->id,
            'exchangerate' => $request->exchangerate,
            'totaltransaction' => 0,
            'description' => $request->description
        ]);

        return response()->json($ar); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ARecieve $arecieve)
    {
        $data = $arecieve;
        $coa = Coa::where('id',$arecieve->accountcode)->first();
        $customer = Customer::where('id',$arecieve->id_customer)->first();
        $currency = Currency::where('id',$arecieve->currency)->first();
        //dd($data);
        return view('arview::edit')
            ->with('coa',$coa)
            ->with('currency',$currency)
            ->with('customer',$customer)
            ->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ARecieve $arecieve)
    {
        $arecieve->delete();
        return response()->json($arecieve);
    }


    public function datatables()
    {
        $arecieves = ARecieve::all();

        foreach($arecieves as $arecieve){
            if(!empty($arecieve->approvals->toArray())){
                $approval = $arecieve->approvals->toArray();
                $arecieve->status .= 'Approved';
                $arecieve->approvedby .= $approval[0]['conducted_by'];
            }else{
                $arecieve->status .= '';

            }
            //$quotation->customer = $quotation->project->customer;
        }
        $data = $alldata = json_decode($arecieves);

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

    public function cust_detail(Customer $customer){
        $cust_detail = $customer->coa->first();
        return response()->json($cust_detail);
    }

    
}
