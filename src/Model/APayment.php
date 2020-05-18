<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;
use App\Models\Vendor;
use App\User;
use App\Models\Approval;
use App\Models\Project;

class APayment extends MemfisModel
{
    protected $table = "a_payments";

    protected $fillable = [
		'approve',
		'transactionnumber',
		'transactiondate',
		'id_supplier',
		'accountcode',
		'refno',
		'currency',
		'exchangerate',
		'totaltransaction',
		'description',
		'id_project',
    ];

	protected $appends = [
		'date',
		'created_by',
		'approved_by',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

	public function getApprovedByAttribute()
	{
		$approval = $this->approvals->first();
		$conducted_by = @User::find($approval->conducted_by)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$approval->created_at;
		}

		return $result;
	}

	public function getCreatedByAttribute()
	{
		$audit = $this->audits->first();
		$conducted_by = @User::find($audit->user_id)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$this->created_at;
		}

		return $result;
	}

	public function getDateAttribute()
	{
		return date('Y-m-d', strtotime($this->transactiondate));
	}

	static public function generateCode($code)
	{
		$data = APayment::orderBy('id', 'desc')
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

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'id_supplier');
	}

	public function apa()
	{
		return $this->hasMany(
			APaymentA::class,
			'transactionnumber',
			'transactionnumber'
		);
	}

	public function apb()
	{
		return $this->hasMany(
			APaymentB::class,
			'transactionnumber',
			'transactionnumber'
		);
	}
	public function apc()
	{
		return $this->hasMany(
			APaymentC::class,
			'transactionnumber',
			'transactionnumber'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'accountcode', 'code');
	}

	public function currencies()
	{
		return $this->belongsTo(Currency::class, 'currency', 'code');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id');
    }
}
