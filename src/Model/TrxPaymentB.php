<?php

namespace memfisfa\Finac\Model;

use App\Models\Project;
use memfisfa\Finac\Model\MemfisModel;
use memfisfa\Finac\Model\Coa;
use Illuminate\Database\Eloquent\Model;

// ini model detail SI General
class TrxPaymentB extends MemfisModel
{
    protected $table = "trxpaymentb";

    protected $fillable = [
		'transaction_number',
		'code',
		'total',
		'description',
		'project_id',
    ];

    protected $appends = [
        'project_formated'
    ];

    /**
     * trigger event saat CRUD
     */
    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            self::updateGrandtotalSI($model);
        });

        self::updated(function ($model) {
            self::updateGrandtotalSI($model);
        });

        self::deleted(function ($model) {
            self::updateGrandtotalSI($model);
        });
    }

    public function getProjectFormatedAttribute()
    {
        $project = $this->project;

        if (! $project) {
            return;
        }

        return "{$project->code} [{$project->customer->name}] | {$project->aircraft_register}";
    }

    private static function updateGrandtotalSI($model)
    {
        $trxpayment_class = new TrxPayment();

        $si = $model->si;
        $calculate_grandtotal = $trxpayment_class->calculateGrandtotalSIGeneral($si);

        $si->update([
            'grandtotal' => $calculate_grandtotal['total_idr'],
            'grandtotal_foreign' => $calculate_grandtotal['total'],
        ]);

    }

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'code', 'code');
    }
    
	public function si()
	{
		return $this->belongsTo(
			TrxPayment::class,
			'transaction_number',
			'transaction_number'
		);
	}

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
