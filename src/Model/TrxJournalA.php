<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class TrxJournalA extends MemfisModel
{
    protected $table = "trxjournala";

    protected $fillable = [
		'id_branch',
		'voucher_no',
		'description',
		'account_code',
		'debit',
		'credit',
    ];

	protected $appends = [
		'debit_currency',
		'credit_currency',
	];

	public function coa()
	{
		return $this->belongsTo(
			Coa::class,
			'account_code',
			'id'
		);
	}

	public function getDebitCurrencyAttribute()
	{
		return number_format($this->debit, 0, 0, '.');
	}

	public function getCreditCurrencyAttribute()
	{
		return number_format($this->credit, 0, 0, '.');
	}

}
