<?php

namespace memfisfa\Finac\Model;

use App\ClosingJournal;
use memfisfa\Finac\Model\MemfisModel;
use memfisfa\Finac\Model\TrxJournalA;
use memfisfa\Finac\Model\TypeJurnal;
use App\User;
use App\Models\Approval;
use App\Models\ARWorkshop;
use App\Models\CashAdvance;
use App\Models\CashAdvanceReturn;
use App\Models\Currency;
use App\Models\GoodsReceived;
use App\Models\InventoryOut;
use App\Models\Payroll;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Log;
use memfisfa\Finac\Controllers\Frontend\JournalController;
use Modules\Workshop\Entities\InvoiceWorkshop\InvoiceWorkshop;

class TrxJournal extends MemfisModel
{
    protected $table = "trxjournals";

    protected $fillable = [
		'approve',
		'voucher_no',
		'transaction_date',
		'ref_no',
		'description_2',
		'currency_code',
		'exchange_rate',
		'journal_type',
		'total_transaction',
		'automatic_journal_type',
    ];

	protected $appends = [
		'created_by',
		'updated_by',
		'approved_by',
		'status',
	];

    protected $dates = [
        'transaction_date'
    ];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function getRefCollectionAttribute()
    {
        $doc_ref = [
            'CSAD' => [
                'number' => 'transaction_number',
                'rate' => '',
                'class' => new CashAdvance(),
                'currency' => '',
                'total' => '',
            ], // cash advance
            'CSAR' => [
                'number' => 'transaction_number',
                'rate' => '',
                'class' => new CashAdvanceReturn(),
                'currency' => '',
                'total' => '',
            ], // cash advance return
            'SITR' => [
                'number' => 'transaction_number',
                'rate' => 'exchange_rate',
                'class' => new TrxPayment(),
                'currency' => 'currencies',
                'total' => 'grandtotal_foreign'
            ], // supplier invoice
            'GRNI' => [
                'number' => 'number',
                'rate' => 'rate',
                'class' => new GoodsReceived(),
                'currency' => 'currency',
                'total' => ''
            ], // grn
            'INVC' => [
                'number' => 'transactionnumber',
                'rate' => 'exchangerate',
                'class' => new Invoice(),
                'currency' => 'currencies',
                'total' => 'grandtotalforeign'
            ], // invoice
            'IOUT' => [
                'number' => 'number',
                'rate' => '',
                'class' => new InventoryOut(),
                'currency' => '',
                'total' => ''
            ], // inventory out
            'CCPJ' => [
                'number' => 'transactionnumber',
                'rate' => 'exchangerate',
                'class' => new Cashbook(),
                'currency' => 'currencies',
                'total' => 'totaltransaction'
            ], // cashbook cash payment
            'CBRJ' => [
                'number' => 'transactionnumber',
                'rate' => 'exchangerate',
                'class' => new Cashbook(),
                'currency' => 'currencies',
                'total' => 'totaltransaction'
            ], // cashbook bank receive
            'FAMS' => [
                'number' => 'transaction_number',
                'rate' => '',
                'class' => new Asset(),
                'currency' => '',
                'total' => 'povalue'
            ], // assets
            'CCRJ' => [
                'number' => 'transactionnumber',
                'rate' => 'exchangerate',
                'class' => new Cashbook(),
                'currency' => 'currencies',
                'total' => 'totaltransaction'
            ], // cashbook cash receive
            'CBPJ' => [
                'number' => 'transactionnumber',
                'rate' => 'exchangerate',
                'class' => new Cashbook(),
                'currency' => 'currencies',
                'total' => 'totaltransaction'
            ], // cashbook bank payment
            'CPYJ' => [
                'number' => 'transactionnumber',
                'rate' => 'exchangerate',
                'class' => new APayment(),
                'currency' => 'currencies',
                'total' => 'totaltransaction'
            ],
            'BPYJ' => [
                'number' => 'transactionnumber',
                'rate' => 'exchangerate',
                'class' => new APayment(),
                'currency' => 'currencies',
                'total' => 'totaltransaction'
            ],
            'BRCJ' => [
                'number' => 'transactionnumber',
                'rate' => 'exchangerate',
                'class' => [new AReceive(), new ARWorkshop()],
                'currency' => 'currencies',
                'total' => 'totaltransaction'
            ],
            'IVSL' => [
                'number' => 'invoice_no',
                'rate' => 'exchange_rate',
                'class' => new InvoiceWorkshop(),
                'currency' => 'currency',
                'total' => 'grand_total'
            ], // invoice sale (workshop)
            'IVSH' => [
                'number' => 'invoice_no',
                'rate' => 'exchange_rate',
                'class' => new InvoiceWorkshop(),
                'currency' => 'currency',
                'total' => 'grand_total'
            ], // invoice service (workshop)
        ];

        $ref_no_code = explode('-', $this->ref_no)[0];

        if (! @$doc_ref[$ref_no_code]) {
            return '';
        }

        if (gettype($doc_ref[$ref_no_code]['class']) == 'array') {
            $array_class = $doc_ref[$ref_no_code]['class'];

            foreach ($array_class as $array_class_row) {
                $class_ref = $array_class_row
                    ->where($doc_ref[$ref_no_code]['number'], $this->ref_no)
                    ->first();

                if ($class_ref) {
                    break;
                }
            }

        } else {
            $class_ref = $doc_ref[$ref_no_code]['class']
                ->where($doc_ref[$ref_no_code]['number'], $this->ref_no)
                ->first();
        }

        if (! @$class_ref) {
            return '';
        }

        $idr_currency = Currency::where('code', 'idr')->first();

        $number = $doc_ref[$ref_no_code]['number'];
        $rate = $doc_ref[$ref_no_code]['rate'];
        $currency = $doc_ref[$ref_no_code]['currency'];
        $total = $doc_ref[$ref_no_code]['total'];

        $class_ref->number = $class_ref->$number;
        $class_ref->rate = $class_ref->$rate ?? 1;
        $class_ref->currency = $class_ref->$currency ?? $idr_currency;
        $class_ref->total = $class_ref->$total ?? '-';

        return $class_ref;
    }

