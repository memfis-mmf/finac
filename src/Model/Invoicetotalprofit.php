<?php

namespace Directoryxx\Finac\Model;

use App\Models\Approval;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;


class Invoicetotalprofit extends MemfisModel
{
    protected $table = "invoicetotalprofit";

    protected $fillable = [
        'invoice_id',
        'accountcode',
        'amount',
        'type',
    ];

}
