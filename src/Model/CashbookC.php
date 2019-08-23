<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;


class CashbookC extends MemfisModel
{
    protected $table = "cashbook_c";
    protected $fillable = [
        'transactionnumber',
        'code',
        'name',
        'debit',
        'credit',
        'description',
        'createdby'
    ];
}
