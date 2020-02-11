<?php

namespace memfisfa\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\MemfisModel;
use App\User;

class Asset extends MemfisModel
{

    protected $fillable = [
		'active',
		'approve',
		'code',
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
    ];

	protected $appends = [
		'created_by',
	];

	public function getCreatedByAttribute()
	{
		return User::find($this->audits->first()->user_id);
	}

	public function type()
	{
		return $this->belongsTo(TypeAsset::class, 'group', 'id');
	}

	public function coa_accumulate()
	{
		return $this->belongsTo(Coa::class, 'coaacumulated', 'code');
	}

	public function coa_expense()
	{
		return $this->belongsTo(Coa::class, 'coaexpense', 'code');
	}
}
