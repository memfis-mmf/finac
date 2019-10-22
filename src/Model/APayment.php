<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class APayment extends MemfisModel
{
    protected $table = "a_payments";

    protected $fillable = [
		'id_branch',
		'approve',
		'transactionnumber',
		'transactiondate',
		'id_supplier',
		'accountcode',
		'refno',
		'currency',
		'exchangerate',
		'totaltransaction',
		'description',
    ];
}
