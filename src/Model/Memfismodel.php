<?php
namespace Directoryxx\Finac\Model;
use Directoryxx\Finac\Traits\Uuidkey;
use Directoryxx\Finac\Traits\Timestampable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemfisModel extends Model implements Auditable
{
    use UuidKey;
    use SoftDeletes;
    use Timestampable;
    use \OwenIt\Auditing\Auditable;

    //protected $hidden = ['id'];
    protected $dates = ['deleted_at'];
    /***************************************** OVERRIDE *******************************************/
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}