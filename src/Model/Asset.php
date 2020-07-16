<?php

namespace memfisfa\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\MemfisModel;
use App\User;
use App\Models\Approval;

class Asset extends MemfisModel
{

    protected $fillable = [
		'active',
		'approve',
		'transaction_number',
		'name',
		'group',
		'manufacturername',
		'brandname',
		'modeltype',
		'productiondate',
		'serialno',
		'warrantystart',
		'warrantyend',
		'ownership',
		'location',
		'pic',
		'grnno',
		'pono',
		'povalue',
		'salvagevalue',
		'supplier',
		'fixedtype',
		'usefullife',
		'depreciationstart',
		'depreciationend',
		'coaacumulated',
		'coaexpense',
		'usestatus',
		'description',
		'company_department',
		'asset_category_id',
		'count_journal_report',
    ];

	protected $appends = [
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

	public function type()
	{
		return $this->belongsTo(TypeAsset::class, 'group', 'id');
	}

	public function coa_accumulate()
	{
		return $this->belongsTo(
			Coa::class, 'coaacumulated', 'code'
		);
	}

	public function coa_expense()
	{
		return $this->belongsTo(Coa::class, 'coaexpense', 'code');
	}

	public function category()
	{
		return $this->belongsTo(TypeAsset::class, 'asset_category_id');
	}

	static public function generateCode($code = "FAMS")
	{
		$asset = Asset::orderBy('id', 'desc')
			->where('transaction_number', 'like', $code.'%');

		if (!$asset->count()) {

			if ($asset->withTrashed()->count()) {
				$order = $asset->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $asset->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y')."/".$number;

		return $code;
	}
}
