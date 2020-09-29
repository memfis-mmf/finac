<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use memfisfa\Finac\Model\TrxPayment;
use App\Models\GoodsReceived;
use Illuminate\Database\Eloquent\Model;

class TrxPaymentA extends MemfisModel
{
    protected $table = "trxpaymenta";

    protected $fillable = [
		'transaction_number',
		'id_grn',
		'total',
		'total_idr',
        'tax_percent',
		'description',
    ];

	public function grn()
	{
		return $this->belongsTo(GoodsReceived::class, 'id_grn');
	}

	public function si()
	{
		return $this->belongsTo(
			TrxPayment::class,
			'transaction_number',
			'transaction_number'
		);
	}
}
