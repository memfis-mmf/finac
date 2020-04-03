<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\TypeAsset;
use memfisfa\Finac\Model\Asset;
use memfisfa\Finac\Model\TrxJournal;
use memfisfa\Finac\Request\AssetUpdate;
use memfisfa\Finac\Request\AssetStore;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Company;
use App\Models\Department;
use App\Models\Approval;
use Carbon\Carbon;
use DB;
use Auth;
use DataTables;

class AssetController extends Controller
{
    public function index()
    {
        return view('masterassetview::index');
    }

	public function data()
	{
		$data = TypeAsset::all();

		$type = [];

		for ($i = 0; $i < count($data); $i++) {
			$x = $data[$i];

			$type[$x->id] = $x->name;
		}

        return json_encode($type, JSON_PRETTY_PRINT);
	}

    public function create()
    {
		$data['asset_categories'] = TypeAsset::all();
        return view('masterassetview::create', $data);
    }

    public function store(Request $request)
    {
		$request->request->add([
			'transaction_number' => Asset::generateCode()
		]);

        $asset = Asset::create($request->all());
        return response()->json($asset);
    }

    public function edit(Request $request)
    {
		$data['asset'] = Asset::where('uuid', $request->asset)->with([
			'type',
		])->first();

		$data['type_asset'] = TypeAsset::all();

        $collection = collect();
        $companies = Company::with('type','parent')->get();
        $departments = Department::with('type','parent')->get();
        $data['company'] = $collection->merge($companies)->merge($departments);

        return view('masterassetview::edit', $data);
    }

    public function update(Request $request)
    {
		$asset_tmp = Asset::where('uuid', $request->asset);
		$asset = $asset_tmp->first();

		$request->request->add([
			'warrantystart' => $this->convertDate(
				$request->daterange_master_asset
			)[0],
			'warrantyend' => $this->convertDate(
				$request->daterange_master_asset
			)[1],
		]);

		$list = [
			'name',
			'description',
			'manufacturername',
			'productiondate',
			'brandname',
			'modeltype',
			'location',
			'serialno',
			'company_department',
			'grnno',
			'pono',
			'supplier',
			'povalue',
			'salvagevalue',
			'usefullife',
			'coaacumulated',
			'coaexpense',
			'warrantystart',
			'warrantyend',
		];

        $asset_tmp->update($request->only($list));

        return response()->json($asset);
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json($asset);
    }

    public function api()
    {
        $assetdata = Asset::all();

        return json_encode($assetdata);
    }

    public function apidetail(Asset $asset)
    {
        return response()->json($asset);
    }

    public function datatables()
    {
		$data = Asset::with([
			'type',
			'type.coa',
			'coa_accumulate',
			'coa_expense',
		]);

        return DataTables::of($data)
		->escapeColumns([])
		->make(true);

    }

	public function approve(Request $request)
    {
		DB::beginTransaction();
		try {

			$asset_tmp = Asset::where('uuid', $request->uuid);
			$asset = $asset_tmp->first();

	        $asset->approvals()->save(new Approval([
	            'approvable_id' => $asset->id,
	            'is_approved' => 0,
	            'conducted_by' => Auth::id(),
	        ]));

			$date_approve = $asset->approvals->first()
			->created_at->toDateTimeString();

			$header = (object) [
				'voucher_no' => $asset->transaction_number,
				'transaction_date' => $date_approve,
				'coa' => $asset->category->coa->id,
			];

			$total_credit = 0;

			$detail[] = (object) [
				'coa_detail' => 214, // coa : 31121001
				'credit' => $asset->povalue,
				'debit' => 0,
				'_desc' => 'Fixed Asset : '
				.$asset->transaction_number.' '
				.$asset->name,
			];

			$total_credit += $detail[count($detail)-1]->credit;

			// add object in first array $detai
			array_unshift(
				$detail,
				(object) [
					'coa_detail' => $header->coa,
					'credit' => 0,
					'debit' => $total_credit,
					'_desc' => 'Fixed Asset : '
					.$asset->transaction_number.' '
					.$asset->name,
				]
			);

			Asset::where('id', $asset->id)->update([
				'approve' => 1,
				'count_journal_report' => 1
			]);

			$depreciationStart = new Carbon($date_approve);
			$depreciationEnd = new Carbon($date_approve);
			$depreciationEnd->addMonths(10);

			Asset::where('id', $asset->id)->update([
				'depreciationstart' => $depreciationStart->format('Y-m-d'),
				'depreciationend' => $depreciationEnd->format('Y-m-d'),
			]);

			$autoJournal = TrxJournal::autoJournal(
				$header,
				$detail,
				'PRJR',
				'GJV'
			);

			if ($autoJournal['status']) {

				DB::commit();

			}else{

				DB::rollBack();
				return response()->json([
					'errors' => $autoJournal['message']
				]);
			}

	        return response()->json($asset);

		} catch (\Exception $e) {

			DB::rollBack();

			$data['errors'] = $e;

			return response()->json($data);
		}

    }

