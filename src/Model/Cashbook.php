<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use App\Models\Approval;
use App\Models\Currency;
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
        'cashbook_ref',
    ];

	protected $appends = [
		'approved_by',
		'created_by',
		'cashbook_type',
		'account_name',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

	public function getApprovedByAttribute()
	{
		return @User::find($this->approvals->first()->conducted_by);
	}

	public function getCreatedByAttribute()
	{
		return @User::find($this->audits->first()->user_id);
	}

	public function getCashbookTypeAttribute()
	{
		if (strpos($this->transactionnumber, 'BP')) {
			$result = 'bp';
		}
		if (strpos($this->transactionnumber, 'BR')) {
			$result = 'br';
		}
		if (strpos($this->transactionnumber, 'CP')) {
			$result = 'cp';
		}
		if (strpos($this->transactionnumber, 'CR')) {
			$result = 'cr';
		}

		return $result;
	}

	public function getAccountNameAttribute()
	{
		return $this->coa->name;
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

	public function ref()
	{
		return $this->belongsTo(
			Cashbook::class,
			'cashbook_ref',
			'transactionnumber'
		);
	}

	public function cashbook_a()
	{
		return $this->hasMany(
			CashbookA::class,
			'transactionnumber',
			'transactionnumber'
		);
	}

	public function currencies()
	{
		return $this->belongsTo(Currency::class, 'currency', 'code');
	}
}
