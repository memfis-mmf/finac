<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Traits\UuidKey;


class Assetswriteoff extends Model
{
    use UuidKey;

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

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
