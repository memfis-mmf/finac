<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\Coa;
use App\Models\Vendor;
use memfisfa\Finac\Model\TrxPaymentA;
use App\Models\Approval;
use App\User;
use App\Models\Currency;
use Illuminate\Support\Carbon;
use App\Models\Project;
use App\Models\TrxPaymentAdj;

class TrxPayment extends MemfisModel
{
    protected $table = "trxpayments";

    protected $fillable = [
		'approve',
		'closed',
		'transaction_number',
		'transaction_status',
		'transaction_date',
		'x_type',
		'id_supplier',
		'currency',
		'exchange_rate',
		'discount_percent',
		'discount_value',
		'ppn_percent',
		'ppn_value',
		'grandtotal_foreign',
		'grandtotal',
		'account_code',
		'description',
		'id_project',
		'location',
    ];

	protected $appends = [
        'ap_amount',
        'ending_balance',
		'exchange_rate_fix',
		'total',
		'created_by',
		'updated_by',
        'approved_by',
        'department',
		'status',
		'due_date',
		'print_date',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function getApAmountAttribute()
    {
        $apa = $this->apa()->whereHas('ap', function($ap) {
                $ap->where('approve', true);
            })
            ->get();

        $debit = 0;
        $debit_idr = 0;
        $credit = 0;
        $credit_idr = 0;

        $result = [];
        foreach ($apa as $apa_row) {
            $debit += $apa_row->debit;
            $debit_idr += $apa_row->debit_idr;
            $credit += $apa_row->credit;
            $credit_idr += $apa_row->credit_idr;
        }
        
        $result = [
            'debit' => $debit,
            'debit_idr' => $debit_idr,
            'credit' => $credit,
            'credit_idr' => $credit_idr,
        ];

        return $result;
    }

    public function getEndingBalanceAttribute()
    {
        $result = [
            'amount' => $this->grandtotal_foreign - $this->ap_amount['debit'],
            'amount_idr' => $this->grandtotal - $this->ap_amount['debit_idr'],
        ];

        return $result;
    }

	public function getApprovedByAttribute()
	{
		$approval = $this->approvals->first();
		$conducted_by = @User::find($approval->conducted_by)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$approval->created_at;
		}

		return $result;
    }

	public function getDepartmentAttribute()
	{
        if (@$this->approvals->first()) {
            $result = @$this->approvals->first()->conductedBy->department->last()->name;
        }else{
            $result = '';
        }

		return $result;
	}

	public function getCreatedByAttribute()
	{
		$audit = $this->audits->first();
		$conducted_by = @User::find($audit->user_id)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$this->created_at;
		}

		return $result;
	}

	public function getUpdatedByAttribute()
	{
		$tmp = $this->audits;

		$result = '-';

		if (count($tmp) > 1) {
			$result = User::find($tmp[count($tmp)-1]->user_id)->name
			.' '.$this->created_at;
		}

		return $result;
	}

	public function getExchangeRateFixAttribute()
	{
		return number_format($this->exchange_rate, 0, ',', '.');
	}

	public function getTotalAttribute()
	{
		$total = $this->grandtotal_foreign;

		if ($this->currency == 'idr') {
			$total = $this->grandtotal;
		}

		return $total;
	}

	public function getStatusAttribute()
	{
		$apa_tmp = $this->apa;

        // if account payable detail is empty
        if ($this->approve) {
            $status = 'Approved';
        }else{
            $status = 'Open';
        }

        // check if supplier invoice is used in account payable
        if (count($apa_tmp) < 1) {
            if ($this->approve) {
                return 'Approved';
            }else{
                return 'Open';
            }
        }

        // get account payable where account payable is approved
        $ap_tmp = $apa_tmp[0]->ap()->where('approve', 1)->first();
        if (!$ap_tmp) {
            if ($this->approve) {
                return 'Approved';
            }else{
                return 'Open';
            }
        }
        // get all account payable same supplier
		$ap = APayment::where('id_supplier', $ap_tmp->id_supplier)->get();

		$total = 0;

        // loop account payable
		foreach ($ap as $key_ap) {
			$apa = $key_ap->apa;

			foreach ($apa as $key_apa) {
				$total += ($key_apa->debit * $key_ap->exchangerate);
			}
		}

		if ($total >= ($this->grandtotal_foreign * $this->exchange_rate)) {
			$status = 'Closed';
        }

		return $status;
	}

	public function getDueDateAttribute()
	{
		$date_tmp = new Carbon($this->transaction_date);
		$date = $date_tmp->addDays($this->closed)->format('Y-m-d');

		return $date;
    }

	public function getPrintDateAttribute()
	{
		$date = Carbon::now()->format('d F Y H:i');

		return $date;
	}

	static public function generateCode($code = "SITR")
	{
		$data = TrxPayment::orderBy('id', 'desc')
            ->whereYear('created_at', Carbon::now()->format('Y'))
			->where('transaction_number', 'like', $code.'%');

		if (!$data->count()) {

			if ($data->withTrashed()->count()) {
				$order = $data->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $data->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y')."/".$number;

		return $code;
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'id_supplier');
	}

	public function trxpaymenta()
	{
		return $this->hasMany(TrxPaymentA::class,
			'transaction_number',
			'transaction_number'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'account_code', 'code');
	}

	public function apa()
	{
		return $this->hasMany(APaymentA::class,
			'id_payment'
		);
	}

	public function currencies()
	{
		return $this->belongsTo(Currency::class, 'currency', 'code');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id');
    }

    public function detail_general()
    {
        return $this->hasMany(TrxPaymentB::class, 'transaction_number', 'transaction_number');
    }

    public function adjustment()
    {
        return $this->hasMany(TrxPaymentAdj::class, 'trxpayments_id');
    }

    public function calculateGrandtotalSIGeneral($si)
    {
        $total = $si->detail_general()->get()->sum('total');

        /**
         * ini yang ditotal debitnya saja 
         * karena memang total hutangnya dihitung dari total kolom debit
         */
        $total += $si->adjustment()->get()->sum('debit');

        if ($si->currencies->code == 'idr') {
            return [
                'total' => $total,
                'total_idr' => $total
            ];
        }

        return [
            'total' => $total,
            'total_idr' => $total * $si->exchange_rate
        ];
    }
}
