<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;
use App\Models\Vendor;
use App\User;
use App\Models\Approval;
use App\Models\Project;
use Carbon\Carbon;

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
		'location',
		'department',
		'currency',
		'exchangerate',
		'totaltransaction',
		'description',
		'id_project',
        'payment_type',
    ];

    protected $dates = [
        'transactiondate'
    ];

	protected $appends = [
		'date',
		'created_by',
		'approved_by',
		'status',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

	public function getCreatedByAttribute()
	{
		$audit = $this->audits->first();
		$conducted_by = @User::find($audit->user_id)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$this->created_at->format('d-m-Y H:i:s');
		}

		return $result;
    }

	public function getApprovedByAttribute()
	{
		$approval = $this->approvals->first();
		$conducted_by = @User::find($approval->conducted_by)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$approval->created_at->format('d-m-Y H:i:s');
		}

		return $result;
	}

	public function getStatusAttribute()
	{

        $status = 'Open';
        if ($this->approve) {
            $status = 'Approved';
        }

		return $status;
	}

	public function getDateAttribute()
	{
		return date('Y-m-d', strtotime($this->transactiondate));
	}

	static public function generateCode($code)
	{
		return self::generateTransactionNumber(self::class, 'transactionnumber', $code);
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'id_supplier');
	}

	public function apa()
	{
		return $this->hasMany(
			APaymentA::class,
			'ap_id'
		);
	}

	public function apb()
	{
		return $this->hasMany(
			APaymentB::class,
			'ap_id'
		);
    }

	public function apc()
	{
		return $this->hasMany(
			APaymentC::class,
			'ap_id'
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