	public function getApprovedByAttribute()
	{
		$approval = $this->approvals->first();
		$conducted_by = @User::find($approval->conducted_by)->name;

		$result = '-';

		if ($conducted_by) {

            if ($this->ref_collection) {
                $conducted_by = 'System';
            }

			$result = $conducted_by.' '.$approval->created_at->format('d-m-Y H:i:s');
		}

		return $result;
	}

	public function getCreatedByAttribute()
	{
		$audit = $this->audits->first();
		$conducted_by = @User::find($audit->user_id)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$this->created_at->format('d-m-Y H:i:s');
		}

		return $result;
	}

	public function getUpdatedByAttribute()
	{
		$tmp = $this->audits;

		$result = '-';

		if (count($tmp) > 1) {
			$result =  @User::find($tmp[count($tmp)-1]->user_id)->name
			.' '.$this->created_at->format('d-m-Y H:i:s');
		}

		return $result;
	}

	static public function getJournalCode($journal_type_id)
	{
		$type = TypeJurnal::find($journal_type_id);

		if($type->code == 'GJV' || $type->code == 'ADJ') {
			$code = "J".$type->code;
		}

		return $code;
	}

	public function getStatusAttribute()
	{
		$status = 'Open';
		if ($this->approve) {
			$status = 'Approved';
		}

		return $status;
	}

	static public function generateCode($code = "JADJ")
	{
		return self::generateTransactionNumber(self::class, 'voucher_no', $code);
	}

    public function check_closing_journal($date)
    {
        $closing_journal = ClosingJournal::where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();

        // date transaction sudah ter close
        if ($closing_journal) {
            return false;
        }

        // date transaction belum di close
        return true;
    }

	static public function insertFromBSR($header, $detail)
	{
		$data['voucher_no'] = $header->transaction_number;
		$data['transaction_date'] = $header->transaction_date;
		$data['journal_type'] = TypeJurnal::where('code', 'GJV')->first()->id;
		$data['currency_code'] = 'idr';
		$data['exchange_rate'] = 1;

        $model_journal = new TrxJournal();
        $check_closing = $model_journal->check_closing_journal($data['transaction_date']);

        if (! $check_closing) {
			return [
				'status' => false,
				'message' => 'Failed, Transaction date already closed'
			];
        }

		$journal = TrxJournal::create($data);

		$total = $header->value;

		for($a = 0; $a < count($detail); $a++) {

			if($detail[$a]) {

				$credit = $header->value;
				$debit = 0;

				/*
				 *jika sudah bukan loopingan pertama
				 */
				if ($a > 0) {
					$credit = 0;
					$debit = $header->value;
				}

				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $detail[$a]->code,
					'debit' => $debit,
					'credit' => $credit,
				]);
			}

		}

		TrxJournal::where('id', $journal->id)->update([
			'total_transaction' => $header->value
		]);
	}

	// approve journal

	static public function do_approve($journal)
	{

		try {

	        $journal->first()->approvals()->save(new Approval([
	            'approvable_id' => $journal->first()->id,
	            'conducted_by' => Auth::id(),
	            'is_approved' => 1
	        ]));

			$journal->update([
				'approve' => 1
			]);

			return true;

		} catch (\Exception $e) {

			return false;

		}

	}

    // auto journal payroll
    public function autoJournalPayroll($payroll_id)
    {
        $payroll = Payroll::find($payroll_id);

        if (! $payroll) {
            throw ValidationException::withMessages([
                'default' => 'Payroll not found'
            ]);
        }

        $data = $payroll->getAutoJurnalValues();

        $header = $data['header'];
        $detail = $data['detail'];

        foreach ($detail as $detail_row) {
            $coa = Coa::find($detail_row->coa_detail);
            if (! $coa) {
                throw ValidationException::withMessages([
                    'default' => 'Coa Not found'
                ]);
            }
        }

        return $this->autoJournal($header, $detail, 'PYRL', 'GJV');
    }

	// auto journal

	/**
	* $header : [
	* 'voucher_no', //voucher numer of data sended
	* 'transaction_date', //date of approved data sended
	* 'coa_piutang', //coa piutang (coa customer)
	* ]
	*
	* $detail : [
	*  [
	*   'value',
	*   'coa_piutang',
	*  ],
	*  [
	*   'value',
	*   'coa_piutang',
	*  ],
	* ]
	*
	* $journal_type // type of journal
	* $journal_prefix_number // journal prefix number
	* $income_outcome // income or outcome
	*/
	static public function autoJournal(
		$header,
		$detail,
		$journal_prefix_number,
        $journal_type,
        $auto_approve = true
	)
	{

        $check_duplicate = self::check_duplicate_refno($header->voucher_no);

        if ($check_duplicate) {
			return [
				'status' => false,
				'message' => "Failed, document {$header->voucher_no} already approved"
			];
        }

		$data['voucher_no'] = TrxJournal::generateCode($journal_prefix_number);
		$data['ref_no'] = $header->voucher_no;
		$data['transaction_date'] = $header->transaction_date;
		$data['journal_type'] = TypeJurnal::where(
			'code', $journal_type
		)->first();

        $model_journal = new TrxJournal();
        $check_closing = $model_journal->check_closing_journal($data['transaction_date']);

        if (! $check_closing) {
			return [
				'status' => false,
				'message' => 'Failed, Transaction date already closed'
			];
        }

		if ($data['journal_type']) {
			$data['journal_type'] = $data['journal_type']->id;
		}else{
			return [
				'status' => false,
				'message' => 'journal_type not found : '.$journal_type
			];
		}
		$data['currency_code'] = 'idr';
		$data['exchange_rate'] = 1;
        $data['description'] = 'Generate from auto journal '.$data['voucher_no'];

        DB::beginTransaction();

		$journal = TrxJournal::create($data);

        $journal_controller = new JournalController();
        $ref_date = $journal_controller->generate_ref_date($journal);

        $journal->update([
            'ref_date' => $ref_date
        ]);

		$total_credit = 0;
		$total_debit = 0;

		for ($i = 0; $i < count($detail); $i++) {

			$x = $detail[$i];

			// if ($x->debit != 0 || $x->credit != 0) {

				$journal_detail = TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $x->coa_detail,
					'credit' => memfisRound('idr', $x->credit) ?? 0,
					'debit' => memfisRound('idr', $x->debit) ?? 0,
					// 'description' => 'Generate from auto journal, '.$header->voucher_no,
                    'description' => $x->_desc,
                    'id_project' => $x->id_project ?? null
				]);

			// }

			$total_credit += $journal_detail->credit;
			$total_debit += $journal_detail->debit;
		}

		$tmp_journal = TrxJournal::where('id', $journal->id);

        if ($auto_approve) {
            TrxJournal::do_approve($tmp_journal);
        }

        //check balance
        if (bccomp($total_debit, $total_credit, 5) != 0) {

            // return [
            // 	'status' => false,
            // 	'message' => 'Invalid debit or credit value'
            // ];

            $diff = $total_debit - $total_credit;

            Log::warning("Invalid debit or credit value. diff = {$diff}");

            $debit = $diff;
            $credit = 0;
            if ($diff > 0) {
                $credit = $diff;
                $debit = 0;
            }

            TrxJournalA::create([
                'voucher_no' => $data['voucher_no'],
                'account_code' => Coa::where('code', '81112003')->first()->id,
                'credit' => $credit ?? 0,
                'debit' => $debit ?? 0,
                'description' => $x->_desc . ' -> Difference',
                'id_project' => $x->id_project ?? null
            ]);
        }

		$tmp_journal->update([
			// income outcome tidak pengaruh untu variable satu ini
			'total_transaction' => TrxJournalA::where('voucher_no', $data['voucher_no'])->sum('credit')
		]);

        DB::commit();

		return ['status' => true];
	}
	// end auto journal

    private static function check_duplicate_refno($ref_no)
    {
        $count = TrxJournal::where('ref_no', $ref_no)->count();

        if ($count > 0) {
            return true;
        }
        
        return false;
    }

	static public function insertFromGRN($header, $detail)
	{
		try {
			$data['voucher_no'] = TrxJournal::generateCode('PRJR');
			$data['ref_no'] = $header->voucher_no;
			$data['transaction_date'] = $header->transaction_date;
			$data['journal_type'] = TypeJurnal::where('code', 'PRJ')->first()->id;
			$data['currency_code'] = 'idr';
			$data['exchange_rate'] = 1;
			$data['description'] = 'Generate from auto journal '.$data['voucher_no'];

			$total_debit = 0;

            $detail_tmp = $detail;

            $sumDetail = [];

            foreach ($detail as $detailVal) {
                $coaExist = false;

                foreach ($sumDetail as $key => $sumDetailValue) {
                    if ($detailVal->coa_iv == $sumDetailValue->coa_detail) {
                        $sumDetail[$key]->debit += $detailVal->val;
                        $coaExist = true;
                    }
                }

                if (!$coaExist) {
                    $newSumDetail = (object)[
                        'coa_detail' => $detailVal->coa_iv,
                        'coa' => Coa::find($detailVal->coa_iv)->name,
                        'debit' => $detailVal->val,
                        'credit' => 0,
                        '_desc' => 'Increased Inventory : '
                        .$header->voucher_no.' '
                        .$header->supplier.' ',
                    ];

                    $sumDetail[] = $newSumDetail;
                }
            }

            $newSumDetail = (object) [
                'coa_detail' => $detail[0]->coa_vendor,
                'coa' => Coa::find($detail[0]->coa_vendor)->name,
                'debit' => 0,
                'credit' => 0,
                '_desc' => 'Increased Inventory : '
                .$header->voucher_no.' '
                .$header->supplier.' ',
            ];

            foreach ($detail as $detailVal) {

                $newSumDetail->credit += $detailVal->val;
            }

            $sumDetail[] = $newSumDetail;

            // dd($sumDetail);

			TrxJournal::autoJournal($header, $sumDetail, 'PRJR', 'PRJ', true);

			return [
				'status' => true,
				'message' => ''
			];

		} catch (\Exception $e) {

			return [
				'status' => false,
				'message' => $e
			];

		}
	}

	static public function insertFromIvOut($header, $detail)
	{
        try {
            $sum_detail = [];

            // looping sebanyak item
            foreach ($detail as $detail_row) {
                $coaExistIv = false;
                $coaExistCogs = false;

                // looping sebanyak array baru
                foreach ($sum_detail as $sum_detail_row) {
                    // biaya
                    if ($detail_row->coa_cogs == $sum_detail_row->coa_detail) {
                        if ($detail_row->item_id == $sum_detail_row->item_id) {
                            $sum_detail_row->debit += $detail_row->val;
                            $coaExistCogs = true;
                        }
                    }

                    // persediaan
                    if ($detail_row->coa_iv == $sum_detail_row->coa_detail) {
                        if ($detail_row->item_categories->id == $sum_detail_row->item_categories_id) {
                            $sum_detail_row->credit += $detail_row->val;
                            $coaExistIv = true;
                        }
                    }
                }

                // jika coa cogs statusnya false
                if (!$coaExistCogs) {
                    $sum_detail[] = (object)[
                        'item_id' => $detail_row->item_id,
                        'coa_detail' => $detail_row->coa_cogs,
                        'item_categories_id' => $detail_row->item_categories->id,
                        'debit' => $detail_row->val,
                        'credit' => 0,
                        '_desc' => 'Material Usage: '
                            . $header->voucher_no
                            . ' '
                            . $detail_row->part_number
                    ];
                }

                // jika coa iv statusnya false
                if (!$coaExistIv) {
                    // create new array baru
                    $sum_detail[]  = (object)[
                        'item_id' => $detail_row->item_id,
                        'coa_detail' => $detail_row->coa_iv,
                        'item_categories_id' => $detail_row->item_categories->id,
                        'debit' => 0,
                        'credit' => $detail_row->val,
                        '_desc' => 'Increased Inventory : '
                            . $header->voucher_no
                            . ' '
                            . $detail_row->item_categories->name
                    ];
                }
            }

            usort($sum_detail, function ($item1, $item2) {
                return $item2->debit <=> $item1->debit;
            });

            // get status dari autoJournal
            $auto_journal = TrxJournal::autoJournal(
                $header,
                $sum_detail,
                'PRJR',
                'GJV'
            );

            return $auto_journal;

		} catch (\Exception $e) {

			return [
				'status' => false,
				'message' => $e->getMessage()
			];

		}
	}

	public function getTransactionDateYmdAttribute()
	{
		return date(
			'Y-m-d', strtotime($this->transaction_date)
		);
	}

	public function type_jurnal()
	{
		return $this->belongsTo(
			'memfisfa\Finac\Model\TypeJurnal',
			'journal_type'
		);
	}

	public function currency()
	{
		return $this->hasOne(
			'App\Models\Currency',
			'code',
			'currency_code'
		);
	}

	public function journala()
	{
		return $this->hasMany(
			'memfisfa\Finac\Model\TrxJournalA',
			'voucher_no',
			'voucher_no'
		);
    }
}
