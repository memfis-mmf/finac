<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Traits\UuidKey;


class Asset extends Model
{
    use UuidKey;

    protected $fillable = [
        'code',
        'name',
        'active',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
