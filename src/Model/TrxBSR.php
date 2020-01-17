<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class TrxBSR extends MemfisModel
{
    protected $table = "trx_BSR";

    protected $fillable = [
		"approve",
		"id_BS",
		"transaction_number",
		"transaction_date",
		"value",
		"coac",
		"coad",
		"description",
    ];

}
