<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Traits\UuidKey;


class TypeAsset extends Model
{
    use UuidKey;

    protected $fillable = [
        'code',
        'name',
        'accountcode',
        'usefullife',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
