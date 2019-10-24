<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\MemfisModel;

class TypeAsset extends MemfisModel
{
    protected $fillable = [
		"code",
		"name",
		"accountcode",
		"usefullife",
	];

	public function coa()
	{
		return $this->belongsTo(
			Coa::class,
			'accountcode',
			'code'
		);
	}
}
