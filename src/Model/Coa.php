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

    protected $hidden = [];

	public function getCoaNumberAttribute()
	{
        // mengambil angka depan dari coa code
		return explode('0', $this->code)[0];
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
        $level = strlen($this->coa_number) - 2;

        switch ($level) {
            case 1:
                $badge = 'primary';
                break;
            case 2:
                $badge = 'info';
                break;
            case 3:
                $badge = 'warning';
                break;
            case 3:
                $badge = 'danger';
                break;
            
            default:
                $badge = 'primary';
                break;
        }

        $indent = '';
        for ($i=0; $i < $level; $i++) { 
            $indent .= '&nbsp;&nbsp;&nbsp;';
        }

        return '<span class="badge badge-pill badge-'.$badge.'">'.$indent.'</span>&nbsp;'.$this->code.' - '.$this->name;
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
