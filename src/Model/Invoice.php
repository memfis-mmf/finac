<?php

namespace memfisfa\Finac\Model;

use App\Models\Approval;
use App\Models\Currency;
use App\Models\Quotation;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\BankAccount;
use App\User;
use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class Invoice extends MemfisModel
{
    protected $guarded = [];

	protected $appends = [
		'approved_by',
		'report_paid_amount',
		'report_ending_balance',
		'report_discount',
		// 'created_by',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

	public function getApprovedByAttribute()
	{
		$approval = $this->approvals->first();
		$conducted_by = @User::find($approval->conducted_by)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$approval->created_at;
		}

		return $result;
    }

    public function getPaidAmountAttribute()
    {
        return $this->countPaidAmount($this->ara[0]->transactionnumber);
    }

    public function getReportEndingBalanceAttribute()
    {
        $paidAmount = $this->getPaidAmountAttribute();

        return $this->grandtotalforeign - $this->discount + 
                $this->vat - $paidAmount;
    }

    public function getReportDiscountAttribute()
    {
        return ($this->discountpercent) 
            ? $this->grandtotalforeign * ($this->discountpercent/100)
            : $this->discountvalue;
    }
	// public function getCreatedByAttribute()
	// {
	// 	return User::find($this->audits->first()->user_id);
    // }

	public function countPaidAmount($arTransactionnumber)
	{
		$ara_tmp = AReceiveA::where(
			'transactionnumber', $arTransactionnumber
        )->first();

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

			$payment_total_amount += ($y->credit * $ar->exchangerate);
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

	static public function generateCode($code = "INVC")
	{
		$invoice = Invoice::orderBy('id', 'desc')
			->where('transactionnumber', 'like', $code.'%');

		if (!$invoice->count()) {

			if ($invoice->withTrashed()->count()) {
				$order = $invoice->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $invoice->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y/m')."/".$number;

		return $code;
	}
}
