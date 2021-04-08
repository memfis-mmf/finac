<?php

namespace memfisfa\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\MemfisModel;
use App\User;
use App\Models\Approval;
use App\Models\GoodsReceived;
use Carbon\Carbon;

class Asset extends MemfisModel
{

    protected $fillable = [
		'active',
		'approve',
		'transaction_number',
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
		'coadepreciation',
		'coaexpense',
		'usestatus',
		'description',
		'company_department',
		'asset_category_id',
		'count_journal_report',
        'asset_code',
        'location_remark',
    ];

    protected $dates = [
        'warrantystart',
        'warrantyend'
    ];

	protected $appends = [
		'created_by',
        'approved_by',
        'depreciationstart_format',
        'depreciationend_format',
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
			$result = $conducted_by.' '.$approval->created_at;
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
    
    public function getDepreciationstartFormatAttribute()
    {
        if (!$this->depreciationstart) {
            return '-';
        }
        return Carbon::parse($this->depreciationstart)->format('Y-m-d');
    }

    public function getDepreciationendFormatAttribute()
    {
        if (!$this->depreciationend) {
            return '-';
        }
        return Carbon::parse($this->depreciationend)->format('Y-m-d');
    }

	public function type()
	{
		return $this->belongsTo(TypeAsset::class, 'asset_category_id', 'id');
	}

	public function coa_accumulate()
	{
		return $this->belongsTo(
			Coa::class, 'coaacumulated', 'code'
		);
    }

	public function coa_expense()
	{
		return $this->belongsTo(Coa::class, 'coaexpense', 'code');
	}

	public function coa_depreciation()
	{
		return $this->belongsTo(Coa::class, 'coadepreciation', 'code');
	}

	public function category()
	{
		return $this->belongsTo(TypeAsset::class, 'asset_category_id');
    }
    
    public function grn()
    {
        return $this->belongsTo(GoodsReceived::class, 'grnno', 'number');
    }

    public function journal()
    {
        return $this->hasMany(TrxJournal::class, 'ref_no', 'transaction_number');
    }

	static public function generateCode($code = "FAMS")
	{
		$asset = Asset::orderBy('id', 'desc')
            ->whereYear('created_at', Carbon::now()->format('Y'))
			->where('transaction_number', 'like', $code.'%');

		if (!$asset->count()) {

			if ($asset->withTrashed()->count()) {
				$order = $asset->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $asset->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y')."/".$number;

		return $code;
	}
}
