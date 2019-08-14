<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Traits\UuidKey;


class TypeJurnal extends Model
{
    use UuidKey;

    protected $fillable = [
        'code',
        'name',
        'active',
    ];
}
