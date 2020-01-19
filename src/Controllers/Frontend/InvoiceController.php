<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\Invoice;
use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Currency;
use memfisfa\Finac\Model\Coa;
use App\Models\Customer;
use Auth;
use App\Models\EOInstruction;
use App\Models\Project;
use App\Models\Quotation;
use Carbon\Carbon;
use memfisfa\Finac\Helpers\CashbookGenerateNumber;
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
use App\Models\Type;
use memfisfa\Finac\Model\Invoicetotalprofit;
use memfisfa\Finac\Model\Trxinvoice;
use stdClass;

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

        $quotation = Quotation::where('number', $request->quotation)->first();
        //dd($quotation->scheduled_payment_amount);

        $invoice_check = Invoice::where('id_quotation',$quotation->id)->count();
        //dd($invoice_check);
        $schedule_payment = json_decode($quotation->scheduled_payment_amount);

        if (!@$schedule_payment[0]->amount_percentage) {
          return [
			  'error' => 'amount percentage cannot be null'
		  ];
        }
        //dd($schedule_payment);
        $end_sp = array_key_last ( $schedule_payment );         // move the internal pointer to the end of the array
        $last_sp = $end_sp + 1;
        $percent_sp =$schedule_payment[$last_sp - 1]->amount_percentage;



        $project = $quotation->quotationable()->first();
        $customer = Customer::with(['levels', 'addresses'])->where('id', '=', $project->customer_id)->first();
        $crjsuggest = 'INV-MMF/' . Carbon::now()->format('Y/m');
        $currency = Currency::where('name', $request->currency)->first();
        $coa = Coa::where('code', $request->account)->first();
        $material = Coa::where('code', $request->material)->first();
        $manhours = Coa::where('code', $request->manhours)->first();
        $facility = Coa::where('code', $request->facility)->first();
        $others = Coa::where('code', $request->other)->first();
        $bankaccount = BankAccount::where('uuid', $request->bank)->first();
        //dd($bankaccount);
        //dd($coa);
        $cashbookCount = Invoice::where('transactionnumber', 'like', $crjsuggest . '%')->withTrashed()->count();
        $cashbookno = CashbookGenerateNumber::generate('INV-MMF/', $cashbookCount + 1);
        $id_branch = 1;
        $closed = 0;
        $transaction_number = $cashbookno;
        $transaction_date = Carbon::today()->toDateString();
        $customer_id = $customer->id;
        $currency_id = $currency->id;
        $quotation_id = $quotation->id;
        $exchange_rate = $request->exchange_rate;
        $discount_value = $request->discount;
        $percent = $discount_value / $request->subtotal;
        $attention = [];
        $attention['name'] = $request->attention;
        $attention['phone'] = $request->phone;
        $attention['address'] = $request->address;
        $attention['fax'] = $request->fax;
        $attention['email'] = $request->email;
        $fix_attention = json_encode($attention);
        //dd($fix_attention);

        //$request->merge(['attention' => json_encode($attention)]);
        $percent_friendly = number_format($percent * 100);
        $ppn_percent = 10;
        $ppn_value = $request->pphvalue;
        $grandtotalfrg = $request->grand_total;
        $grandtotalidr = $request->grand_totalrp;
        $description = "";
        $invoice = Invoice::create([
            'id_branch' => $id_branch,
            'closed' => $closed,
            'id_quotation' => $quotation_id,
            'transactionnumber' => $transaction_number,
            'transactiondate' => $transaction_date,
            'id_customer' => $customer_id,
            'currency' => $currency_id,
            'exchangerate' => $exchange_rate,
            'discountpercent' => $percent_friendly,
            'discountvalue' => $discount_value,
            'ppnpercent' => $ppn_percent,
            'schedule_payment' => $request->schedule_payment,
            'ppnvalue' => $ppn_value,
            'id_bank' => $bankaccount->id,
            'grandtotalforeign' => $grandtotalfrg,
            'grandtotal' => $grandtotalidr,
            'accountcode' => $coa->id,
            'description' => $description,
            'attention' => $fix_attention,
        ]);

        $invoicetrx = Trxinvoice::create([
            'id_branch' => $id_branch,
            'closed' => $closed,
            'id_quotation' => $quotation_id,
            'transactionnumber' => $transaction_number,
            'transactiondate' => $transaction_date,
            'id_customer' => $customer_id,
            'currency' => $currency_id,
            'exchangerate' => $exchange_rate,
            'discountpercent' => $percent_friendly,
            'discountvalue' => $discount_value,
            'ppnpercent' => $ppn_percent,
            'ppnvalue' => $ppn_value,
            'schedule_payment' => $request->schedule_payment,
            'id_bank' => $bankaccount->id,
            'grandtotalforeign' => $grandtotalfrg,
            'grandtotal' => $grandtotalidr,
            'accountcode' => $coa->id,
            'description' => $description,
            'attention' => $fix_attention,
        ]);

        $list = [
            'manhours' => $request->manhoursprice ,
            'manhours_percent' => $percent_sp,
            'manhours_calc' => ($percent_sp/100),
            'manhours_result' =>  $request->manhoursprice * ($percent_sp/100),
            'material' => $request->materialprice ,
            'material_percent' => $percent_sp,
            'material_calc' => ($percent_sp/100),
            'material_result' =>  $request->materialprice * ($percent_sp/100),
            'facility' => $request->facilityprice ,
            'facility_percent' => $percent_sp,
            'facility_calc' => ($percent_sp/100),
            'facility_result' =>  $request->facilityprice * ($percent_sp/100),
            'others' => $request->otherprice ,
            'others_percent' => $percent_sp,
            'others_calc' => ($percent_sp/100),
            'others_result' =>  $request->otherprice * ($percent_sp/100),

        ];
        $manhours_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $manhours->id,
            'amount' => $request->manhoursprice * ($percent_sp/100),
            'type' => 'manhours'
        ]);

        $material_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $material->id,
            'amount' => $request->materialprice * ($percent_sp/100),
            'type' => 'material'
        ]);

        $facility_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $facility->id,
            'amount' => $request->facilityprice * ($percent_sp/100),
            'type' => 'facility'
        ]);

        $others_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $others->id,
            'amount' => $request->otherprice * ($percent_sp/100),
            'type' => 'others'
        ]);

        return response()->json($invoice);
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
    public function edit(Invoice $invoice)
    {
        //dd($invoice->transactiondate);
        $quotation = Quotation::where('id', $invoice->id_quotation)->first();
        $currency = $invoice->currencies;
        $coa = $invoice->coas;
        //dd($invoice->id);
        $material = Invoicetotalprofit::where('invoice_id',$invoice->id)->where('type','material')->first();
        $material_id = Coa::where('id',$material->accountcode)->first();
        $manhours = Invoicetotalprofit::where('invoice_id',$invoice->id)->where('type','manhours')->first();
        $manhours_id = Coa::where('id',$manhours->accountcode)->first();
        $facility = Invoicetotalprofit::where('invoice_id',$invoice->id)->where('type','facility')->first();
        $facility_id = Coa::where('id',$facility->accountcode)->first();
        $others = Invoicetotalprofit::where('invoice_id',$invoice->id)->where('type','others')->first();
        $others_id = Coa::where('id',$others->accountcode)->first();

        $bankAccountget = BankAccount::where('id',$invoice->id_bank)->first();
        //dd($bankAccountget->uuid);
        $bankget = Bank::where('id',$bankAccountget->bank_id)->first();
        $bank = BankAccount::selectRaw('uuid, CONCAT(name, " (", number ,")") as full,id')->get();
        //dump($bank);
        //dd($coa);
        return view('invoiceview::edit')
            ->with('today', $invoice->transactiondate)
            ->with('quotation', $quotation)
            ->with('coa', $coa)
            ->with('manhours',$manhours_id)
            ->with('material',$material_id)
            ->with('facility',$facility_id)
            ->with('others',$others_id)
            ->with('invoice', $invoice)
            ->with('bankget',$bankget)
            ->with('banks',$bank)
            ->with('bankaccountget',$bankAccountget)
            ->with('currencycode', $currency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {

        $currency = Currency::where('name', $request->currency)->first();
        $coa = Coa::where('code', $request->account)->first();
        $bankaccount = BankAccount::where('uuid', $request->bank)->first();
        //dd($bankaccount);
        //dd($coa);
        $currency_id = $currency->id;
        $exchange_rate = $request->exchange_rate;
        $discount_value = $request->discount;
        $percent = $discount_value / $request->subtotal;
        $percent_friendly = number_format($percent * 100);
        $ppn_percent = 10;
        $ppn_value = $request->pphvalue;
        $grandtotalfrg = $request->grand_total;
        $grandtotalidr = $request->grand_totalrp;
        $description = $request->description;

        $invoice1 = Invoice::where('id', $invoice->id)
            ->update([
                'currency' => $currency_id,
                'exchangerate' => $exchange_rate,
                'discountpercent' => $percent_friendly,
                'discountvalue' => $discount_value,
                'ppnpercent' => $ppn_percent,
                'ppnvalue' => $ppn_value,
                'id_bank' => $bankaccount->id,
                'grandtotalforeign' => $grandtotalfrg,
                'grandtotal' => $grandtotalidr,
                'accountcode' => $coa->id,
                'description' => $description,
            ]);

        //dd($invoice);
        $trxinvoice = Trxinvoice::where('id', $invoice->id)
            ->update([
                'currency' => $currency_id,
                'exchangerate' => $exchange_rate,
                'discountpercent' => $percent_friendly,
                'discountvalue' => $discount_value,
                'ppnpercent' => $ppn_percent,
                'ppnvalue' => $ppn_value,
                'id_bank' => $bankaccount->id,
                'grandtotalforeign' => $grandtotalfrg,
                'grandtotal' => $grandtotalidr,
                'accountcode' => $coa->id,
                'description' => $description,
            ]);




        return response()->json($invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        Invoice::where('id', $invoice->id)
            ->update([
                'closed' => 2,
            ]);
        return response()->json($invoice);
    }

    public function approve(Invoice $invoice)
    {
        $invoice->approvals()->save(new Approval([
            'approvable_id' => $invoice->id,
            'is_approved' => 0,
            'conducted_by' => Auth::id(),
        ]));
        return response()->json($invoice);
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
            $cust = Customer::where('id',$project['customer_id'])->first();
            if ($project == null) {
                $quotation->project_no .= "-";
                $quotation->workorder_no .= "-";
                $quotation->customer_no .= "-";
            } else {
                //$quotation->customername .=
                $quotation->project_no .= $project['code'];
                $quotation->workorder_no .= $project['no_wo'];
                $quotation->customer_no .= $cust->name;
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

    public function datatables()
    {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {

            if (!empty($invoice->approvals->toArray())) {
                $quotation = $invoice->quotations->toArray();
                if ($quotation['parent_id'] == null) {
                    $invoice->xstatus .= "Quotation Project";
                } else {
                    $invoice->xstatus .= "Quotation Additional";
                }
                $approval = $invoice->approvals->toArray();

                $invoice->status .= 'Approved';
                $invoice->approvedby .= $approval[0]['conducted_by'];
            } elseif ($invoice->closed == 2) {
                $invoice->status .= 'Void';
                $quotation = $invoice->quotations->toArray();
                if ($quotation['parent_id'] == null) {
                    $invoice->xstatus .= "Quotation Project";
                } else {
                    $invoice->xstatus .= "Quotation Additional";
                }
            } else {
                $invoice->status .= 'Open';
                $quotation = $invoice->quotations->toArray();
                if ($quotation['parent_id'] == null) {
                    $invoice->xstatus .= "Quotation Project";
                } else {
                    $invoice->xstatus .= "Quotation Additional";
                }
            }
            //$quotation->customer = $quotation->project->customer;
        }
        $data = $alldata = json_decode($invoices);

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

    public function apidetail(Quotation $quotation)
    {
        $project = $quotation->quotationable()->first();
        $currency = $quotation->currency()->first();
        $project_init = Project::find($project->id)->workpackages()->get();
        $invoicecount = Invoice::where('id_quotation',$quotation->id)->count();
        $schedule_payment = json_decode($quotation->scheduled_payment_amount);
        //dd($schedule_payment);
        $end_sp = array_key_last ( $schedule_payment );         // move the internal pointer to the end of the array
        $last_sp = $end_sp + 1;
        //$workpackages =
        //dd($project->customer_id);
        $attn_quo =
        $customer = Customer::with(['levels', 'addresses'])->where('id', '=', $project->customer_id)->first();
        //dd($customer);
        $quotation->project .= $project;
        $quotation->customer .= $customer;
        $quotation->currency .= $currency;
        $quotation->spcount .= $last_sp;
        $quotation->invoicecount .= $invoicecount;

        $quotation->attention_cust .= $customer->attention;
        $quotation->attention_quo .= $quotation->attention;
        return response()->json($quotation);
    }

    public function table(Quotation $quotation)
    {
        $workpackages = $quotation->workpackages;
        $items = $quotation->item;
        //dump($quotation->charge);
        $taxes =  $quotation->taxes->first();
        if ($taxes != null) {
            $taxes_type = Type::where('id', $taxes->type_id)->first();
        } else {
            $taxes_type = new stdClass();
            $taxes_type->code = 0;
        }

        foreach ($workpackages as $workPackage) {
            $project_workpackage = ProjectWorkPackage::where('project_id', $quotation->quotationable->id)
                ->where('workpackage_id', $workPackage->id)
                ->first();

            // dd($project_workpackage->id);

            // if WorkPackage is empty
            if (!$project_workpackage) {
              return ['error' => 'workpackages not found'];
            }


            $countWPItem = QuotationWorkpackageTaskcardItem::where('quotation_id', $quotation->id)
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

            $h1s = QuotationWorkPackageTaskCardItem::where('quotation_id', $quotation->id)
                ->where('workpackage_id', $workPackage->id)->get();
            //dd($h1s);

            $real_h1 = 0;
            foreach ($h1s as $h1) {
                $calculate = ($h1->price_amount * $h1->quantity);
                $real_h1 += $calculate;
            }



            $h2s = QuotationWorkPackage::where('quotation_id', $quotation->id)
                ->where('workpackage_id', $workPackage->id)->get();
            $real_h2 = 0;
            foreach ($h2s as $h2) {
                $calculate = ($h2->manhour_rate_amount * $h2->manhour_total);
                $real_h2 += $calculate;
            }

            $getdiscount = QuotationWorkPackage::where('quotation_id', $quotation->id)
                ->where('workpackage_id', $workPackage->id)->first();


            if ($getdiscount != null) {
                //dd($getdiscount);
                if ($getdiscount->discount_type == "percentage") {
                    $h1 = ($getdiscount->discount_value / 100) * $real_h1;
                    $h2 = ($getdiscount->discount_value / 100) * $real_h2;
                    $workPackage->discount = $h1 + $h2;
                } else {
                    $workPackage->discount = $getdiscount->discount_value;
                }
            } else {
                $workPackage->discount = 0;
            }


            $adsb_count = 0;
            $cmrawl_count = 0;
            $eo_count = 0;
            $ea_count = 0;

            $adsbtaskcards = ProjectWorkPackageEOInstruction::with(['eo_instruction'])->where('project_workpackage_id', $project_workpackage->id)->get();
            //dd($adsbtaskcards);
            foreach ($adsbtaskcards as $adsbtaskcard) {
                //dd($adsbtaskcard->eo_instruction->taskcard_id);

                $taskcard =  TaskCard::find($adsbtaskcard->eo_instruction->taskcard_id)->type;
                //dd($taskcard);

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
		// dd($quotation->workpackages[0]->pivot->manhour_rate_amount);
        @$pricehtccr = $parseHtccr->manhour_rate_amount * $parseHtccr->total_manhours_with_performance_factor;
        if (sizeof($htcrrs) > 0) {
            $htcrr_workpackage = new WorkPackage();
            $htcrr_workpackage->code = "Workpackage HT CRR";
            $htcrr_workpackage->title = "Workpackage HT CRR";
            $htcrr_workpackage->htcrrcount = HtCrr::where('project_id', $quotation->quotationable->id)->count();
            $htcrr_workpackage->price = $pricehtccr;
            $htcrr_workpackage->other = $quotation->charge;
            $htcrr_workpackage->data_htcrr = json_decode($quotation->data_htcrr, true);
            $htcrr_workpackage->schedulepayment = $quotation->scheduled_payment_amount;
            $htcrr_workpackage->tax_type = $taxes_type->code;
            $workpackages[sizeof($workpackages)] = $htcrr_workpackage;
        }

        if ($quotation->charge != null){
            $encode = json_decode($quotation->charge);
            $last_index_key = array_key_last($encode);
            $total = 0;
            for ($i=0;$i<=$last_index_key;$i++){
                $total += $encode[$i]->amount;
            }
            //dd($encode[0]->amount);
            $other_workpackage = new WorkPackage();
            $other_workpackage->code = "Other";
            $other_workpackage->title = "Other";
            $other_workpackage->priceother = $total;
            //$htcrr_workpackage->other = $quotation->charge;
            $workpackages[sizeof($workpackages)] = $other_workpackage;
        }





        $data = $alldata = json_decode($workpackages);
        //dump($data);


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
