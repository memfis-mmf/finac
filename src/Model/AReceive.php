<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;
use App\Models\Customer;
use App\User;
use App\Models\Approval;
use App\Models\ARWorkshop;
use App\Models\Project;
use Carbon\Carbon;

class AReceive extends MemfisModel
{
    protected $table = "a_receives";

    protected $fillable = [
        'approve',
        'transactionnumber',
        'transactiondate',
        'id_customer',
        'accountcode',
        'refno',
        'currency',
        'exchangerate',
        'totaltransaction',
        'description',
        'id_project',
        'payment_type',
    ];

    protected $appends = [
        'date',
        'created_by',
        'approved_by',
        'status'
    ];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function getApprovedByAttribute()
    {
        $approval = $this->approvals->first();
        $conducted_by = @User::find($approval->conducted_by)->name;

        $result = '-';

        if ($conducted_by) {
            $result = $conducted_by . ' ' . $approval->created_at;
        }

        return $result;
    }

    public function getCreatedByAttribute()
    {
        $audit = $this->audits->first();
        $conducted_by = @User::find($audit->user_id)->name;

        $result = '-';

        if ($conducted_by) {
            $result = $conducted_by . ' ' . $this->created_at;
        }

        return $result;
    }

    public function getDateAttribute()
    {
        return date('Y-m-d', strtotime($this->transactiondate));
    }

    public function getStatusAttribute()
    {
        return ($this->approve) ? 'Approved' : 'Open';
    }

    static public function generateCode($code)
    {
		$ar_workshop = ARWorkshop::orderBy('transactionnumber', 'desc')
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->where('transactionnumber', 'like', $code.'%')
            ->first();

		$ar_hm = AReceive::orderBy('transactionnumber', 'desc')
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->where('transactionnumber', 'like', $code.'%')
            ->first();

        $explode_workshop = explode('/', $ar_workshop->transactionnumber ?? '/');
        $number_workshop = ltrim(end($explode_workshop), '0');

        $explode_hm = explode('/', $ar_hm->transactionnumber ?? '/');
        $number_hm = ltrim(end($explode_hm), '0');

        $data = ($number_workshop > $number_hm)? $ar_workshop: $ar_hm;

        if (!$data) {
            $count = 1;
        } else {
            $explode = explode('/', $data->transactionnumber);
            $number = end($explode);
            $count = ltrim($number, '0') + 1;
        }

		$number = str_pad($count, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y')."/".$number;

		return $code;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function ara()
    {
        return $this->hasMany(
            AReceiveA::class,
            'ar_id'
        );
    }

    public function arb()
    {
        return $this->hasMany(
            AReceiveB::class,
            'ar_id'
        );
    }

    public function arc()
    {
        return $this->hasMany(
            AReceiveC::class,
            'ar_id'
        );
    }

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'accountcode', 'code');
    }

    public function currencies()
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id');
    }
}
