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
use App\Models\Quotation;
use Carbon\Carbon;
use App\Models\HtCrr;
use App\Models\WorkPackage;
use App\Models\QuotationHtcrrItem;
use App\Models\Pivots\QuotationWorkPackage;
use App\Models\ProjectWorkPackageEOInstruction;
use App\Models\ProjectWorkPackageFacility;
use App\Models\ProjectWorkPackageTaskCard;
use App\Models\QuotationWorkPackageTaskCardItem;
use App\Models\TaskCard;
use App\Models\Type;
use App\Models\Department;
use App\Helpers\CalculateQuoPrice;
use App\Http\Controllers\Frontend\CashAdvanceController;
use App\Models\AdvancePaymentBalance;
use App\Models\CashAdvance;
use App\Models\Pivots\ProjectWorkpackage;
use App\Models\Project;
use App\Models\QuotationDefectCardItem;
use memfisfa\Finac\Model\Invoicetotalprofit;
use memfisfa\Finac\Model\TrxJournal;
use stdClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

//use for export
use memfisfa\Finac\Model\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    private $qn_select_column = [
        'quotations.id',
        'quotations.number',
        'quotations.parent_id',
        'quotations.quotationable_type',
        'quotations.quotationable_id',
        'quotations.attention',
        'quotations.requested_at',
        'quotations.valid_until',
        'quotations.currency_id',
        'quotations.term_of_payment',
        'quotations.exchange_rate',
        'quotations.subtotal',
        'quotations.charge',
        'quotations.grandtotal',
        'quotations.title',
        'quotations.no_wo',
        'quotations.scheduled_payment_type',
        'quotations.scheduled_payment_amount',
        'quotations.term_of_payment',
        'quotations.description',
        'quotations.data_defectcard',
        'quotations.data_htcrr',
        'quotations.additionals',
    ];

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
        $data['today'] = Carbon::today()->toDateString();

        $departments = Department::with('type', 'parent')->get();

        $data['company'] = $departments;
        $data['coa_default'] = (object) [
            'manhours' => Coa::where('code', '41111001')->first(),
            'material' => Coa::where('code', '41114001')->first(),
            'facility' => Coa::where('code', '41113001')->first(),
            'discount' => Coa::where('code', '41121001')->first(),
            'ppn' => Coa::where('code', '21115005')->first(),
            'other' => Coa::where('code', '41114003')->first(),
        ];

        return view('invoiceview::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        $quotation = Quotation::where('number', $request->quotation)->first();

        if (!in_array($quotation->status, ['Approved', 'RTS', 'Closing W/O RTS'])) {
            return [
                'error' => 'Quotation status is not Approved'
            ];
        }

        if (Invoice::where('id_quotation', $quotation->id)->first()) {
            return [
                'error' => 'Quotation alredy in use'
            ];
        }

        $schedule_payment = json_decode($quotation->scheduled_payment_amount);

        if (!@$schedule_payment[0]->amount_percentage) {
            return [
                'error' => 'amount percentage cannot be null'
            ];
        }
        $end_sp = array_key_last($schedule_payment);         // move the internal pointer to the end of the array
        $last_sp = $end_sp + 1;
        $percent_sp = $schedule_payment[$last_sp - 1]->amount_percentage;

        $project = $quotation->quotationable()->first();
        $customer = Customer::with(['levels', 'addresses'])->where('id', '=', $project->customer_id)->first();

        $currency = Currency::where('code', $request->currency)->first();

        $coa = Coa::where('code', $customer->coa()->first()->code)->first();
        $material = Coa::where('code', $request->material)->first();
        $manhours = Coa::where('code', $request->manhours)->first();
        $facility = Coa::where('code', $request->facility)->first();
        $discount = Coa::where('code', $request->discount)->first();
        $ppn = Coa::where('code', $request->ppn)->first();

        $others = Coa::where('code', $request->other)->first();

        if (!$request->bank) {
            return [
                'error' => 'Please fill first bank'
            ];
        }

        $bankaccount = BankAccount::where('uuid', $request->bank)->first()->id;
        $bankaccount2 = NULL;

        if ($request->bank2) {
            $bankaccount2 = BankAccount::where('uuid', $request->bank2)
                ->first()->id;
        }

        $bankaccount3 = NULL;
        if ($request->bank3) {
            $bankaccount3 = BankAccount::where('uuid', $request->bank3)
                ->first()->id;
        }

        $id_branch = 1;
        $closed = 0;
        $transaction_number = Invoice::generateCode();
        $transaction_date = Carbon::createFromFormat('d-m-Y', $request->date);
        $customer_id = $customer->id;
        $currency_id = $currency->id;
        $quotation_id = $quotation->id;
        $exchange_rate = $request->exchange_rate;
        $attention = [];
        $attention['name'] = $request->attention;
        $attention['phone'] = $request->phone;
        $attention['address'] = $request->address;
        $attention['fax'] = $request->fax;
        $attention['email'] = $request->email;
        $fix_attention = json_encode($attention);
        $description = $request->description;
        $term_and_condition = $request->term_and_condition;

        // calculate

        // total sebelum dihitung-hitung
        $subtotal_val = $request->subtotal_val;
        $discount_val = $request->discount_val;
        $discount_percent_val = 0;
        if ($discount_val) {
            $discount_percent_val = ($discount_val / $subtotal_val) * 100;
        }
        $total_val = $request->total_val;
        $other_price_val = $request->other_price_val;
        $htcrr_price_val = $request->htcrr_price_val;
        $tax_total_val = $request->tax_total_val;
        $tax_percent_val = 0;
        if ($tax_total_val) {
            $tax_percent_val = ($tax_total_val / $total_val) * 100;
        }
        // total setelah dihitung-hitung (vat, discount, dll)
        $grandtotal_val = $request->grandtotal_val;
        $grandtotal_rp_val = $request->grandtotalrp_val;

        $invoice = Invoice::create([
            'id_branch' => $id_branch,
            'closed' => $closed,
            'id_quotation' => $quotation_id,
            'transactionnumber' => $transaction_number,
            'transactiondate' => $transaction_date,
            'id_customer' => $customer_id,
            'currency' => $currency_id,
            'exchangerate' => $exchange_rate,
            'schedule_payment' => $request->schedule_payment,
            'id_bank' => $bankaccount,
            'id_bank2' => $bankaccount2,
            'id_bank3' => $bankaccount3,
            'accountcode' => $coa->id,
            'description' => $description,
            'term_and_condition' => $term_and_condition,
            'attention' => $fix_attention,
            'presdir' => $request->presdir,
            'location' => $request->location,
            'company_department' => $request->company_department,
            'subtotal' => $subtotal_val,
            'total' => $total_val,
            'discountpercent' => $discount_percent_val,
            'discountvalue' => $discount_val,
            'ppnpercent' => $tax_percent_val,
            'ppnvalue' => $tax_total_val,
            'other_price' => $other_price_val,
            'grandtotalforeign' => $grandtotal_val,
            'grandtotal' => $grandtotal_val * $exchange_rate,
        ]);

        // if ($request->cash_advance_id) {
        //     $cash_advance_controller = new CashAdvanceController();

        //     $cash_advance = CashAdvance::findOrFail($request->cash_advance_id);

        //     $cash_advance_controller->check_cash_advance($invoice, $customer, $cash_advance, $project);

        //     $invoice->cash_advance()->attach($request->cash_advance_id);
        // }

        $list = [
            'manhours' => $request->manhoursprice,
            'manhours_percent' => $percent_sp,
            'manhours_calc' => ($percent_sp / 100),
            'manhours_result' =>  $request->manhoursprice,
            'material' => $request->materialprice,
            'material_percent' => $percent_sp,
            'material_calc' => ($percent_sp / 100),
            'material_result' =>  $request->materialprice,
            'facility' => $request->facilityprice,
            'facility_percent' => $percent_sp,
            'facility_calc' => ($percent_sp / 100),
            'facility_result' =>  $request->facilityprice,
            'others' => $request->otherprice,
            'others_percent' => $percent_sp,
            'others_calc' => ($percent_sp / 100),
            'others_result' =>  $request->otherprice,

        ];

        $manhours_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $manhours->id,
            'amount' => $request->manhoursprice,
            'type' => 'manhours'
        ]);

        $material_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $material->id,
            'amount' => $request->materialprice,
            'type' => 'material'
        ]);

        $facility_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $facility->id,
            'amount' => $request->facilityprice,
            'type' => 'facility'
        ]);

        $discount_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $discount->id,
            'amount' => $discount_val,
            'type' => 'discount'
        ]);

        $ppn_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $ppn->id,
            'amount' => $tax_total_val,
            'type' => 'ppn'
        ]);

        $others_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $others->id,
            'amount' => $other_price_val,
            'type' => 'others'
        ]);

        $others_ins = Invoicetotalprofit::create([
            'invoice_id' => $invoice->id,
            'accountcode' => $manhours->id,
            'amount' => $htcrr_price_val,
            'type' => 'htcrr'
        ]);

        // if ($invoice->grandtotalforeign != $invoice->totalprofit()->sum('amount')) {
        //     return [
        //         'error' => 'Total Invoice and Total Quotation are different'
        //     ];
        // }

        // return [
        // 	'error' => Invoicetotalprofit::select('amount')->get(),
        // 	'all_request' => $request->all()
        // ];

        DB::commit();

        return response()->json($invoice);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_uuid)
    {
        $invoice = Invoice::where('uuid', $invoice_uuid)->firstOrFail();

        $quotation = Quotation::where('id', $invoice->id_quotation)->first();
        $currency = $invoice->currencies;
        $coa = $invoice->coas;
        $material = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'material')->first();
        $material_id = Coa::where('id', $material->accountcode)->first();
        $manhours = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'manhours')->first();
        $manhours_id = Coa::where('id', $manhours->accountcode)->first();
        $facility = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'facility')->first();
        $facility_id = Coa::where('id', $facility->accountcode)->first();
        $discount = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'discount')->first();
        $discount_id = Coa::where('id', $discount->accountcode)->first();
        $ppn = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'ppn')->first();
        $ppn_id = Coa::where('id', $ppn->accountcode)->first();

        $others = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'others')->first();
        $others_id = Coa::where('id', $others->accountcode)->first();

        $bankAccountget = BankAccount::where('id', $invoice->id_bank)->first();
        $bankget = Bank::where('id', $bankAccountget->bank_id)->first();

        $bankAccountget2 = BankAccount::where('id', $invoice->id_bank2)->first();
        @$bankget2 = Bank::where('id', $bankAccountget2->bank_id)->first();

        $bank = BankAccount::where('internal_account', 1)->selectRaw('uuid, CONCAT(name, " (", number ,")") as full,id')->get();

        $departments = Department::with('type', 'parent')->get();

        $company = $departments;

        $data = [
            'today' => $invoice->transactiondate,
            'quotation' => $quotation,
            'coa' => $coa,
            'manhours' => $manhours_id,
            'material' => $material_id,
            'facility' => $facility_id,
            'discount' => $discount_id,
            'ppn' => $ppn_id,
            'others' => $others_id,
            'invoice' => $invoice,
            'banks' => $bank,
            'bankaccountget' => $bankAccountget,
            'bankget' => $bankget,
            'bankaccountget2' => $bankAccountget2,
            'bankget2' => $bankget2,
            'company' => $company,
            'currencycode' => $currency,
            'page_type' => 'show'
        ];

        return view('invoiceview::edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        if ($invoice->approve) {
            return abort(404);
        }
        //dd($invoice->transactiondate);
        $quotation = Quotation::where('id', $invoice->id_quotation)->first();
        $currency = $invoice->currencies;
        $coa = $invoice->coas;
        //dd($invoice->id);
        $material = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'material')->first();
        $material_id = Coa::where('id', $material->accountcode)->first();
        $manhours = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'manhours')->first();
        $manhours_id = Coa::where('id', $manhours->accountcode)->first();
        $facility = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'facility')->first();
        $facility_id = Coa::where('id', $facility->accountcode)->first();
        $discount = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'discount')->first();
        $discount_id = Coa::where('id', $discount->accountcode)->first();
        $ppn = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'ppn')->first();
        $ppn_id = Coa::where('id', $ppn->accountcode)->first();

        $others = Invoicetotalprofit::where('invoice_id', $invoice->id)->where('type', 'others')->first();
        $others_id = Coa::where('id', $others->accountcode)->first();

        $bankAccountget = BankAccount::where('id', $invoice->id_bank)->first();
        $bankget = Bank::where('id', $bankAccountget->bank_id)->first();

        $bankAccountget2 = BankAccount::where('id', $invoice->id_bank2)->first();
        @$bankget2 = Bank::where('id', $bankAccountget2->bank_id)->first();

        $bankAccountget3 = BankAccount::where('id', $invoice->id_bank3)->first();
        @$bankget3 = Bank::where('id', $bankAccountget3->bank_id)->first();

        $bank = BankAccount::where('internal_account', 1)->selectRaw('uuid, CONCAT(name, " (", number ,")") as full,id')->get();

        $collection = collect();

        $departments = Department::with('type', 'parent')->get();

        $company = $departments;

        return view('invoiceview::edit')
            ->with('today', $invoice->transactiondate)
            ->with('quotation', $quotation)
            ->with('coa', $coa)
            ->with('manhours', $manhours_id)
            ->with('material', $material_id)
            ->with('facility', $facility_id)
            ->with('discount', $discount_id)
            ->with('ppn', $ppn_id)
            ->with('others', $others_id)
            ->with('invoice', $invoice)
            ->with('banks', $bank)
            ->with('bankaccountget', $bankAccountget)
            ->with('bankget', $bankget)
            ->with('bankaccountget2', $bankAccountget2)
            ->with('bankget2', $bankget2)
            ->with('bankaccountget3', $bankAccountget3)
            ->with('bankget3', $bankget3)
            ->with('company', $company)
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
        if ($invoice->approve) {
            return abort(404);
        }
        $currency = Currency::where('name', $request->currency)->first();
        // $coa = Coa::where('code', $request->coa)->first();

        $bankaccount = BankAccount::where('uuid', $request->_bankinfo)
            ->first()->id;

        $bankaccount2 = NULL;

        if ($request->_bankinfo2) {
            $bankaccount2 = BankAccount::where('uuid', $request->_bankinfo2)
                ->first()->id;
        }

        $bankaccount3 = NULL;

        if ($request->_bankinfo3) {
            $bankaccount3 = BankAccount::where('uuid', $request->_bankinfo3)
                ->first()->id;
        }

        $subtotal = $invoice->grandtotalforeign / 1.1;

        $currency_id = $currency->id;
        $exchange_rate = $request->exchangerate;
        $discount_value = $invoice->discountvalue;
        $percent = $discount_value / $subtotal;
        $percent_friendly = number_format($percent * 100);
        $ppn_percent = 10;
        $ppn_value = $request->pphvalue; //this ppnvalue get data from pph and i don't understand why...
        $grandtotalfrg = $request->grand_total;
        $grandtotalidr = $invoice->grandtotalforeign * $request->exchangerate;
        $transaction_date = Carbon::createFromFormat('d-m-Y', $request->date);
        $description = $request->description;
        $term_and_condition = $request->term_and_condition;

        // if ($request->cash_advance_id) {
        //     $cash_advance_controller = new CashAdvanceController();

        //     $cash_advance = CashAdvance::findOrFail($request->cash_advance_id);

        //     $cash_advance_controller->check_cash_advance($invoice, $invoice->customer, $cash_advance, $invoice->quotation->quotationable()->first());

        //     $invoice->cash_advance()->detach();
        //     $invoice->cash_advance()->attach($request->cash_advance_id);
        // }

        $invoice1 = Invoice::where('id', $invoice->id)
            ->update([
                'currency' => $currency_id,
                'exchangerate' => $exchange_rate,
                // 'discountpercent' => $percent_friendly,
                // 'discountvalue' => $discount_value,
                // 'ppnpercent' => $ppn_percent,
                // 'ppnvalue' => $ppn_value,
                'id_bank' => $bankaccount,
                'id_bank2' => $bankaccount2,
                'id_bank3' => $bankaccount3,
                // 'grandtotalforeign' => $grandtotalfrg,
                'grandtotal' => $grandtotalidr,
                // 'accountcode' => $coa->id,
                'description' => $description,
                'term_and_condition' => $term_and_condition,
                'presdir' => $request->presdir,
                'location' => $request->location,
                'company_department' => $request->company_department,
                'transactiondate' => $transaction_date,
            ]);

        $manhours_ins = Invoicetotalprofit::where('type', 'manhours')
            ->where('invoice_id', $invoice->id)
            ->update([
                'accountcode' => Coa::where('code', $request->manhours)->first()->id,
            ]);

        $manhours_ins = Invoicetotalprofit::where('type', 'material')
            ->where('invoice_id', $invoice->id)
            ->update([
                'accountcode' => Coa::where('code', $request->material)->first()->id,
            ]);

        $manhours_ins = Invoicetotalprofit::where('type', 'facility')
            ->where('invoice_id', $invoice->id)
            ->update([
                'accountcode' => Coa::where('code', $request->facility)->first()->id,
            ]);

        $manhours_ins = Invoicetotalprofit::where('type', 'discount')
            ->where('invoice_id', $invoice->id)
            ->update([
                'accountcode' => Coa::where('code', $request->discount)->first()->id,
            ]);

        $manhours_ins = Invoicetotalprofit::where('type', 'ppn')
            ->where('invoice_id', $invoice->id)
            ->update([
                'accountcode' => Coa::where('code', $request->ppn)->first()->id,
            ]);

        $manhours_ins = Invoicetotalprofit::where('type', 'others')
            ->where('invoice_id', $invoice->id)
            ->update([
                'accountcode' => Coa::where('code', $request->other)->first()->id,
            ]);

        return redirect()->route('invoice.index')->with([
            'success' => 'data updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->approve) {
            return abort(404);
        }
        $invoice->cash_advance()->detach();
        $invoice->delete();
        return response()->json($invoice);
    }

    public function approve(Invoice $invoice)
    {
        DB::beginTransaction();

        if ($invoice->approve) {
            return [
                'status' => false,
                'message' => 'Invoice Already Approved'
            ];
        }

        $invoice->approvals()->save(new Approval([
            'approvable_id' => $invoice->id,
            'is_approved' => 0,
            'conducted_by' => Auth::id(),
        ]));

        $data_detail = Invoicetotalprofit::where('invoice_id', $invoice->id)
            ->get();

        $header = (object) [
            'voucher_no' => $invoice->transactionnumber,
            // 'transaction_date' => $date_approve,
            'transaction_date' => $invoice->transactiondate,
            'coa' => $invoice->customer->coa()->first()->id,
        ];

        $vat_type = $invoice->quotations->taxes[0]->TaxPaymentMethod->code;

        $divider = 1;

        $total_credit = 0;
        foreach ($data_detail as $detail_row) {

            if ($vat_type == 'include') {
                $divider = 1.1;
            }

            $amount = $detail_row->amount;
            if ($detail_row->type == 'discount') {
                $amount = abs($detail_row->amount) * -1;
            }

            if (
                $detail_row->type == 'ppn'
                || $detail_row->type == 'others' 
            ) {
                $divider = 1;
            }

            $credit = ($amount / $divider) * $invoice->exchangerate;

            $detail[] = (object) [
                'coa_detail' => $detail_row->accountcode,
                'credit' => $credit,
                'debit' => 0,
                '_desc' => 'Income : '
                    . $detail_row->invoice->transactionnumber . ' '
                    . $detail_row->invoice->customer->name,
            ];

            $total_credit += $credit;
        }

        if ($invoice->grandtotal != $total_credit) {
            if (abs($invoice->grandtotal - $total_credit) < 0.9) {
                $invoice->grandtotal = $total_credit;
            }
        }

        // detail piutang
        $detail[] = (object) [
            'coa_detail' => $header->coa,
            'credit' => 0,
            'debit' => $invoice->grandtotal,
            '_desc' => 'Account Receivable : '
                . $invoice->transactionnumber . ' '
                . $invoice->customer->name,
        ];

        // if ($invoice->grandtotal != $total_credit && $vat_type == 'include') {
        //     $coa_diff = Coa::where('code', '71112001')->first();
        //     if (!$coa_diff) {
        //         return [
        //             'errors' => 'Coa (Cash Balances Differential) not found'
        //         ];
        //     }

        //     $detail[] = (object) [
        //         'coa_detail' => $coa_diff->id,
        //         'credit' => 0,
        //         'debit' => ($invoice->grandtotal - $total_credit) * -1,
        //         '_desc' => 'Differential : '
        //             . $invoice->transactionnumber . ' '
        //             . $invoice->customer->name,
        //     ];
        // }

        $autoJournal = TrxJournal::autoJournal(
            $header,
            $detail,
            'IVJR',
            'SRJ'
        );

        Invoice::where('id', $invoice->id)->update([
            'approve' => 1,
            'transaction_status' => 2
        ]);

        if (!$autoJournal['status']) {
            return [
                'status' => false,
                'message' => $autoJournal['message']
            ];
        }

        if ($invoice->cash_advance_id) {

            $cash_advance_controller = new CashAdvanceController();

            foreach ($invoice->cash_advance ?? [] as $cash_advance) {
                $cash_advance_controller->check_cash_advance($invoice, $invoice->customer, $cash_advance, $invoice->quotation->quotationable()->first());
            }

            $ar_controller = new ARController();
            $ar_controller->generate_ar($invoice);
        }

        DB::commit();

        return [
            'status' => true,
            'message' => 'Data Approved'
        ];
    }

    public function quodatatables()
    {
        ini_set('memory_limit', '-1');
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
                    $filter = str_replace('/', '\/', $filter);
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

        $quotations = Quotation::whereHas('approvals')
            ->whereIn('status', ['Approved', 'RTS', 'Closing W/O RTS'])
            ->whereDoesntHave('invoice')
            ->get();

        //dd($quotations);

        foreach ($quotations as $quotation) {
            if (!empty($quotation->approvals->toArray())) {
                $approval = $quotation->approvals->toArray();
                $quotation->status .= 'Approved';
            } else {
                $quotation->status .= '';
            }
            $project = $quotation->quotationable->toArray();
            $cust = Customer::where('id', $project['customer_id'])->first();
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

    public function datatables(Request $request)
    {
        $data = Invoice::with([
                'customer',
                'currencies',
                'quotations:id,uuid,number',
            ])
            ->select('invoices.*');

        if ($request->status and $request->status != 'all') {

            $status = [
                'closed' => 0,
                'open' => 1,
                'approved' => 2,
            ];

            $data = $data->where('transaction_status', $status[$request->status]);

        }

        return datatables($data)
            ->filterColumn('transactiondate', function($query, $search) {
                datatables_search_date('transactiondate', $search, $query);
            })
            ->filterColumn('approved_by', function($query, $search) {
                datatables_search_approved_by($search, $query);
            })
            ->filterColumn('created_by', function($query, $search) {
                datatables_search_audits($search, $query);
            })
            ->filterColumn('updated_by', function($query, $search) {
                datatables_search_audits($search, $query);
            })
            ->addColumn('transactiondate_formated', function($row) {
                return $row->transactiondate->format('F d, Y');
            })
            ->addColumn('transaction_number_link', function($row) {
                return '<a href="'.route('invoice.show', $row->uuid).'">'.$row->transactionnumber.'</a>';
            })
            ->addColumn('created_by', function($row) {
                return $row->created_by;
            })
            ->addColumn('can_approve_fa', function($row) {
                return $this->canApproveFa();
            })
            ->addColumn('export_url', function($row) {
                return route('invoice.export')."?uuid={$row->uuid}";
            })
            ->addColumn('grandtotalforeign_formated', function($row) {
                return $this->currency_format($row->grandtotalforeign);
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function apidetail($uuid_quotation)
    {
        $quotation = Quotation::where('uuid', $uuid_quotation)
            ->select([
                'id',
                'uuid',
                'number',
                'parent_id',
                'quotationable_type',
                'quotationable_id',
                'attention',
                'requested_at',
                'valid_until',
                'currency_id',
                'term_of_payment',
                'exchange_rate',
                'subtotal',
                'charge',
                'grandtotal',
                'title',
                'no_wo',
                'scheduled_payment_type',
                'scheduled_payment_amount',
                'term_of_payment',
                'term_of_condition',
                'description',
                'data_defectcard',
                'data_htcrr',
                'additionals',
                'status',
            ])
            ->firstOrFail();
        $project = $quotation->quotationable_type::where('id', $quotation->quotationable_id)
            ->select([
                'code',
                'parent_id',
                'title',
                'customer_id',
                'aircraft_id',
                'no_wo',
                'aircraft_register',
                'aircraft_sn',
                'data_defectcard',
                'data_htcrr',
                'station',
                'csn',
                'cso',
                'tsn',
                'tso',
                'status',
            ])
            ->first();

        $currency = $quotation->currency()->first();
        $invoicecount = Invoice::where('id_quotation', $quotation->id)->count();
        $schedule_payment = json_decode($quotation->scheduled_payment_amount);
        //dd($schedule_payment);
        $end_sp = array_key_last($schedule_payment);         // move the internal pointer to the end of the array
        $last_sp = $end_sp + 1;
        //$workpackages =
        //dd($project->customer_id);
        $customer = Customer::with(['levels', 'addresses'])->where('id', '=', $project->customer_id)->first();
        //dd($customer);
        $quotation->project .= $project;
        $quotation->customer .= $customer;
        $quotation->currency .= $currency;
        $quotation->spcount .= $last_sp;
        $quotation->invoicecount .= $invoicecount;

        $quotation->attention_cust .= $customer->attention;
        $quotation->attention_quo .= $quotation->attention;

        $quo_invoice = Invoice::where('id_quotation', $quotation->id)->first();

        $quotation->duplicate = false;

        if ($quo_invoice) {
            $quotation->duplicate = true;
        }

        return response()->json($quotation);
    }

    public function calculateQuo(Request $request)
    {
        $quotation = Quotation::where('uuid', $request->uuid_quo)->with([
            'workpackages',
            'promos',
            'currency',
            'taxes',
            'taxes.TaxPaymentMethod',
        ])->first();

        $calculate = CalculateQuoPrice::calculate($quotation, $request->invoice_currency);

        return $calculate;
    }

    public function table(Quotation $quotation)
    {
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);

        $workpackages = $quotation->workpackages()
            ->select([
                'workpackages.id',
                'workpackages.uuid',
                'workpackages.code',
                'workpackages.title',
                'workpackages.is_template',
                'workpackages.aircraft_id',
                'workpackages.description',
            ])
            ->with([
            'quotations' => function ($q) use ($quotation) {
                $q->select($this->qn_select_column)
                    ->with([
                        'promos',
                        'currency',
                        'taxes',
                        'taxes.TaxPaymentMethod',
                    ])
                    ->where('uuid', $quotation->uuid);
            },
        ])->get();

        $quo = Quotation::where('uuid', $quotation->uuid)
            ->select($this->qn_select_column)
            ->with([
                'promos',
                'currency',
                'taxes',
                'taxes.TaxPaymentMethod',
            ])->get();

        @$taxes =  $quotation->taxes[0];
        if (@$taxes) {
            $taxes_type = Type::where('id', $taxes->type_id)->first();
        } else {
            $taxes_type = new stdClass();
            $taxes_type->code = 0;
        }

        // looping sebanyak workpacke yang ada di invoice
        foreach ($workpackages as $workPackage) {
            // get project workpackage
            $project_workpackage = ProjectWorkpackage::where('project_id', $quotation->quotationable->id)
                ->where('workpackage_id', $workPackage->id)
                ->first();

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

            // get taskcard in project workpackage
            $taskcard = ProjectWorkPackageTaskCard::with(['taskcard'])->where('project_workpackage_id', $project_workpackage->id)->get();
            foreach ($taskcard as $taskcard) {
                if ($taskcard->type->code == "basic") {
                    $basic_count += 1;
                } elseif ($taskcard->type->code == "sip") {
                    $sip_count += 1;
                } elseif ($taskcard->type->code == "cpcp") {
                    $cpcp_count += 1;
                } elseif ($taskcard->type->code == "si") {
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
                ->where('workpackage_id', $workPackage->id)
                ->first()
                ->promos;

            $workPackage->discount = 0;
            foreach ($getdiscount as $getdiscount_row) {
                $workPackage->discount += $getdiscount_row->pivot->amount;
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
        @$pricehtccr += QuotationHtcrrItem::where('quotation_id', $quotation->id)->sum('subtotal'); //mat tool htcrr

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
            $htcrr_workpackage->taxes = $taxes;
            $htcrr_workpackage->quotations = $quo;

            if ($quotation->promos->first()) {
                $htcrr_workpackage->discount =  $quotation->promos->first()->pivot->amount;
            } else {
                $htcrr_workpackage->discount = 0;
            }

            $workpackages[sizeof($workpackages)] = $htcrr_workpackage;
        }

        /**
         * handle QN additional
         */
        $total_item_price = QuotationDefectCardItem::selectRaw('(quantity * price_amount) AS subtotal')
            ->where('quotation_id', $quotation->id)
            ->get();

        if (count($total_item_price) > 0) {
            $workPackage = new WorkPackage();
            $workPackage->description = "Workpackage Additional";
            $workPackage->quotations[0] = $quotation;
            $workPackage->facilities_price_amount = 0;
            $workPackage->mat_tool_price = $total_item_price->sum('subtotal');

            $json_data = json_decode($quotation->data_defectcard);

            if ($json_data) {
                $workPackage->total_manhours_with_performance_factor = $json_data->total_manhour;
                $workPackage->pivot = (object) [
                    'manhour_rate_amount' => $json_data->manhour_rate
                ];
            }

            $workpackages[sizeof($workpackages)] = $workPackage;
        }

        if ($quotation->charge != null) {
            $encode = json_decode($quotation->charge);
            $last_index_key = array_key_last($encode);
            $total = 0;
            for ($i = 0; $i <= $last_index_key; $i++) {
                $total += $encode[$i]->amount;
            }
            //dd($encode[0]->amount);
            $other_workpackage = new WorkPackage();
            $other_workpackage->code = "Other";
            $other_workpackage->title = "Other";
            $other_workpackage->priceother = $total;
            $other_workpackage->quotations = $quo;
            //$htcrr_workpackage->other = $quotation->charge;
            $workpackages[sizeof($workpackages)] = $other_workpackage;
        }

        // start datatable

        // dd($workpackages[0]->quotations[0]);

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

    public function print(Request $request)
    {
        $invoice = Invoice::where('uuid', $request->uuid)->firstOrFail();
        $quotation = $invoice->quotations;
        $workpackage = $quotation->workpackages;

        if ($invoice->currencies->code == 'idr') {
            $invoice->multiple = $quotation->exchange_rate;
        } else {
            $invoice->multiple = 1;
        }

        for ($a = 0; $a < count($workpackage); $a++) {
            $x = $workpackage[$a];

            $invoice->quotations->workpackages[$a]->mat_tool_price =  QuotationWorkPackageTaskCardItem::where(
                'quotation_id',
                $invoice->quotations->id
            )
                ->where('workpackage_id', $x->id)
                ->sum('subtotal') * $invoice->multiple;

            $invoice->quotations->workpackages[$a]->material_item = QuotationWorkpackageTaskcardItem::where('quotation_id', $quotation->id)
                ->where('workpackage_id', $x->id)
                ->count();

            $project_workpackage = ProjectWorkPackage::where('project_id', $quotation->quotationable->id)
                ->where(
                    'workpackage_id',
                    $x->id
                )->first();

            if (!$project_workpackage) {
                continue;
            }

            $invoice->quotations->workpackages[$a]->facility = ProjectWorkPackageFacility::where('project_workpackage_id', $project_workpackage->id)
                ->with('facility')
                ->sum('price_amount') * $invoice->multiple;

            $invoice->quotations->workpackages[$a]->is_template = 'not htcrr';
        }

        $htcrrs = HtCrr::where('project_id', $quotation->quotationable->id)->whereNull('parent_id')->get();
        $mats_tools_htcrr = QuotationHtcrrItem::where('quotation_id', $quotation->id)->sum('subtotal');
        if (sizeof($htcrrs) > 0) {
            $htcrr_workpackage = new WorkPackage();
            $htcrr_workpackage->code = "Workpackage HT CRR";
            $htcrr_workpackage->title = "Workpackage HT CRR";
            $htcrr_workpackage->data_htcrr = json_decode($quotation->data_htcrr, true);
            $htcrr_workpackage->mat_tool_price = $mats_tools_htcrr;
            $htcrr_workpackage->is_template = "htcrr";
            $htcrr_workpackage->ac_type = $quotation->quotationable->aircraft->name;

            if ($quotation->promos->first()) {
                $promo = $quotation->promos->first();
                switch ($promo->code) {
                    case "discount-amount":
                        $htcrr_workpackage->jobrequest_discount_amount = $promo->pivot->amount;
                        // array_push($discount, $disc);
                        $htcrr_workpackage->jobrequest_discount_percentage =  $promo->pivot->value * 100;
                        break;
                    case "discount-percent":

                        $htcrr_workpackage->jobrequest_discount_amount =  $promo->pivot->amount;

                        // array_push($discount, $disc);
                        $htcrr_workpackage->jobrequest_discount_percentage =  $promo->pivot->value;
                        break;
                    default:
                        // array_push($discount, 0);
                }
                $htcrr_workpackage->jobrequest_discount_type =  $quotation->promos->first()->code;
                $htcrr_workpackage->jobrequest_discount_value =  $quotation->promos->first()->pivot->amount;
            } else {
                $htcrr_workpackage->jobrequest_discount_value = null;
                $htcrr_workpackage->jobrequest_discount_type = null;
                $htcrr_workpackage->jobrequest_discount_percentage =  null;
            }

            $invoice
                ->quotations
                ->workpackages[sizeof($invoice->quotations->workpackages)] = $htcrr_workpackage;
        }

        if ($quotation->charge != null) {
            $encode = json_decode($quotation->charge);
            $last_index_key = array_key_last($encode);
            $total = 0;
            for ($i = 0; $i <= $last_index_key; $i++) {
                $total += $encode[$i]->amount;
            }
            //dd($encode[0]->amount);
            $other_workpackage = new WorkPackage();
            $other_workpackage->code = "Other";
            $other_workpackage->title = "Other";
            $other_workpackage->priceother = $total;
        }

        $bank_segment = $this->preparedBankData($invoice);

        $invoice->attention = '-';
        if (isset($invoice->customer->attention)) {
            $invoice->attention = @json_decode(@$invoice->customer->attention)[0]->name;
        }

        $data = [
            'invoice' => $invoice,
            'other_workpackage' => $other_workpackage,
            'bank_segment' => $bank_segment,
        ];

        $pdf = \PDF::loadView('formview::invoice', $data);
        return $pdf->stream();
    }

    private function preparedBankData($invoice)
    {
        $bank_account_1 = $invoice->bank;
        $bank_account_2 = $invoice->bank2;
        $bank_account_3 = $invoice->bank3;

        $bank_account = [
            $bank_account_1,
            $bank_account_2 ?? null,
            $bank_account_3 ?? null,
        ];

        $bank_account = array_filter($bank_account);
        $bank_account = array_values($bank_account);

        $data_same_bank = [];

        for ($index=0; $index < count($bank_account); $index++) { 
            for ($index_2=$index + 1; $index_2 < count($bank_account); $index_2++) { 
                if ($bank_account[$index]->bank->id == $bank_account[$index_2]->bank->id) {
                    $data_same_bank = [
                        'bank1' => $bank_account[$index],
                        'bank2' => $bank_account[$index_2],
                    ];

                    unset($bank_account[$index]);
                    unset($bank_account[$index_2]);
                    $bank_account = array_values($bank_account);

                    $data_same_bank['bank3'] = $bank_account[0] ?? null;

                    break;
                }
            }

            if (count($data_same_bank) > 1) {
                break;
            }
        }

        if (count($data_same_bank) > 1) {
            return view('formview::invoice-bank-account-segment-same-bank', $data_same_bank);
        }

        if (count($data_same_bank) < 1) {
            $data = [
                'bank1' => $bank_account_1,
                'bank2' => $bank_account_2 ?? $bank_account_3,
            ];
            return view('formview::invoice-bank-account-segment', $data);
        }
    }

    public function getCustomer()
    {
        $customer = Customer::all();

        $type = [];

        for ($i = 0; $i < count($customer); $i++) {
            $x = $customer[$i];

            $type[$x->id] = $x->name;
        }

        return json_encode($type, JSON_PRETTY_PRINT);
    }

    public function export(Request $request)
    {
        $invoice = Invoice::query();

        $now = Carbon::now()->format('d-m-Y');
        $name = "Invoice {$now}";
        
        if ($request->uuid) {
            $invoice = $invoice->where('uuid', $request->uuid);
        }

        $invoice = $invoice->get();

        $data = [
            'controller' => new Controller(),
            'invoice' => $invoice
        ];

        $prefix = 'All';
        if ($request->uuid) {
            $prefix = str_replace('/', '-', $invoice->first()->transactionnumber);
        }

        $name .= " {$prefix}";

        return Excel::download(new InvoiceExport($data), "{$name}.xlsx");
    }

    public function select2_cash_advance(Request $request)
    {
        if (! $request->customer) {
            return [
                'results' => []
            ];
        }

        $customer = Customer::findOrFail($request->customer);

        $cash_advance = CashAdvance::where('class_ref', 'like', '%Customer%')
            ->where('id_ref', $customer->id)
            ->where('transaction_number', 'like', "%{$request->q}%")
            ->get();

        $data['results'] = [];
    
        foreach ($cash_advance as $cash_advance_row) {
            $data['results'][] = [
                'id' => $cash_advance_row->id,
                'text' => "{$cash_advance_row->transaction_number} (".strtoupper($cash_advance_row->currency->code).")"
            ];
        }

        return $data;
    }
}
