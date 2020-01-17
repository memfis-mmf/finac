<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Approval;

class TrxBS extends MemfisModel
{
    protected $table = "trx_BS";

    protected $fillable = [
		"approve",
		"closed",
		"transaction_number",
		"transaction_date",
		"id_employee",
		"date_return",
		"value",
		"coac",
		"coad",
		"description",
    ];

	protected $appends = [
		'coac_name',
		'coad_name',
		'created_by',
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

	public function getCreatedByAttribute()
	{
		return User::find($this->audits->first()->user_id);
	}

	public function getCoacNameAttribute()
	{
		return Coa::where('code', $this->coac)->first()->name;
	}

	public function getCoadNameAttribute()
	{
		return Coa::where('code', $this->coad)->first()->name;
	}

	static public function generateCode($code = "BSTR")
	{
		$bs = TrxBS::orderBy('id', 'desc')
			->where('transaction_number', 'like', $code.'%');

		if (!$bs->count()) {

			if ($bs->withTrashed()->count()) {
				$order = $bs->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $bs->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y/m')."/".$number;

		return $code;
	}

	public function employee()
	{
		return $this->belongsTo('App\Models\Employee', 'id_employee', 'code');
	}

}
