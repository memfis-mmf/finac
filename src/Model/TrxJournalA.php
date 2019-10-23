<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
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

	public function coa()
	{
		return $this->belongsTo(
			Coa::class,
			'account_code'
		);
	}
	
}
