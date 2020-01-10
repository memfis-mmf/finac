<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\MemfisModel;
use App\User;

class TypeAsset extends MemfisModel
{
    protected $fillable = [
		"code",
		"name",
		"accountcode",
		"usefullife",
	];

	protected $appends = [
		'created_by',
	];

	public function getCreatedByAttribute()
	{
		return User::find($this->audits->first()->user_id);
	}

	public function coa()
	{
		return $this->belongsTo(
			Coa::class,
			'accountcode',
			'code'
		);
	}
}
