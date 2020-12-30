<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Approval;
use App\Models\Employee;
use Carbon\Carbon;

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
            ->whereYear('created_at', Carbon::now()->format('Y'))
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

		$code = $code."-".date('Y')."/".$number;

		return $code;
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'id_employee');
	}

}
