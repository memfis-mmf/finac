<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use App\Models\Approval;
use App\Models\Currency;
use App\User;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
        'second_currency',
        'exchangerate',
        'accountcode',
        'totaltransaction',
        'description',
        'createdby',
        'location',
        'company_department',
        'cashbook_ref',
        'id_project',
        'quotation_workshop_id',
    ];

    protected $dates = [
        'transactiondate'
    ];

	protected $appends = [
		'approved_by',
		'created_by',
		'cashbook_type',
		'account_name',
		'status',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

	// append

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

	public function getCashbookTypeAttribute()
	{
		if (Str::contains($this->transactionnumber, 'BP')) {
			$result = 'bp';
		}
		if (Str::contains($this->transactionnumber, 'BR')) {
			$result = 'br';
		}
		if (Str::contains($this->transactionnumber, 'CP')) {
			$result = 'cp';
		}
		if (Str::contains($this->transactionnumber, 'CR')) {
			$result = 'cr';
		}

		return $result;
	}

	public function getAccountNameAttribute()
	{
		return $this->coa->name;
	}

	public function getStatusAttribute()
	{
		$status = 'Open';
		if ($this->approve) {
			$status = 'Approved';
		}

		return $status;
	}

	// end append

	static public function generateCode($code = "SITR")
	{
		return self::generateTransactionNumber(self::class, 'transactionnumber', $code);
    }
    
    public function journal()
    {
        return $this->belongsTo(TrxJournal::class, 'transactionnumber', 'ref_no');
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

	public function second_currencies()
	{
		return $this->belongsTo(Currency::class, 'second_currency', 'code');
    }
    
    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id');
    }

    public function quotation_workshop()
    {
        return $this->belongsTo(QuotationWorkshop::class, 'quotation_workshop_id', 'id');
    }
}
