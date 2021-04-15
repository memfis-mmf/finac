<?php
namespace memfisfa\Finac\Model;

use Carbon\Carbon;
use memfisfa\Finac\Traits\UuidKey;
use memfisfa\Finac\Traits\Timestampable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemfisModel extends Model implements Auditable
{
    
    use UuidKey;
    use SoftDeletes;
    use Timestampable;
    use \OwenIt\Auditing\Auditable;

    protected $hidden = ['id'];
    protected $dates = ['deleted_at'];
    /***************************************** OVERRIDE *******************************************/
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function generateTransactionNumber($class, $column, $code)
    {
		$data = $class::withTrashed()
            ->whereYear('created_at', Carbon::now()->format('Y'))
			->where($column, 'like', $code.'%')
            ->orderBy($column, 'desc')
            ->first();

        if (! $data) {
            $order = 1;
        } else {
            $explode = explode('/', $data->$column);
            $end = end($explode);
            $order = ltrim($end, '0') + 1;
        }

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y')."/".$number;

		return $code;
    }
}