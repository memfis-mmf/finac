<?php

namespace memfisfa\Finac\Model;

use App\Models\Approval;
use App\Models\Currency;
use App\Models\Quotation;
use App\Models\Customer;
use App\Models\BankAccount;
use App\User;
use Carbon\Carbon;
use memfisfa\Finac\Model\MemfisModel;

class Invoice extends MemfisModel
{
    protected $guarded = [];

	protected $appends = [
        'ar_amount',
        'ending_balance',
		'date',
		'approved_by',
		'report_subtotal',
		'report_paid_amount',
		'report_ending_balance',
		'report_discount',
        'created_by',
        'status',
        'xstatus',
        'due_date'
	];

    protected $dates = [
        'transactiondate'
    ];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function getArAmountAttribute()
    {
        $ara = $this->ara()->whereHas('ar', function($ar) {
                $ar->where('approve', true);
            })
            ->get();

        $debit = 0;
        $debit_idr = 0;
        $credit = 0;
        $credit_idr = 0;

        $result = [];
        foreach ($ara as $ara_row) {
            $debit += $ara_row->debit;
            $debit_idr += $ara_row->debit_idr;
            $credit += $ara_row->credit;
            $credit_idr += $ara_row->credit_idr;
        }
        
        $result = [
            'debit' => $debit,
            'debit_idr' => $debit_idr,
            'credit' => $credit,
            'credit_idr' => $credit_idr,
        ];

        return $result;
    }

    public function getTotalBeforeTaxAttribute()
    {
        $qn_type = $this->quotations->taxes[0]->TaxPaymentMethod->code;

        $divide = 1;
        if (strtolower($qn_type) == 'include') {
            $divide = 1.1;
        }
        $total = ($this->subtotal - $this->discountvalue) / $divide;

        return $total;
    }

    public function getEndingBalanceAttribute()
    {
        $result = [
            'amount' => $this->grandtotalforeign - $this->ar_amount['credit'],
            'amount_idr' => $this->grandtotal - $this->ar_amount['credit_idr'],
        ];

        return $result;
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->transactiondate)->format('Y-m-d');
    }

	public function getApprovedByAttribute()
	{
		$approval = $this->approvals->first();
		$conducted_by = @User::find($approval->conducted_by)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$approval->created_at->format('d-m-Y H:i:s');
		}

		return $result;
    }

    public function getReportSubtotalAttribute()
    {
        $currency = $this->currencies;

        $result = $this->grandtotalforeign;

        if ($currency->code == 'idr') {
            $result = $this->grandtotal;
        }

        return $result;
    }

    public function getReportPaidAmountAttribute()
    {
        if (@$this->ara[0]->ar) {
            return $this->countPaidAmount($this->ara[0]->transactionnumber);
        }

        return 0;
    }

    public function getReportEndingBalanceAttribute()
    {
        $paidAmount = $this->getReportPaidAmountAttribute();

        return $this->grandtotalforeign - $this->discount + 
                $this->ppnvalue - $paidAmount;
    }

    public function getReportDiscountAttribute()
    {
        return ($this->discountpercent) 
            ? $this->grandtotalforeign * ($this->discountpercent/100)
            : $this->discountvalue;
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
    
    public function getStatusAttribute()
    {
        $result = 'open';
        if ($this->approve) {
            $result = 'Approved';
        }

        if ($this->transaction_status == 0) {
            $result = 'Closed';
        }

        return $result;
    }

    public function getXstatusAttribute()
    {
        $quotation = $this->quotations()->select(['parent_id'])->first();
        $qn = ($quotation)? $quotation->toArray(): null;

        $result = '';
        if ($qn) {
            if (@$qn['parent_id'] == null) {
                $result = "Quotation Project";
            } else {
                $result = "Quotation Additional";
            }
        }

        return $result;
    }

    public function getDueDateAttribute()
    {
        $qn = $this->quotations()->select(['term_of_payment'])->first();

        if ($this->approve and $qn) {
            $approval_date = Carbon::parse($this->approvals()->first()->created_at);
            return $approval_date->addDays($qn->term_of_payment);
        }

        return '-';
    }

	public function countPaidAmount($arTransactionnumber)
	{
		$ara_tmp = AReceiveA::where(
			'transactionnumber', $arTransactionnumber
        )->first();

        if (!$ara_tmp) {
            return 0;
        }

		$ar = $ara_tmp->ar;
        $ara = AReceiveA::where('id_invoice', $ara_tmp->id_invoice)
        ->get();

		$data['debt_total_amount'] = Invoice::where(
			'id_customer',
			$ar->customer->id
		)->sum('grandtotal');

		$payment_total_amount = 0;

		for ($j = 0; $j < count($ara); $j++) {
			$y = $ara[$j];

			// $payment_total_amount += ($y->credit * $ar->exchangerate);
			$payment_total_amount += ($y->credit);
        }

		return $payment_total_amount;
    }

    public function ara()
    {
        return $this->hasMany(AReceiveA::class, 'id_invoice', 'id');
    }

    public function currencies()
    {
        return $this->hasOne(Currency::class, 'id', 'currency');
    }

    public function coas()
    {
        return $this->hasOne(Coa::class, 'id', 'accountcode');
    }

    public function quotations()
    {
        return $this->hasOne(Quotation::class, 'id', 'id_quotation');
    }

    public function totalprofit()
    {
        return $this->hasMany(Invoicetotalprofit::class, 'invoice_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function bank()
    {
        return $this->belongsTo(BankAccount::class, 'id_bank');
    }

    public function bank2()
    {
        return $this->belongsTo(BankAccount::class, 'id_bank2');
    }

    public function bank3()
    {
        return $this->belongsTo(BankAccount::class, 'id_bank3');
    }

	static public function generateCode($code = "INVC")
	{
		return self::generateTransactionNumber(self::class, 'transactionnumber', $code);
	}
}
