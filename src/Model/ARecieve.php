<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class ARecieve extends MemfisModel
{
    protected $fillable = [
        'id_branch',
        'approve',
        'transactionnumber',
        'transactiondate',
        'id_customer',
        'currency',
        'exchangerate',
        'refno',
        'accountcode',
        'description'
    ];
}
