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
		return @User::find($this->approvals->first()->conducted_by);
	}

	public function getCreatedByAttribute()
	{
		return @User::find($this->audits->first()->user_id);
	}

	public function type()
	{
		return $this->belongsTo(TypeAsset::class, 'group', 'id');
	}

	public function coa_accumulate()
	{
		return $this->belongsTo(
			Coa::class, 'coaacumulated', 'transaction_number'
		);
	}

	public function coa_expense()
	{
		return $this->belongsTo(Coa::class, 'coaexpense', 'transaction_number');
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

		$code = $code."-".date('Y/m')."/".$number;

		return $code;
	}
}
