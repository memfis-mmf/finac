<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\TrxJournal;
use memfisfa\Finac\Model\TrxPayment;
use memfisfa\Finac\Model\TrxPaymentA;
use memfisfa\Finac\Model\TrxPaymentB;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Request\TrxPaymentUpdate;
use memfisfa\Finac\Request\TrxPaymentStore;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Currency;
use App\Models\Type;
use App\Models\GoodsReceived as GRN;
use App\Models\PurchaseOrder as PO;
use App\Models\Approval;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class TrxPaymentController extends Controller
{
    public function index()
    {
        return view('supplierinvoiceview::index');
    }

	public function checkVendor(Request $request)
	{
		$vendor = Vendor::find($request->id_vendor);
		$coa = $vendor->coa->first();

		return $coa;
	}

    public function approve(Request $request)
    {
		DB::beginTransaction();
		try {

			$si_tmp = TrxPayment::where('uuid', $request->uuid);
            $si = $si_tmp->first();

            if ($si->approve) {
                return [
					'errors' => 'Data Already Approved'
                ];
            }

	        $si->approvals()->save(new Approval([
	            'approvable_id' => $si->id,
	            'is_approved' => 0,
	            'conducted_by' => Auth::id(),
	        ]));

			$data_detail = TrxPaymentB::where(
				'transaction_number',
				$si->transaction_number
			)->get();

			$header = (object) [
				'voucher_no' => $si->transaction_number,
				'transaction_date' => $si->transaction_date,
				'coa' => $si->vendor->coa()->first()->id,
			];

            $total_debit = 0;
            $total_credit = 0;
            $detail = [];

            $exchange_rate = $si->exchange_rate;
            if ($si->currencies->code == 'idr') {
                $exchange_rate = 1;
            }

            if (count($data_detail) < 1) {
                return [
                    'errors' => 'Please fill detail first'
                ];
            }

			for ($a=0; $a < count($data_detail); $a++) {
				$x = $data_detail[$a];

				$detail[] = (object) [
					'coa_detail' => $x->coa->id,
					'debit' => $x->total * $exchange_rate,
					'credit' => 0,
					'_desc' => 'Supplier Invoice : '
					.$si->transaction_number.' '
					.$si->vendor->name.'-'
					.$x->description,
				];

				$total_debit += $detail[count($detail)-1]->debit;
            }

            foreach ($si->adjustment as $adjustment_row) {
				$detail[] = (object) [
					'coa_detail' => $adjustment_row->coa->id,
					'debit' => $adjustment_row->debit_idr,
					'credit' => $adjustment_row->credit_idr,
					'_desc' => 'Supplier Invoice : '
					.$si->transaction_number.' '
					.$si->vendor->name.'-'
					.$adjustment_row->description,
				];

				$total_debit += $detail[count($detail)-1]->debit;
				$total_credit += $detail[count($detail)-1]->credit;
            }
            
			// add object in first array $detai
			array_unshift(
				$detail,
				(object) [
					'coa_detail' => $header->coa,
					'credit' => $total_debit - $total_credit,
					'debit' => 0,
					'_desc' => 'Account Payable : '
					.$si->transaction_number.' '
					.$si->vendor->name,
				]
			);

			$si_tmp->update([
				'approve' => 1,
                'transaction_status' => 2,
			]);

			$autoJournal = TrxJournal::autoJournal($header, $detail, 'PRJR', 'BPJ');

			if ($autoJournal['status']) {

				DB::commit();

			}else{

				DB::rollBack();
				return response()->json([
					'errors' => $autoJournal['message']
				]);

			}

	        return response()->json($si);

		} catch (\Exception $e) {

			DB::rollBack();

			$data['errors'] = $e->getMessage();

			return response()->json($data);
		}
    }

    public function create()
    {
        return view('supplierinvoicegeneralview::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required',
            'id_supplier' => 'required',
            'currency' => 'required',
            'exchange_rate' => 'required',
            'closed' => 'required'
        ]);

		DB::beginTransaction();
		$request->merge([
			'id_supplier' => $request->id_supplier,
			'account_code' => Vendor::findOrFail($request->id_supplier)->coa->first()->code,
            'transaction_date' => Carbon::createFromFormat('d-m-Y', $request->transaction_date)
		]);

		$request->request->add([
			'transaction_number' => TrxPayment::generateCode(),
			'x_type' => 'NON GRN',
		]);

        $trxpayment = TrxPayment::create($request->all());

		DB::commit();
        return response()->json($trxpayment);
    }

    public function edit(Request $request)
    {
		$data['data'] = TrxPayment::with([
            'project'
        ])->where(
			'uuid',
			$request->trxpayment
        )->firstOrFail();

		if ($data['data']->approve) {
			return abort(404);
		}

		$data['vendor'] = Vendor::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full'
		)->whereIn('code',['idr','usd'])
		->get();

        return view('supplierinvoicegeneralview::edit', $data);
	}

    public function show(Request $request)
    {
		$data['data'] = TrxPayment::with([
            'project'
        ])->where(
			'uuid',
			$request->trxpayment
        )->firstOrFail();

		$data['vendor'] = Vendor::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full'
		)->whereIn('code',['idr','usd'])
		->get();

        $data['show'] = true;

        return view('supplierinvoicegeneralview::edit', $data);
	}

    public function update(Request $request, TrxPayment $trxpayment)
    {
		if ($trxpayment->approve) {
			return abort(404);
        }

        $request->validate([
            'transaction_date' => 'required',
            'id_supplier' => 'required',
            'closed' => 'required'
        ]);

        $trxpayment_class = new TrxPayment();
        $total = $trxpayment_class->calculateGrandtotalSIGeneral($trxpayment);

		$request->merge([
            'transaction_date' => Carbon::createFromFormat('d-m-Y', $request->transaction_date),
			'description' => $request->description_si,
            'grandtotal_foreign' => $total['total'],
            'grandtotal' => $total['total_idr'],
		]);

        $trxpayment->update($request->all());

        return response()->json($trxpayment);
    }

    public function destroy(TrxPayment $trxpayment)
    {
        $trxpayment->delete();

        return response()->json($trxpayment);
    }

    public function api()
    {
        $trxpaymentdata = TrxPayment::all();

        return json_encode($trxpaymentdata);
    }

    public function apidetail(TrxPayment $trxpayment)
    {
        return response()->json($trxpayment);
    }

    public function datatables(Request $request)
    {
		$data = TrxPayment::with([
			'currencies',
			'vendor',
            'approvals'
		])
        ->select('trxpayments.*');

        if ($request->status and $request->status != 'all') {

            $status = [
                'open' => 0,
                'approved' => 1,
            ];

            $data = $data->where('approve', $status[$request->status]);
        }

        return datatables($data)
            ->filterColumn('transaction_date', function($query, $search) {
                datatables_search_date('transaction_date', $search, $query);
            })
            ->filterColumn('approvals.created_at', function($query, $search) {
                datatables_search_approved_by($search, $query);
            })
            ->filterColumn('created_by', function($query, $search) {
                datatables_search_audits($search, $query);
            })
            ->filterColumn('updated_by', function($query, $search) {
                datatables_search_audits($search, $query);
            })
            ->addColumn('transaction_date_formated', function($row) {
                return $row->transaction_date->format('d-m-Y');
            })
            ->addColumn('grandtotal_foreign_before_adj', function($row) {
                $grandtotal_foreign = $row->grandtotal_foreign;
                $grandtotal_foreign += $row->adjustment()->get()->sum('credit');
                $grandtotal_foreign -= $row->adjustment()->get()->sum('debit');

                return $row->currencies->symbol." ".$this->currency_format($grandtotal_foreign);
            })
            ->addColumn('grandtotal_foreign_formated', function($row) {
                return "<span class='m-badge m-badge--primary m-badge--wide'>{$row->currencies->symbol} {$this->currency_format($row->grandtotal_foreign)}</span>";
            })
            ->addColumn('grandtotal_before_adj', function($row) {
                $grandtotal = $row->grandtotal;
                $grandtotal += $row->adjustment()->get()->sum('credit_idr');
                $grandtotal -= $row->adjustment()->get()->sum('debit_idr');

                return "Rp ".$this->currency_format($grandtotal);
            })
            ->addColumn('grandtotal_formated', function($row) {
                return "<span class='m-badge m-badge--primary m-badge--wide'>Rp {$this->currency_format($row->grandtotal)}</span>";
            })
            ->addColumn('show_url', function($row) {
                $url = route('supplier_invoice.show', $row->uuid);

                if ($row->x_type == 'GRN') {
                    $url = route('supplier_invoice.grn.show', $row->uuid);
                }

                return "<a href='$url'>$row->transaction_number</a>";
            })
            ->addColumn('can_approve_fa', function($row) {
                return $this->canApproveFa();
            })
            ->escapeColumns([])
            ->make(true);
    }

	public function coaUse(Request $request)
	{
        $trxpayment = TrxPayment::where('uuid', $request->si_uuid)->first();

		TrxPaymentB::create([
			'transaction_number' => $trxpayment->transaction_number,
			'code' => $request->account_code,
			'total' => $request->amount,
			'project_id' => $request->project_id,
			'description' => $request->remark,
		]);
	}

	public function coaDatatables(Request $request)
    {
		$trxpayment = TrxPayment::where('uuid', $request->si_uuid)->first();

		$data = $alldata = json_decode(
			TrxPaymentB::where('transaction_number', $trxpayment->transaction_number)
                ->with([
                    'coa',
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
        $trxpayment = TrxPayment::where('uuid', $request->uuid)->firstOrFail();

		$detail = $trxpayment->detail_general()->get()->transform(function($row) {

            $journal_detail = $this->getJournalDetail($row->si->transaction_number, $row->code);
            $row->description = $journal_detail->description_2 ?? $row->description;

            return $row;
        });

		$adjustment = $trxpayment->adjustment;

        $total = 0;
        $total += $trxpayment->detail_general()->get()->sum('total');
        $total += $trxpayment->adjustment()->get()->sum(function($row) {
            return $row->debit - $row->credit;
        });

        $data = [
            'class' => Controller::class,
            'header' => $trxpayment,
            'detail' => $detail,
            'adjustment' => $adjustment,
            'total' => $total,
            'controller' => new Controller()
        ];

        $pdf = \PDF::loadView('formview::supplier-invoice-general', $data);
        return $pdf->stream();
    }

	/*
	 *GRN Section
	 */

    public function grnCreate()
    {
        return view('supplierinvoicegrnview::create');
    }

    public function grnStore(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required',
            'id_supplier' => 'required',
            'currency' => 'required',
            'exchange_rate' => 'required',
            'closed' => 'required'
        ]);

		DB::beginTransaction();
		$request->merge([
			'id_supplier' => $request->id_supplier,
            'transaction_date' => Carbon::createFromFormat('d-m-Y', $request->transaction_date),
            'transaction_number' => TrxPayment::generateCode('GRNT'),
			'x_type' => 'GRN',
			'account_code' => Vendor::find($request->id_supplier)->coa()->first()->code
		]);

        $trxpayment = TrxPayment::create($request->all());
		DB::commit();
        return response()->json($trxpayment);
    }

    public function grnEdit(Request $request)
    {
		$data['data'] = TrxPayment::with([
            'project'
        ])->where(
			'uuid',
			$request->trxpayment
		)->first();

		if ($data['data']->approve) {
			return abort(404);
		}

		$data['vendor'] = Vendor::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full'
		)->whereIn('code',['idr','usd'])
		->get();

        return view('supplierinvoicegrnview::edit', $data);
    }

    public function grnShow(Request $request)
    {
		$data['data'] = TrxPayment::with([
            'project'
        ])->where(
			'uuid',
			$request->trxpayment
		)->first();

		$data['vendor'] = Vendor::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full'
		)->whereIn('code',['idr','usd'])
		->get();

        $data['show'] = true;

        return view('supplierinvoicegrnview::edit', $data);
    }

	public function getVendor()
	{
		$vendor = Vendor::all();

		$type = [];

		for ($i = 0; $i < count($vendor); $i++) {
			$x = $vendor[$i];

			$type[$x->id] = $x->name;
		}

        return json_encode($type, JSON_PRETTY_PRINT);
	}

	public function grnItemsDatatables(Request $request)
    {
		$trxpayment = TrxPayment::where('uuid', $request->si_uuid)->first();

		$data = TrxPaymentA::where(
				'transaction_number', $trxpayment->transaction_number
			)->with([
                'grn',
                'grn.purchase_order'
			])->select('trxpaymenta.*');

        return datatables($data)
            ->escapeColumns([])
            ->make(true);
    }

    public function grnDatatables(Request $request)
    {
        $si = TrxPayment::where('uuid', $request->si_uuid)->firstOrFail();

		$data = GRN::with([
                'purchase_order.purchase_request',
            ])
            ->whereHas('purchase_order', function($po) use($si) {
                $po->where('vendor_id', $si->id_supplier);
            })
            ->has('approvals')
            ->select('goods_received.*');

        return datatables($data)
            ->escapeColumns([])
            ->make();
    }

	public function sumGrnItem($grn_id, $si)
	{
        $grn = GRN::find($grn_id);

        $sum = $grn->total_amount_no_tax;

        $rate = $si->exchange_rate;
        if ($grn->purchase_order->currency->code == 'idr') {
            $rate = 1;
        }

		return (object)[
            'total' => $sum,
            'total_idr' => $sum * $rate,
        ];
	}

	public function grnUse(Request $request)
	{
		DB::beginTransaction();
		$trxpayment = TrxPayment::where('uuid', $request->si_uuid)->first();
		$grn = GRN::where('uuid', $request->uuid)->first();

		// if ($trxpayment->currency != $grn->purchase_order->currency->code) {
		// 	return [
		// 		'errors' => 'currency differences',
		// 	];
		// }

        $trxpaymenta = TrxPaymentA::has('si')->get();

		for ($i=0; $i < count($trxpaymenta); $i++) {
			$x = $trxpaymenta[$i];
			if (
				$x->id_grn == $grn->id &&
				$x->transaction_number != $trxpayment->transaction_number
			) {
				return [
					'errors' => 'GRN already used in other SI',
				];
			}

			if (
				$x->id_grn == $grn->id &&
				$x->transaction_number == $trxpayment->transaction_number
			) {
				return [
					'errors' => 'GRN already used',
				];
			}
        }
        
        if ($grn->purchase_order->vendor_id != $trxpayment->id_supplier) {
            return [
                'errors' => 'Invalid Supplier',
            ];
        }

		$sum_grn_item = $this->sumGrnItem($grn->id, $trxpayment);

        $po_tax = $grn->purchase_order->taxes->first()->percent ?? 0;
		TrxPaymentA::create([
			'transaction_number' => $trxpayment->transaction_number,
			'total' => $sum_grn_item->total,
			'total_idr' => $sum_grn_item->total_idr,
            'tax_percent' => $po_tax,
			'id_grn' => $grn->id,
        ]);

        // $total = TrxPaymentA::where(
        //         'transaction_number',
        //         $trxpayment->transaction_number
        //     )
        //     ->get()
        //     ->sum(function($row) {
        //         return $row->total + ($row->total * ($row->tax_percent / 100));
        //     });

        $total_si = $this->calculate_total_si_grn($trxpayment);

        $request->merge([
            'grandtotal_foreign' => $total_si['foreign'],
            'grandtotal' => $total_si['idr']
        ]);

        $trxpayment->update($request->only([
            'grandtotal_foreign',
            'grandtotal',
        ]));
        
        DB::commit();
	}

    private function calculate_total_si_grn($si)
    {
        $all_currency_detail_si = PurchaseOrder::whereHas('goods_receiveds.trxpaymenta.si', function($si_query) use($si) {
                $si_query->where('id', $si->id);
            })
            ->pluck('currency_id')
            ->toArray();

        $diversity_currency = array_unique($all_currency_detail_si);

        $result = [
            'foreign' => null,
            'idr' => null,
        ];

        // jika semua mata uangnya (currency) sama
        if (count($diversity_currency) == 1) {
            $currency_po = Currency::find($diversity_currency[0]);

            $total = TrxPaymentA::where(
                    'transaction_number',
                    $si->transaction_number
                )
                ->get()
                ->sum(function($row) {
                    return $row->total + ($row->total * ($row->tax_percent / 100));
                });

            if ($currency_po->code == 'idr') {
                $result = [
                    'foreign' => $total / $si->exchange_rate,
                    'idr' => $total
                ];
            } else {
                $result = [
                    'foreign' => $total,
                    'idr' => $total * $si->exchange_rate
                ];
            }
        } else {
            $total_foreign = 0;
            $total_idr = 0;
            foreach ($diversity_currency as $diversity_currency_row) {
                $currency_po = Currency::find($diversity_currency_row);

                $total = TrxPaymentA::where(
                        'transaction_number',
                        $si->transaction_number
                    )
                    ->whereHas('grn.purchase_order', function($po) use($currency_po) {
                        $po->where('currency_id', $currency_po->id);
                    })
                    ->get()
                    ->sum(function($row) {
                        return $row->total + ($row->total * ($row->tax_percent / 100));
                    });

                //jika currency nya IDR
                if ($currency_po->code == 'idr') {
                    $total_foreign += $total / $si->exchange_rate;
                    $total_idr += $total;
                } else {
                    $total_foreign += $total;
                    $total_idr += $total * $si->exchange_rate;
                }
            }

            $result = [
                'foreign' => $total_foreign,
                'idr' => $total_idr
            ];
        }

        return $result;
    }

    public function grnUpdate(Request $request, TrxPayment $trxpayment)
    {
		if ($trxpayment->approve) {
			return abort(404);
        }

        $request->validate([
            'transaction_date' => 'required',
            'id_supplier' => 'required',
            'currency' => 'required',
            'exchange_rate' => 'required',
            'closed' => 'required'
        ]);

		$currency = $request->trxpayment->currency;
		$transaction_number = $request->trxpayment->transaction_number;
		$exchange_rate = $request->trxpayment->exchange_rate;

        $total = TrxPaymentA::where(
                'transaction_number',
                $transaction_number
            )
            ->get()
            ->sum(function($row) {
                return $row->total + ($row->total * ($row->tax_percent / 100));
            });

		if ($currency == 'idr') {
			$request->merge([
				'grandtotal_foreign' => $total,
				'grandtotal' => $total
			]);
		}else{
			$request->merge([
				'grandtotal_foreign' => $total,
				'grandtotal' => ($total*$exchange_rate)
			]);
		}

		$request->merge([
            'transaction_date' => Carbon::createFromFormat('d-m-Y', $request->transaction_date),
			'description' => $request->description_si
		]);

        $trxpayment->update($request->all());

        return response()->json($trxpayment);
    }

    public function grnApprove(Request $request)
    {
        DB::beginTransaction();

        $data = TrxPayment::where('uuid', $request->uuid);
        $si = $data->first();

        if ($si->approve) {
            return [
                'errors' => 'Data Already Approved'
            ];
        }

        $total = TrxPaymentA::where(
                'transaction_number',
                $si->transaction_number
            )
            ->get()
            ->sum(function($row) {
                return $row->total + ($row->total * ($row->tax_percent / 100));
            });

		if ($si->currencies->code == 'idr') {
            $grandtotal_foreign = $total;
            $grandtotal = $total;
		}else{
            $grandtotal_foreign = $total;
            $grandtotal = ($total*$si->exchange_rate);
        }

        $si->approvals()->save(new Approval([
            'approvable_id' => $si->id,
            'is_approved' => 0,
            'conducted_by' => Auth::id(),
        ]));

		$data->update([
			'approve' => 1,
			'transaction_status' => 2,
			'grandtotal_foreign' => $grandtotal_foreign,
			'grandtotal' => $grandtotal,
        ]);
        
        TrxPaymentA::where('transaction_number', $si->transaction_number)
            ->update([
                'transaction_status' => 2,
            ]);

        $generate_journal = $this->grnGenerateJournal($si);

        if (!$generate_journal['status']) {
            return [
                'status' => false,
                'message' => $generate_journal['message'],
                'errors' => $generate_journal['message']
            ];
        }

        DB::commit();

        return response()->json($data->first());
    }

    /**
     * mengenerate journal
     * @param collection $si
     * @return array ['status', 'message']
     */
    private function grnGenerateJournal($si)
    {
        if ($si->currencies == 'idr') {
            return [
                'success' => true,
                'message' => 'SI have no rate GAP'
            ];
        }

        $gap = 0;

        // looping
        foreach ($si->trxpaymenta as $detail_row) {
            $calculate_gap = $this->calculateRateGapGRN($detail_row);

            if (!$calculate_gap['status']) {
                return [
                    'status' => false,
                    'message' => $calculate_gap['message']
                ];
            }

            $gap += $calculate_gap['data']['gap'];
        }

        // jika gap nya 0 maka tidak timbul journal
        if ($gap == 0) {
            return [
                'status' => true,
                'message' => 'Gap 0'
            ];
        }

        $side = 'credit';
        $x_side = 'debit';

        //jika minus maka coa vendor di debit
        if ($gap < 0) {
            $side = 'debit';
            $x_side = 'credit';
        }

        $header = (object) [
            'voucher_no' => $si->transaction_number,
            'transaction_date' => $si->transaction_date,
            'coa' => $si->vendor->coa()->first()->id,
        ];

        $detail[] = (object) [
            'coa_detail' => $si->vendor->coa()->first()->id,
            $side => $gap,
            $x_side => 0,
            '_desc' => 'Gap'
        ];

        $detail[] = (object) [
            'coa_detail' => Coa::where('code', '71112001')->firstOrFail()->id,
            $side => 0,
            $x_side => $gap,
            '_desc' => 'Gap'
        ];

        $autoJournal = TrxJournal::autoJournal(
            $header,
            $detail,
            'IVJR',
            'SRJ'
        );

        if (!$autoJournal['status']) {
            return [
                'status' => false,
                'message' => $autoJournal['message']
            ];
        }

        return [
            'status' => true,
            'message' => 'Auto journal succed'
        ];
    }

    /**
     * menghitung gap detial SI (data GRN) dengan dibandingkan dengan rate PO
     * @param collection $si_detail
     * @return array
     */
    private function calculateRateGapGRN($si_detail)
    {
        //jika PO nya IDR
        if ($si_detail->total == $si_detail->total_idr) {
            return [
                'status' => true,
                'message' => 'SI have no rate GAP',
                'data' => ['gap' => 0]
            ];
        }

        $si_detail_total = $si_detail->total + ($si_detail->total * ($si_detail->tax_percent / 100));
        $si_detail_total_with_currency_si = $si_detail_total * $si_detail->si->exchange_rate;
        $si_detail_total_with_currency_po = $si_detail_total * $si_detail->grn->purchase_order->exchange_rate;

        return [
            'status' => true,
            'message' => 'Calculate Gap',
            'data' => ['gap' => $si_detail_total_with_currency_si - $si_detail_total_with_currency_po]
        ];
    }

    public function grnPrint(Request $request)
    {

        $trxpayment = TrxPayment::where('uuid', $request->uuid)->first();

		$trxpaymenta = TrxPaymentA::where(
            'transaction_number', $trxpayment->transaction_number
        )->with([
            'si',
        ])->get();

        //set foreign vat dan grandtotal
        $si =$trxpayment;
        $all_currency_detail_si = PurchaseOrder::whereHas('goods_receiveds.trxpaymenta.si', function($si_query) use($si) {
                $si_query->where('id', $si->id);
            })
            ->pluck('currency_id')
            ->toArray();

        $diversity_currency = array_unique($all_currency_detail_si);

        $vat = [];
        $grandtotal = [];
        foreach ($diversity_currency as $diversity_currency_row) {
            $currency_po = Currency::find($diversity_currency_row);

            if ($currency_po->code == 'idr') {
                continue;
            }

            $si_detail = TrxPaymentA::where(
                    'transaction_number',
                    $si->transaction_number
                )
                ->whereHas('grn.purchase_order', function($po) use($currency_po) {
                    $po->where('currency_id', $currency_po->id);
                })
                ->get();

            $tax_amount = $si_detail
                ->sum(function($row) {
                    return $row->total * ($row->tax_percent / 100);
                });

            $grandtotal_amount = $si_detail
                ->sum(function($row) {
                    return $row->total + ($row->total * $row->tax_percent / 100);
                });

            $vat[] = [
                'currency' => $currency_po,
                'amount' => $tax_amount
            ];

            $grandtotal[] = [
                'currency' => $currency_po,
                'amount' => $grandtotal_amount
            ];
        }

        $vat_total_amount_idr = 0;
        $grandtotal_amount_idr = 0;

        foreach ($trxpaymenta as $detail_si_row) {
            $vat_total_amount_idr += $detail_si_row->tax_amount_idr;
            $grandtotal_amount_idr += $detail_si_row->total_after_tax_idr;
        }

        $vat[] = [
            'currency' => Currency::where('code', 'idr')->first(),
            'amount' => $vat_total_amount_idr
        ];

        $grandtotal[] = [
            'currency' => Currency::where('code', 'idr')->first(),
            'amount' => $grandtotal_amount_idr
        ];

        $data = [
            'class' => Controller::class,
            'header' => $trxpayment,
            'detail' => $trxpaymenta,
            'total' => 0,
            'vat' => $vat,
            'grandtotal' => $grandtotal,
        ];

        $pdf = \PDF::loadView('formview::supplier-invoice-grn', $data);
        return $pdf->stream();
    }

}
