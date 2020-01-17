<?php

namespace memfisfa\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\MemfisModel;



class Assetswriteoff extends MemfisModel
{

    protected $fillable = [
        'id_branch',
        'approve',
        'transactionnumber',
        'transactiondate',
        'id_asset',
        'sellingprice',
        'accountcode',
        'coapl'
    ];

    
}
