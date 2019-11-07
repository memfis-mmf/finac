<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\GoodsReceived;

class TrxPaymentA extends MemfisModel
{
    protected $table = "trxpaymenta";

    protected $fillable = [
		'transaction_number',
		'id_grn',
		'total',
		'description',
    ];

	public function grn()
	{
		return $this->belongsTo(GoodsReceived::class, 'id_grn');
	}

}
