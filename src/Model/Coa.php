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
		'active',
		'coa_tree',
	];

	public function getCoaNumberAttribute()
	{
		return str_replace('0', '', $this->code);
    }

	public function getActiveAttribute()
	{
        $active = true;

        if ($this->deleted_at) {
            $active = false;
        }

        return $active;
    }
    
    public function getCoaTreeAttribute()
    {
        $total_space = strlen($this->coa_number) - 4;

        $space = '';
        for ($i=0; $i < $total_space; $i++) { 
            $space .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }

        return $space.$this->code.' - '.$this->name;
    }

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
