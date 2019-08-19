<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;

class Cashbook extends MemfisModel
{
    protected $fillable = [
        'approve',
        'approve2',
        'transactionnumber',
        'transactiondate',
        'xstatus',
        'personal',
        'refno',
        'currency',
        'exchangerate',
        'accountcode',
        'totaltransaction',
        'description'
    ];
}
