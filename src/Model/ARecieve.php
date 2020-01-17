<?php

namespace memfisfa\Finac\Model;

use App\Models\Approval;
use memfisfa\Finac\Model\MemfisModel;
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

	protected $appends = ['date'];

	public function getDateAttribute()
	{
		return date('Y-m-d', strtotime($this->transactiondate));
	}

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function currencies()
    {
        return $this->hasOne(Currency::class, 'id', 'currency');
    }

    public function coas()
    {
        return $this->hasOne(Coa::class, 'id', 'accountcode');
    }

	static public function generateCode($code)
	{
		$data = ARecieve::orderBy('id', 'desc')
			->where('transactionnumber', 'like', $code.'%');

		if (!$data->count()) {

			if ($data->withTrashed()->count()) {
				$order = $data->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $data->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y/m')."/".$number;

		return $code;
	}

	public function customer()
	{
		return $this->belongsTo(Vendor::class, 'id_customer');
	}

	public function ara()
	{
		return $this->hasMany(
			ARecieveA::class, 
			'transactionnumber',
			'transactionnumber'
		);
	}
}
