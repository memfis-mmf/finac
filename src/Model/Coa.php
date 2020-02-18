<?php

namespace memfisfa\Finac\Model;

use App\Models\Vendor;
use App\Models\Customer;
use App\Models\BankAccount;
use App\Models\Category;
use App\Models\GoodReceived;
use memfisfa\Finac\Model\MemfisModel;


class Coa extends MemfisModel
{
    protected $fillable = [
        'code',
        'name',
        'type_id',
        'description'
    ];

	protected $appends = [
		'coa_number',
		// t st'coa_render',
	];

	public function getCoaNumberAttribute()
	{
		return str_replace('0', '', $this->code);
	}

	// public function getCoaRenderNumberAttribute()
	// {
	// 	switch (strlen($this->coa_number)) {
	// 		case 2 :
	// 			// code...
	// 			break;

	// 		case 4 :
	// 			// code...
	// 			break;

	// 		case 5 :
	// 			// code...
	// 			break;

	// 		case 6 :
	// 			// code...
	// 			break;

	// 		default:
	// 			// code...
	// 			break;
	// 	}
	// }

    /*************************************** RELATIONSHIP ****************************************/

    /**
     * Polymorphic: An entity can have zero or many coa.
     *
     * This function will get all of the owning coable models.
     * See:
     *
     * @return mixed
     */
    public function customer()
    {
        return $this->morphedByMany(Customer::class, 'coable');
    }

    /**
     * Polymorphic: An entity can have zero or many coa.
     *
     * This function will get all of the owning coable models.
     * See:
     *
     * @return mixed
     */
    public function category()
    {
        return $this->morphedByMany(Category::class, 'coable');
    }

    /**
     * Polymorphic: An entity can have zero or many coa.
     *
     * This function will get all of the owning coable models.
     * See:
     *
     * @return mixed
     */
    public function good_receiced()
    {
        return $this->morphedByMany(GoodReceived::class, 'coable');
    }

    /**
     * Polymorphic: An entity can have zero or many coa.
     *
     * This function will get all of the owning coable models.
     * See:
     *
     * @return mixed
     */
    public function vendor()
    {
        return $this->morphedByMany(Vendor::class, 'coable');
    }

    public function bank_account()
    {
        return $this->morphedByMany(BankAccount::class, 'coable');
    }

	public function type()
	{
		return $this->belongsTo(
			'App\Models\Type',
			'type_id'
		);
	}

}
