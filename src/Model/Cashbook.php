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
        'exchangerate',
        'accountcode',
        'totaltransaction',
        'description',
        'createdby',
        'location',
        'company_department',
        'cashbook_ref',
        'id_project',
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
		$data = Cashbook::orderBy('id', 'desc')
            ->whereYear('created_at', Carbon::now()->format('Y'))
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

		$code = $code."-".date('Y')."/".$number;

		return $code;
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
    
    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id');
    }
}