	public function autoJournalDepreciation(Request $request)
	{
		$asset = Asset::where('approve', 1)->get();

		DB::beginTransaction();

		for ($index_asset=0; $index_asset < $asset; $index_asset++) {
			$arr = $asset[$index_asset];

			$date_approve = $arr->approvals->first()
			->created_at->toDateTimeString();

			$depreciationStart = new Carbon($date_approve);
			$depreciationEnd = $depreciationStart->addMonths($arr->usefullife);

			$day = $depreciationEnd->diff($depreciationStart)->days;

			$value_per_day = ($arr->povalue - $arr->salvagevalue) / $day;

			$last_day_this_month = new Carbon('last day of this month');
			$first_day_this_month = new Carbon('first day of this month');

			if (Carbon::now() != $depreciationEnd) {
				if (Carbon::now() == $last_day_this_month) {
					$this->scheduledJournal($arr, $value_per_day);
				}
			}else{
				$value_last_count = $depreciationEnd
				->diff($first_day_this_month)
				->days * $value_per_day;

				$this->scheduledJournal($arr, $value_last_count);
			}
		}

		DB::commit();
	}

	public function scheduledJournal($asset, $value)
    {
		DB::beginTransaction();
		try {

	        $asset->approvals()->save(new Approval([
	            'approvable_id' => $asset->id,
	            'is_approved' => 0,
	            'conducted_by' => Auth::id(),
	        ]));

			$date_approve = $asset->approvals->first()
			->created_at->toDateTimeString();

			$header = (object) [
				'voucher_no' => $asset->transaction_number,
				'transaction_date' => $date_approve,
				'coa' => $asset->category->coa->id,
			];

			$total_credit = 0;

			$detail[] = (object) [
				'coa_detail' => $asset->coaacumulated->coa->id,
				'credit' => $value,
				'debit' => 0,
				'_desc' => 'Accm Depr Asset : '
				.$asset->name
				.($asset->count_journal_report+1).
				'Month Depreciation',
			];

			$total_credit += $detail[count($detail)-1]->credit;

			// add object in first array $detai
			array_unshift(
				$detail,
				(object) [
					'coa_detail' => $header->coaexpense->coa->id,
					'credit' => 0,
					'debit' => $total_credit,
					'_desc' => 'Asset Depreciation : '
					.$asset->name
					.($asset->count_journal_report+1).
					'Month Depreciation',
				]
			);

			Asset::where('id', $asset->id)->update([
				'approve' => 1,
				'count_journal_report' => $asset->count_journal_report+1
			]);

			$autoJournal = TrxJournal::autoJournal(
				$header,
				$detail,
				'PRJR',
				'GJV'
			);

			if ($autoJournal['status']) {

				DB::commit();

			}else{

				DB::rollBack();
				return response()->json([
					'errors' => $autoJournal['message']
				]);
			}

	        return response()->json($asset);

		} catch (\Exception $e) {

			DB::rollBack();

			$data['errors'] = $e->getMessage();

			return response()->json($data);
		}

    }

	public function convertDate($date)
	{
		$tmp_date = explode('-', $date);

		$start = new Carbon(str_replace('/', "-", trim($tmp_date[0])));
		$startDate = $start->format('Y-m-d');

		$end = new Carbon(str_replace('/', "-", trim($tmp_date[1])));
		$endDate = $end->format('Y-m-d');

		return [
			$startDate,
			$endDate
		];
    }
}
