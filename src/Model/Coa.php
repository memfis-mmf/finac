<?php

namespace memfisfa\Finac\Model;

use App\Models\Vendor;
use App\Models\Customer;
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

	public function type()
	{
		return $this->belongsTo(
			'App\Models\Type',
			'type_id'
		);
	}

}
