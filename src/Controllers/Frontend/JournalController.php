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
use App\Models\ARWorkshop;
use App\Models\CashAdvance;
use App\Models\GoodsReceived;
use DataTables;
use App\Models\Project;
use Carbon\Carbon;
use memfisfa\Finac\Model\APayment;
use memfisfa\Finac\Model\AReceive;
use memfisfa\Finac\Model\Asset;
use memfisfa\Finac\Model\Cashbook;
use memfisfa\Finac\Model\Invoice;
use Modules\Workshop\Entities\InvoiceWorkshop\InvoiceWorkshop;

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
			$debit += $x->debit ?? 0;
			$credit += $x->credit ?? 0;
		}

		if (bccomp($debit, $credit, 5) == 0) {
            return true; // balance
        }

        return false; // tidak balance
	}

    public function approve(Request $request)
    {
		$journal = Journal::where('uuid', $request->uuid);
		$journala = $journal->first()->journala;

		if (!$this->checkBalance($journala)) {
			return [
				'errors' => 'Debit and Credit not balance'
			];
		}

		Journal::do_approve($journal);

        return response()->json($journal->first());
    }

    public function unapprove(Request $request)
    {
		$journal = Journal::where('uuid', $request->uuid);
		$journala = $journal->first()->journala;

		if (!$this->checkBalance($journala)) {
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

    public function store(Request $request)
    {
        $request->validate([
			'transaction_date' => 'required',
			'currency_code' => 'required',
			'exchange_rate' => 'required',
			'journal_type' => 'required',
        ]);

		$code = Journal::getJournalCode($request->journal_type);

        $request->merge([
            'transaction_date' => Carbon::createFromFormat('d-m-Y', $request->transaction_date),
            'voucher_no' => Journal::generateCode($code)
        ]);

        $journal = Journal::create($request->all());

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
        $data['currency'] = Currency::whereIn('code', ['usd', 'idr'])
            ->get();

        return view('journalview::edit', $data);
    }

    public function editAfterApprove(Request $request)
    {
        $data['journal']= Journal::where('uuid', $request->journal)->with([
            'type_jurnal',
            'currency',
        ])->firstOrFail();

        $data['journal_type'] = TypeJurnal::all();
        $data['currency'] = Currency::whereIn('code', ['usd', 'idr'])
            ->get();
        $data['journala_after_approve_datatable_url'] = route('journala.datatables.after-approve', ['voucher_no' => $data['journal']->voucher_no]);

        return view('journalview::edit-after-approve', $data);
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

    public function show($uuid_journal)
    {
        $data['journal']= Journal::where('uuid', $uuid_journal)->with([
            'type_jurnal',
            'currency',
        ])->firstOrFail();

        $data['journal_type'] = TypeJurnal::all();
        $data['currency'] = Currency::whereIn('code', ['usd', 'idr'])
            ->get();
        $data['page_type'] = 'show';

        return view('journalview::edit', $data);
    }

    public function setRefLink(Journal $journal)
    {
        $ref_no = explode('-', $journal->ref_no)[0];

        // 1. jika dari cash advance, direct page mengarah pada halaman print out cash advance
        // 2. jika dari invoice, direct page mengarah pada halaman show invoice
        // 3. jika dari cashbook, direct page mengarah pada halaman print out cashbook
        // 4. jika dari AP/AR, direct page mengarah pada halaman print out AP/AR
        // 5. jika dari depr asset, direct page mengarah pada halaman show asset nya
        // 6. jika dari GRN, direct page mengarah pada halaman print out GRN

        switch ($ref_no) {
            case 'CSAD':
                $cash_advance = CashAdvance::where('transaction_number', $journal->ref_no)->first();
                if (!$cash_advance) {
                    return $journal->ref_no;
                }
                $link = route('frontend.cash-advance.show', $cash_advance->uuid);
                break;
            case 'INVC':
                $invoice = Invoice::where('transactionnumber', $journal->ref_no)->first();
                if (!$invoice) {
                    return $journal->ref_no;
                }
                $link = route('invoice.show', $invoice->uuid);
                break;
            case 'IVSL':
                $invoice = InvoiceWorkshop::where('invoice_no', $journal->ref_no)->first();
                if (!$invoice) {
                    return $journal->ref_no;
                }
                $link = route('frontend.invoice-workshop.show', $invoice->uuid);
                break;
            case 'CBPJ':
                $cashbook = Cashbook::where('transactionnumber', $journal->ref_no)->first();
                if (!$cashbook) {
                    return $journal->ref_no;
                }
                $link = route('cashbook.print', ['uuid' => $cashbook->uuid]);
                break;
            case 'CBRJ':
                $cashbook = Cashbook::where('transactionnumber', $journal->ref_no)->first();
                if (!$cashbook) {
                    return $journal->ref_no;
                }
                $link = route('cashbook.print', ['uuid' => $cashbook->uuid]);
                break;
            case 'CCPJ':
                $cashbook = Cashbook::where('transactionnumber', $journal->ref_no)->first();
                if (!$cashbook) {
                    return $journal->ref_no;
                }
                $link = route('cashbook.print', ['uuid' => $cashbook->uuid]);
                break;
            case 'CCRJ':
                $cashbook = Cashbook::where('transactionnumber', $journal->ref_no)->first();
                if (!$cashbook) {
                    return $journal->ref_no;
                }
                $link = route('cashbook.print', ['uuid' => $cashbook->uuid]);
                break;
            case 'BPYJ':
                $ap = APayment::where('transactionnumber', $journal->ref_no)->first();
                if (!$ap) {
                    return $journal->ref_no;
                }
                $link = route('apayment.print', ['uuid' => $ap->uuid]);
                break;
            case 'CPYJ':
                $ap = APayment::where('transactionnumber', $journal->ref_no)->first();
                if (!$ap) {
                    return $journal->ref_no;
                }
                $link = route('apayment.print', ['uuid' => $ap->uuid]);
                break;
            case 'BRCJ':
                $ar = AReceive::where('transactionnumber', $journal->ref_no)->first();
                $ar_workshop = ARWorkshop::where('transactionnumber', $journal->ref_no)->first();
                if (!$ar and !$ar_workshop) {
                    return $journal->ref_no;
                }
                if ($ar) {
                    $link = route('areceive.print', ['uuid' => $ar->uuid]);
                } else {
                    $link = route('frontend.account-receivable-workshop.print', ['uuid' => $ar_workshop->uuid]);
                }

                break;
            case 'CRCJ':
                $ar = AReceive::where('transactionnumber', $journal->ref_no)->first();
                $ar_workshop = ARWorkshop::where('transactionnumber', $journal->ref_no)->first();
                if (!$ar and !$ar_workshop) {
                    return $journal->ref_no;
                }
                if ($ar) {
                    $link = route('areceive.print', ['uuid' => $ar->uuid]);
                } else {
                    $link = route('frontend.account-receivable-workshop.print', ['uuid' => $ar_workshop->uuid]);
                }

                break;
            case 'FAMS':
                $asset = Asset::where('transaction_number', $journal->ref_no)->first();
                if (!$asset) {
                    return $journal->ref_no;
                }
                $link = route('asset.show', $asset->uuid);
                break;
            case 'GRNI':
                $grn = GoodsReceived::where('number', $journal->ref_no)->first();
                if (!$grn) {
                    return $journal->ref_no;
                }
                $link = route('frontend.goods-received.print', $grn->uuid);
                break;
            
            default:
                return $journal->ref_no;
                break;
        }

        return "<a href='{$link}'>{$journal->ref_no}</a>";
    }

    public function datatables(Request $request)
    {
        ini_set('max_execution_time', -1); 
        ini_set("memory_limit",-1);

		$data = Journal::with([
                'type_jurnal:id,name',
                'currency',
            ])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'asc')
            ->select('trxjournals.*');
        
        if ($request->daterange) {
            $date = explode(' - ', $request->daterange);
            $start_date = Carbon::createFromFormat('d-m-Y', $date[0])->startOfDay();
            $end_date = Carbon::createFromFormat('d-m-Y', $date[1])->endOfDay();

            $data = $data->whereBetween('transaction_date', [$start_date, $end_date]);
        }

        if ($request->status and $request->status != 'all') {

            $status = [
                'open' => 0,
                'approved' => 1,
            ];

            $data = $data->where('approve', $status[$request->status]);
        }
        
        return datatables($data)
            ->addColumn('transaction_date_formated', function($row) {
                return $row->transaction_date->format('d-m-Y');
            })
            ->addColumn('voucher_no_formated', function($row) {
                return '<a href="'.route('journal.show', $row->uuid).'">'
                            .$row->voucher_no
                        .'</a>';
            })
            ->addColumn('ref_no_link', function($row) {
                return $this->setRefLink($row);
            })
            ->addColumn('type_jurnal_name', function($row) {
                return $row->type_jurnal->name;
            })
            ->addColumn('total_transaction', function($row) {
                return $row->total_transaction;
            })
            ->addColumn('status', function($row) {
                return $row->status;
            })
            ->addColumn('created_by', function($row) {
                return $row->created_by;
            })
            ->addColumn('updated_by', function($row) {
                return $row->updated_by;
            })
            ->addColumn('approved_by', function($row) {
                return $row->approved_by;
            })
            ->addColumn('action', function($row) use($request) {
                $html =
                    '<a 
                        href="'.route('journal.print', ['uuid' => $row->uuid]).'" 
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill print" 
                        title="Print" 
                        data-id="'.$row->uuid.'">
                        <i class="la la-print"></i>
                    </a>';

                if (!$row->approve) {
                    $html .=
                        '<a 
                            href="'.route('journal.edit', $row->uuid).'" 
                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" 
                            title="Edit" 
                            data-uuid='.$row->uuid.'>
                            <i class="la la-pencil"></i>
                        </a>';

                    $html .=
                        '<a 
                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" 
                            href="#" 
                            data-uuid=' . $row->uuid . ' 
                            title="Delete">
                            <i class="la la-trash"></i> 
                        </a>';
                    
                    if ($this->canApproveFa()) {
                        $html .=
                            '<a 
                                href="javascript:;" 
                                class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" 
                                title="Approve" 
                                data-uuid="' . $row->uuid . '">
                                <i class="la la-check"></i>
                            </a>';
                    }

                }

                if ($row->approve) {
                    $html .=
                        '<a 
                            href="'.route('journal.edit-after-approve', $row->uuid).'" 
                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" 
                            title="Edit Description" 
                            data-uuid='.$row->uuid.'>
                            <i class="fa fa-pen-nib"></i>
                        </a>';

                    if (auth()->user()->hasRole('admin')) {
                        $html .= 
                        '<a 
                            href="javascript:;"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill unapprove"
                            title="Unapprove" data-uuid="'.$row->uuid.'">
                            <i class="fa fa-times"></i>
                        </a>';
                    }
                }


                return ($html);
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

        if (count($journala) < 1) {
            return redirect()->route('journal.index')->with(['errors' => 'Please add detail']);
        }

        foreach ($journala as $journala_row) {
            if ($journala_row->debit == 0 and $journala_row->credit == 0) {
                continue;
            }
            $journal_detail[] = $journala_row;
        }

        $journala = $journal_detail;

		if (!$this->checkBalance($journala)) {
            return redirect()->route('journal.index')->with(['errors' => 'Debit and Credit not balance']);
		}

		$debit = 0;
		$credit = 0;

		for ($i = 0; $i < count($journala); $i++) {
			$x = $journala[$i];
			$debit += $x->debit ?? 0;
			$credit += $x->credit ?? 0;
		}

		$data = [
			'journal' => $journal,
			'journala' => $journala,
			'debit' => $debit,
			'credit' => $credit,
            'carbon' => Carbon::class
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
        ->limit(50)
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

        $projects = Project::with([
                'aircraft', 
                'customer', 
                'approvals', 
            ])
            ->where('code', 'like', "%$q%")
            ->whereIn('status', ['Quotation Approved', 'Project Approved'])
            // ->has('approvals', 2)
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();

        $data['results'] = [];
        
        foreach ($projects as $project_row) {
            $data['results'][] = [
                'id' => $project_row->id,
                'text' => $project_row->code
            ];
        }

		return $data;
	}
}
