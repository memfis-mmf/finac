<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use App\Models\Approval;
use App\User;
use Auth;
use DB;

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
        'description',
        'createdby',
        'location',
        'company_department',
    ];

	protected $appends = [
		'approved_by',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

	public function getApprovedByAttribute()
	{
		return @User::find($this->approvals->first()->conducted_by);
	}

	static public function generateCode($code = "SITR")
	{
		$data = Cashbook::orderBy('id', 'desc')
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

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'accountcode', 'code');
	}

	public function cashbook_a()
	{
		return $this->hasMany(
			CashbookA::class,
			'transactionnumber',
			'transactionnumber'
		);
	}
}
