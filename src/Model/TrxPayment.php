<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\Coa;
use App\Models\Vendor;
use memfisfa\Finac\Model\TrxPaymentA;
use App\Models\Approval;
use App\User;
use App\Models\Currency;

class TrxPayment extends MemfisModel
{
    protected $table = "trxpayments";

    protected $fillable = [
		'approve',
		'closed',
		'transaction_number',
		'transaction_date',
		'x_type',
		'id_supplier',
		'currency',
		'exchange_rate',
		'discount_percent',
		'discount_value',
		'ppn_percent',
		'ppn_value',
		'grandtotal_foreign',
		'grandtotal',
		'account_code',
		'description',
    ];

	protected $appends = [
		'exchange_rate_fix',
		'total',
		'created_by',
		'updated_by',
		'approved_by',
		'status',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

	public function getApprovedByAttribute()
	{
		return @User::find($this->approvals->first()->conducted_by);
	}

	public function getCreatedByAttribute()
	{
		return User::find($this->audits->first()->user_id);
	}

	public function getUpdatedByAttribute()
	{
		$tmp = $this->audits;

		$result = '';

		if (count($tmp) > 1) {
			$result =  User::find($tmp[count($tmp)-1]->user_id);
		}

		return $result;
	}

	public function getExchangeRateFixAttribute()
	{
		return number_format($this->exchange_rate, 0, 0, '.');
	}

	public function getTotalAttribute()
	{
		$total = $this->grandtotal_foreign;

		if ($this->currency == 'idr') {
			$total = $this->grandtotal;
		}

		return $total;
	}

	public function getStatusAttribute()
	{
		$apa_tmp = $this->apa;
		$ap_tmp = $apa_tmp[0]->ap()->where('approve', 1)->first();
		$ap = APayment::where('id_supplier', $ap_tmp->id_supplier)->get();

		$total = 0;

		foreach ($ap as $key_ap) {
			$apa = $key_ap->apa;

			foreach ($apa as $key_apa) {
				$total += ($key_apa->debit * $key_ap->exchangerate);
			}
		}

		if ($total >= ($this->grandtotal_foreign * $this->exchange_rate)) {
			$status = 'Closed';
		}else{
			if ($this->approve) {
				$status = 'Approved';
			}else{
				$status = 'Unapproved';
			}
		}

		return $status;
	}

	static public function generateCode($code = "SITR")
	{
		$data = TrxPayment::orderBy('id', 'desc')
			->where('transaction_number', 'like', $code.'%');

		if (!$data->count()) {

			if ($data->withTrashed()->count()) {
				$order = $data->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $data->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y/m')."/".$number;

		return $code;
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'id_supplier');
	}

	public function trxpaymenta()
	{
		return $this->hasMany(TrxPaymentA::class,
			'transaction_number',
			'transaction_number'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'account_code', 'code');
	}

	public function apa()
	{
		return $this->hasMany(APaymentA::class,
			'id_payment'
		);
	}

	public function currencies()
	{
		return $this->belongsTo(Currency::class, 'currency', 'code');
	}
}
