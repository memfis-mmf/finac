<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Directoryxx\Finac\Model\Invoice;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\EOInstruction;
use App\Models\Project;
use App\Models\Quotation;
use Carbon\Carbon;
use App\User;
use App\Models\HtCrr;
use App\Models\ListUtil;
use App\Models\WorkPackage;
use App\Models\QuotationHtcrrItem;
use App\Models\Pivots\ProjectWorkPackage;
use App\Models\Pivots\QuotationWorkPackage;
use App\Models\ProjectWorkPackageEOInstruction;
use App\Models\ProjectWorkPackageFacility;
use App\Models\ProjectWorkPackageTaskCard;
use App\Models\QuotationWorkPackageItem;
use App\Models\QuotationWorkPackageTaskCardItem;
use App\Models\TaskCard;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('invoiceview::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today = Carbon::today()->toDateString();
        //dd($today);
        return view('invoiceview::create')->with('today', $today);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }


    public function quodatatables()
    {
        function filterArray($array, $allowed = [])
        {
            return array_filter(
                $array,
                function ($val, $key) use ($allowed) { // N.b. $val, $key not $key, $val
                    return isset($allowed[$key]) && ($allowed[$key] === true || $allowed[$key] === $val);
                },
                ARRAY_FILTER_USE_BOTH
            );
        }

        function filterKeyword($data, $search, $field = '')
        {
            $filter = '';
            if (isset($search['value'])) {
                $filter = $search['value'];
            }
            if (!empty($filter)) {
                if (!empty($field)) {
                    if (strpos(strtolower($field), 'date') !== false) {
                        // filter by date range
                        $data = filterByDateRange($data, $filter, $field);
                    } else {
                        // filter by column
                        $data = array_filter($data, function ($a) use ($field, $filter) {
                            return (bool) preg_match("/$filter/i", $a[$field]);
                        });
                    }
                } else {
                    // general filter
                    $data = array_filter($data, function ($a) use ($filter) {
                        return (bool) preg_grep("/$filter/i", (array) $a);
                    });
                }
            }

            return $data;
        }

        function filterByDateRange($data, $filter, $field)
        {
            // filter by range
            if (!empty($range = array_filter(explode('|', $filter)))) {
                $filter = $range;
            }

            if (is_array($filter)) {
                foreach ($filter as &$date) {
                    // hardcoded date format
                    $date = date_create_from_format('m/d/Y', stripcslashes($date));
                }
                // filter by date range
                $data = array_filter($data, function ($a) use ($field, $filter) {
                    // hardcoded date format
                    $current = date_create_from_format('m/d/Y', $a[$field]);
                    $from    = $filter[0];
                    $to      = $filter[1];
                    if ($from <= $current && $to >= $current) {
                        return true;
                    }

                    return false;
                });
            }

            return $data;
        }

        $columnsDefault = [
            'name'     => true,
            'project_no'     => true,
            'workorder_no'  => true,
            'requested_at' => true,
            'customer_no' => true,
            'number' => true,
            'uuid'      => true,
            'Actions'      => true,
        ];

        if (isset($_REQUEST['columnsDef']) && is_array($_REQUEST['columnsDef'])) {
            $columnsDefault = [];
            foreach ($_REQUEST['columnsDef'] as $field) {
                $columnsDefault[$field] = true;
            }
        }

        $quotations = Quotation::all();

        //dd($quotations);

        foreach ($quotations as $quotation) {
            if (!empty($quotation->approvals->toArray())) {
                $approval = $quotation->approvals->toArray();
                $quotation->status .= 'Approved';
            } else {
                $quotation->status .= '';
            }
            $project = $quotation->quotationable->toArray();
            //dd($project);
            if ($project == null) {
                $quotation->project_no .= "-";
                $quotation->workorder_no .= "-";
                $quotation->customer_no .= "-";
            } else {
                $quotation->project_no .= $project['code'];
                $quotation->workorder_no .= $project['no_wo'];
                $quotation->customer_no .= $project['customer_id'];
            }
            //$quotation->customer = $quotation->project->customer;
        }
        //die();
        $data = json_decode($quotations);
        //dd($data);


        $alldata = json_decode($quotations, true);

        $data = [];
        // internal use; filter selected columns only from raw data
        foreach ($alldata as $d) {
            $data[] = filterArray($d, $columnsDefault);
        }

        // count data
        $totalRecords = $totalDisplay = count($data);

        // filter by general search keyword
        if (isset($_REQUEST['search'])) {
            $data         = filterKeyword($data, $_REQUEST['search']);
            $totalDisplay = count($data);
        }

        if (isset($_REQUEST['columns']) && is_array($_REQUEST['columns'])) {
            foreach ($_REQUEST['columns'] as $column) {
                if (isset($column['search'])) {
                    $data         = filterKeyword($data, $column['search'], $column['data']);
                    $totalDisplay = count($data);
                }
            }
        }

        // sort
        if (isset($_REQUEST['order'][0]['column']) && $_REQUEST['order'][0]['dir']) {
            $column = $_REQUEST['order'][0]['column'];
            $dir    = $_REQUEST['order'][0]['dir'];
            usort($data, function ($a, $b) use ($column, $dir) {
                $a = array_slice($a, $column, 1);
                $b = array_slice($b, $column, 1);
                $a = array_pop($a);
                $b = array_pop($b);

                if ($dir === 'asc') {
                    return $a > $b ? true : false;
                }

                return $a < $b ? true : false;
            });
        }

        // pagination length
        if (isset($_REQUEST['length'])) {
            $data = array_splice($data, $_REQUEST['start'], $_REQUEST['length']);
        }

        // return array values only without the keys
        if (isset($_REQUEST['array_values']) && $_REQUEST['array_values']) {
            $tmp  = $data;
            $data = [];
            foreach ($tmp as $d) {
                $data[] = array_values($d);
            }
        }

        $secho = 0;
        if (isset($_REQUEST['sEcho'])) {
            $secho = intval($_REQUEST['sEcho']);
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

        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function apidetail(Quotation $quotation)
    {
        $project = $quotation->quotationable()->first();
        $currency = $quotation->currency()->first();
        $project_init = Project::find($project->id)->workpackages()->get();
        //$workpackages = 
        //dd($project->customer_id);
        $customer = Customer::with(['levels', 'addresses'])->where('id', '=', $project->customer_id)->first();
        //dd($customer);
        $quotation->project .= $project;
        $quotation->customer .= $customer;
        $quotation->currency .= $currency;

        $quotation->attention .= $customer->attention;
        return response()->json($quotation);
    }

    public function table(Quotation $quotation)
    {
        $workpackages = $quotation->workpackages;
        $items = $quotation->item;


        //dd($items);

        foreach ($workpackages as $workPackage) {
            $project_workpackage = ProjectWorkPackage::where('project_id', $quotation->quotationable->id)
                ->where('workpackage_id', $workPackage->id)
                ->first();

            //dd();


            $countWPItem = QuotationWorkpackageTaskcardItem::where('quotation_id', $quotation->quotationable->id)
                ->where('workpackage_id', $workPackage->id)
                ->count();

            $workPackage->materialitem = $countWPItem;
            $basic_count = 0;
            $sip_count = 0;
            $cpcp_count = 0;
            $si_count = 0;


            $basictaskcards = ProjectWorkPackageTaskCard::with(['taskcard'])->where('project_workpackage_id', $project_workpackage->id)->get();
            foreach ($basictaskcards as $basictaskcard) {
                $taskcard =  TaskCard::find($basictaskcard->taskcard_id)->type;
                if ($taskcard->code == "basic") {
                    $basic_count += 1;
                } elseif ($taskcard->code == "sip") {
                    $sip_count += 1;
                } elseif ($taskcard->code == "cpcp") {
                    $cpcp_count += 1;
                } elseif ($taskcard->code == "si") {
                    $si_count += 1;
                }
            }

            $h1s = QuotationWorkPackageTaskCardItem::where('quotation_id', $quotation->quotationable->id)
                ->where('workpackage_id', $workPackage->id)->get();

            $real_h1 = 0;
            foreach ($h1s as $h1) {
                $calculate = ($h1->price_amount * $h1->quantity);
                $real_h1 += $calculate;
            }


            $h2s = QuotationWorkPackage::where('quotation_id', $quotation->quotationable->id)
                ->where('workpackage_id', $workPackage->id)->get();
            //dd($h2s);
            $real_h2 = 0;
            foreach ($h2s as $h2) {
                $calculate = ($h2->manhour_rate_amount * $h2->manhour_total);
                $real_h2 += $calculate;
            }

            $adsbtaskcards = ProjectWorkPackageEOInstruction::where('project_workpackage_id', $project_workpackage->id)->get();
            foreach ($adsbtaskcards as $adsbtaskcard) {
                $eoinsctructions = EOInstruction::find($adsbtaskcard->eo_instruction_id)->get();
                $adsb_count = 0;
                $cmrawl_count = 0;
                $eo_count = 0;
                $ea_count = 0;
                foreach ($eoinsctructions as $eoinsctruction) {
                    $taskcard =  TaskCard::find($eoinsctruction->taskcard_id)->type;
                    if ($taskcard->code == "ad" || $taskcard->code == "sb") {
                        $adsb_count += 1;
                    } elseif ($taskcard->code == "cmr" || $taskcard->code == "awl") {
                        $cmrawl_count += 1;
                    } elseif ($taskcard->code == "eo") {
                        $eo_count += 1;
                    } elseif ($taskcard->code == "ea") {
                        $ea_count += 1;
                    }
                }
            }

            

            
            if ($project_workpackage) {
                $workPackage->total_manhours_with_performance_factor = $project_workpackage->total_manhours_with_performance_factor;

                $ProjectWorkPackageFacility = ProjectWorkPackageFacility::where('project_workpackage_id', $project_workpackage->id)
                    ->with('facility')
                    ->sum('price_amount');
                $workPackage->facilities_price_amount = $ProjectWorkPackageFacility;

                $workPackage->mat_tool_price = QuotationWorkPackageTaskCardItem::where('quotation_id', $quotation->id)->where('workpackage_id', $workPackage->id)->sum('subtotal');

                $workPackage->basic = $basic_count;
                $workPackage->sip = $sip_count;
                $workPackage->cpcp = $cpcp_count;
                $workPackage->adsb = $adsb_count;
                $workPackage->cmrawl = $cmrawl_count;
                $workPackage->eo = $eo_count;
                $workPackage->ea = $ea_count;
                $workPackage->si = $si_count;
                $workPackage->h1 = $real_h1;
                $workPackage->h2 = $real_h2;
            }
        }
        
        $htcrrs = HtCrr::where('project_id', $quotation->quotationable->id)->get();
        $parseHtccr = json_decode($quotation->data_htcrr);
        //dd($parseHtccr);
        $pricehtccr = $parseHtccr->manhour_rate_amount * $parseHtccr->total_manhours_with_performance_factor;
        if (sizeof($htcrrs) > 0) {
            $htcrr_workpackage = new WorkPackage();
            $htcrr_workpackage->code = "Workpackage HT CRR";
            $htcrr_workpackage->title = "Workpackage HT CRR";
            $htcrr_workpackage->htcrrcount = HtCrr::where('project_id', $quotation->quotationable->id)->count();
            $htcrr_workpackage->price = $pricehtccr;

            $workpackages[sizeof($workpackages)] = $htcrr_workpackage;
        }
        


        $data = $alldata = json_decode($workpackages);

        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $_REQUEST);

        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch'])
            ? $datatable['query']['generalSearch'] : '';

        if (!empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (bool) preg_grep("/$filter/i", (array) $a);
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

        $sort  = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'RecordID';

        $meta    = [];
        $page    = !empty($datatable['pagination']['page']) ? (int) $datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ? (int) $datatable['pagination']['perpage'] : -1;

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
