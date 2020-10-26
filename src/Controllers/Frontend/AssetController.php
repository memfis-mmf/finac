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
use memfisfa\Finac\Model\Coa;

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
            'transaction_number' => Asset::generateCode(),
            'povalue' => 0,
            'coaexpense' => Coa::find(214)->code
		]);

        $asset = Asset::create($request->all());
        return response()->json($asset);
    }

    public function show($uuid)
    {
        $asset = Asset::where('uuid', $uuid)->firstOrFail();
        $data = [
            'asset' => $asset,
            'type_asset' => TypeAsset::all(),
            'company' => Department::with(['type', 'parent'])->get(),
            'page' => 'show'
        ];

        return view('masterassetview::edit', $data);
    }

    public function edit(Request $request)
    {
		$asset = Asset::where('uuid', $request->asset)->with([
			'type',
        ])->first();

        if (!$asset->coaexpense) {
            Asset::where('id', $asset->id)
                ->update([
                    'coaexpense' => Coa::find(214)->code
                ]);
        }

        $data = [
            'asset' => $asset,
            'type_asset' => TypeAsset::all(),
            'company' => Department::with('type','parent')->get()
        ];

        return view('masterassetview::edit', $data);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'usefullife' => 'required|numeric|min:1',
                'povalue' => 'required|numeric|min:1',
                'coaexpense' => 'required|numeric',
                'coaacumulated' => 'required|numeric',
                'coadepreciation' => 'required|numeric',
            ],
            [
                'povalue.min' => 'Asset value must be at least 1',
                'coaacumulated.required' => 'Accumulate Depreciation Account cannot be empty',
                'coadepreciation.required' => 'Depreciation Account cannot be empty',
            ]
        );

		$asset_tmp = Asset::where('uuid', $request->asset);

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
			'coaexpense',
			'coaacumulated',
			'coadepreciation',
			'warrantystart',
			'warrantyend',
		];

        $asset_tmp->update($request->only($list));

        return [
            'status' => true,
            'message' => 'Data saved'
        ];
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
                'coa_depreciation',
                'coa_expense',
            ])
            ->select('assets.*');

        return DataTables::of($data)
        ->addColumn('action', function($row) {
            $html = '';
            if (!$row->approve) {
                $html .= 
                    '<a 
                        href="'.route('asset.edit', $row->uuid).'" 
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" 
                        title="Edit" 
                        data-uuid="'.$row->uuid.'"> 
                        <i class="la la-pencil"></i> 
                    </a>
                    <a 
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" 
                        href="#" 
                        data-uuid="'.$row->uuid.'"
                        title="Delete">
                        <i class="la la-trash"></i> 
                    </a>
                    <a 
                        href="javascript:;" 
                        data-uuid="'.$row->uuid.'" 
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill approve" 
                        title="Approve" 
                        data-uuid="'.$row->uuid.'">
                        <i class="la la-check"></i>
                    </a>';
            }

            if ($row->approve) {
                $html .= 
                    '<button 
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill history-depreciation"
                        data-url="'.route('asset.history.depreciation').'?asset_uuid='.$row->uuid.'"
                        data-uuid="'.$row->uuid.'"
                        title="History Depreciation">
                        <i class="fa fa-copy"></i> 
                    </button>';
            }

            return $html;
        })
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
				'coa_detail' => $asset->coa_expense->id, // coa : 31121001
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

    /**
     * fungsi untuk autojournal depreciation
     * 
     * @param  date $date_generate ini berisi tanggal kapan asset akan didepresiasikan
     */
	public function autoJournalDepreciation(Request $request)
	{

        $date_generate = $request->date_generate;

		$asset = Asset::where('approve', 1)->get();

        DB::beginTransaction();
        
        // looping sebanyak asset yang sudah di approve
        foreach ($asset as $asset_row) {

            $asset_row->date_generate = Carbon::createFromFormat('Y-m-d', $date_generate);

            // mengambil tanggal approve
            $date_approve = $asset_row
                ->approvals
                ->first()
                ->created_at
                ->toDateTimeString();

            // set depreciation start (depreciation start sama dengan tanggal approve)
            $depreciationStart = new Carbon($date_approve);
            
            // set depreciation end (deprection end sama dengan depreciation start ditambah bulan useful life)
			$depreciationEnd = $depreciationStart->addMonths($asset_row->usefullife);

            // mecari total hari dari depreciation start sampai depreciation end
			$day = $depreciationEnd->diffInDays($depreciationStart);

            // set value per hari
			$value_per_day = ($asset_row->povalue - $asset_row->salvagevalue) / $day;
            
            // jika tanggal generate lebih besar dari tanggal akhir depreciation
            if ($asset->date_generate > $depreciationEnd) {
                // return response([
                //     'status' => false,
                //     'message' => 'Date cannot more than depreciation end date '
                //         . $depreciationEnd->format('Y-m-d')
                // ], 422);

                continue;
            }

            // mengambil journal terakhir atas asset
            $journal = TrxJournal::where('ref_no', $asset->transaction_number)
                ->orderBy('id', 'desc')
                ->first();

            // set tanggal awal
            $start_date = Carbon::createFromFormat('Y-m-d', $journal->transaction_date);

            // set tanggal akhir
            $end_date = $asset->date_generate;

            /**
             * pengecekan apakah end_date (date generate) 
             * lebih kecil sama dengan dari tanggal laporan journal terakhir atas asset tersebut
             */
            if ($end_date <= $start_date) {
                // return response([
                //     'status' => false,
                //     'message' => 'Date cannot less than last report ' 
                //         . $start_date->format('Y-m-d')
                // ], 422);

                continue;
            }

            // mencari seilish hari
            $diff_date = $start_date->diffInDays($end_date);

            // total nilai atas selisih hari
            $value = $diff_date * $value_per_day;

            // melakukan penjurnalan
            $this->scheduledJournal($asset_row, $value);
        }

		DB::commit();
	}

    /**
     * fungsi untuk skeduling journal
     * 
     * @param collection $asset berisi collection dari asset
     * @param bigInteger $value berisi value (harga)
     */
	public function scheduledJournal($asset, $value)
    {
        DB::beginTransaction();

        $asset->approvals()->save(new Approval([
            'approvable_id' => $asset->id,
            'conducted_by' => Auth::id(),
        ]));

        $header = (object) [
            'voucher_no' => $asset->transaction_number,
            'transaction_date' => $asset->date_generate,
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
                'coa_detail' => $header->coadepreciation->coa->id,
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

        if (!$autoJournal['status']) {
            return response([
                'status' => false,
                'message' => 'Something went wrong'
            ], 422);
        }

        DB::commit();

        return response([
            'status' => true,
            'message' => 'Generate success'
        ]);

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

    public function historyDepreciation(Request $request)
    {
        $asset = Asset::where('uuid', $request->asset_uuid)->firstOrFail();

        $data['journal'] = TrxJournal::where('ref_no', $asset->transaction_number)
            ->orderBy('id', 'desc')
            ->get();

        return view('masterassetview::history-depreciation', $data);
    }
}
