<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\MemfisModel;
use App\User;

class Asset extends MemfisModel
{

    protected $fillable = [
		'active',
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
}
