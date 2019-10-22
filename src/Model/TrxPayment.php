<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class TrxPayment extends MemfisModel
{
    protected $table = "trxpayment";

    protected $fillable = [
		'id_branch',
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

}
