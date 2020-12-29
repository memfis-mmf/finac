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
use App\Models\GoodsReceived;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $request->validate([
            'asset_category_id' => 'required|numeric',
            'name' => 'required',
        ]);

        $typeasset = TypeAsset::find($request->asset_category_id);
		$request->request->add([
            'transaction_number' => Asset::generateCode(),
            'povalue' => 0,
            'coaexpense' => Coa::find(214)->code,
            'usefullife' => $typeasset->usefullife
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

        if ($asset->approve) {
            return abort(404);
        }

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
                'asset_code' => 'required',
                'name' => 'required',
                'usefullife' => 'required|numeric',
                'povalue' => 'required|numeric',
                'coaexpense' => 'required|numeric',
                'coaacumulated' => 'required|numeric',
                'coadepreciation' => 'required|numeric',
            ],
            [
                'povalue.required' => 'Asset value field is required',
                'coaacumulated.required' => 'Accumulate Depreciation Account field is required',
                'coadepreciation.required' => 'Depreciation Account field is required',
            ]
        );

        $asset_tmp = Asset::where('uuid', $request->asset);

        $asset = $asset_tmp->first();

        if ($asset->approve) {
            return abort(404);
        }

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
            'asset_code',
            'location_remark',
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
                'coa_accumulate:code,name',
                'coa_depreciation:code,name',
                'coa_expense:code,name',
            ])
            ->select('assets.*');

        return DataTables::of($data)
            ->addColumn('account_asset', function($row) {
                return $row->type->coa->name.' ('.$row->type->coa->code.')';
            })
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
                        </a>';
                    // $html .=
                    //     '<a 
                    //         class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill  delete" 
                    //         href="#" 
                    //         data-uuid="'.$row->uuid.'"
                    //         title="Delete">
                    //         <i class="la la-trash"></i> 
                    //     </a>';
                    $html .=
                        '<a 
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
            
            if (!$asset->asset_code) {
                return [
                    'status' => false,
                    'message' => 'Asset Code Empty'
                ];
            }

            if ($asset->approve) {
                return [
                    'status' => false,
                    'message' => 'Asset Already approved'
                ];
            }

	        $asset->approvals()->save(new Approval([
	            'approvable_id' => $asset->id,
	            'is_approved' => 1,
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
                'status' => 2
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
                'GJV',
                true //auto approve
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
     * fungsi untuk autojournal depreciation per hari
     * 
     * @param  date $date_generate ini berisi tanggal kapan asset akan didepresiasikan
     */
	public function DepreciationPerDay(Request $request)
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
            $depreciationStart = Carbon::createFromFormat('Y-m-d H:i:s' ,$date_approve);
            
            /**
             * set depreciation end (deprection end sama dengan depreciation start ditambah bulan useful life)
             * disini inisialisasi carbon lagi karena jika menggunakan @var $depreciationStart
             * @var $deepreciationStart ikut burubah
             */
            $depreciationEnd = Carbon::createFromFormat('Y-m-d H:i:s' ,$date_approve)
                ->addMonths($asset_row->usefullife);

            // mecari total hari dari depreciation start sampai depreciation end
            $day = $depreciationEnd->diffInDays($depreciationStart);

            if ($day < 1) {
                continue;
            }
            
            // set value per hari
			$value_per_day = ($asset_row->povalue - $asset_row->salvagevalue) / $day;
            
            // jika tanggal generate lebih besar dari tanggal akhir depreciation
            if ($asset_row->date_generate > $depreciationEnd) {
                continue;
            }

            // mengambil journal terakhir atas asset
            $journal = TrxJournal::where('ref_no', $asset_row->transaction_number)
                ->orderBy('id', 'desc')
                ->first();

            // set tanggal awal
            $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $journal->transaction_date);

            // set tanggal akhir
            $end_date = $asset_row->date_generate;

            /**
             * pengecekan apakah end_date (date generate) 
             * lebih kecil sama dengan dari tanggal laporan journal terakhir atas asset tersebut
             */
            if ($end_date <= $start_date) {
                continue;
            }

            // mencari seilish hari
            $diff_date = $start_date->diffInDays($end_date);

            // total nilai atas selisih hari
            $value = $diff_date * $value_per_day;

            // melakukan penjurnalan
            $scheduled_journal = $this->scheduledJournal($asset_row, $value);

            if ($scheduled_journal['status'] != true) {
                return response([
                    'status' => false,
                    'message' => $scheduled_journal['message']
                ], 422);
            }
        }

        DB::commit();
        
        return response([
            'status' => true,
            'message' => 'Depreciation Success'
        ]);
    }

    public function DepreciationPerMonth(Request $request)
    {
        $request->validate([
            'month_generate' => 'required|date'
        ]);

        /**
         * @var date $request->month_generate ini data berisi bulan (June 2020)
         */
        $date_limit = Carbon::parse($request->month_generate)->addDays(15);
        $end_date_of_month = Carbon::parse($request->month_generate)->endOfMonth();

        /**
         * mengambil asset yang mana 
         * tanggal approve nya kurang dari tanggal generate
         */
        $asset = Asset::whereHas('approvals', function($approvals) use($date_limit) {
                $approvals->whereDate('created_at', '<=', $date_limit);
            })
            ->where('status', 2) //mengambil asset dengan status approve
            ->get();

        foreach ($asset as $asset_row) {
            $asset_row->date_generate = $end_date_of_month;

            /**
             * mengambil journal pada akhir bulan generate
             */
            $journal = TrxJournal::where('ref_no', $asset_row->transaction_number)
                ->where('transaction_date', $end_date_of_month)
                ->first();

            /**
             * jika journal di akhir bulan (journal depr) ada
             * maka loopingannya di skip
             */
            if ($journal) {
                continue;
            }

            $last_journal_asset = TrxJournal::where('ref_no', $asset_row->transaction_number)
                ->orderBy('id', 'desc')
                ->first();

            if ($last_journal_asset) {
                $last_journal_date = Carbon::parse($last_journal_asset->transaction_date)->format('Y-m');
                $month_before_generate = Carbon::parse($request->month_generate)->subMonth()->format('Y-m');

                /**
                 * pengecekan journal tidak boleh loncat bulan
                 * contoh: jika journal terakhir nya january
                 * maka tidak bisa membuat depr journal maret
                 */
                if ($last_journal_date != $month_before_generate) {
                    continue;
                }
            }

            /**
             * get total journal atas asset
             */
            $total_journal = TrxJournal::where('ref_no', $asset_row->transaction_number)
                ->count();

            /**
             * jika total journal lebih dari usefullife + 1 (journal pengakuan asset)
             */
            if ($total_journal > ($asset_row->usefullife + 1)) {
                continue;
            }

            if ($asset_row->usefullife < 1) {
                continue;
            }

            $value_per_month = ($asset_row->povalue - $asset_row->salvagevalue) / $asset_row->usefullife;

            $scheduled_journal = $this->scheduledJournal($asset_row, $value_per_month);

            if ($scheduled_journal['status'] != true) {
                return response([
                    'status' => false,
                    'message' => $scheduled_journal['message']
                ], 422);
            }
        }

        return response([
            'status' => true,
            'message' => 'Depreciation Success'
        ]);
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
            'coa_detail' => $asset->coa_accumulate->id,
            'credit' => $value,
            'debit' => 0,
            '_desc' => 'Accm Depr Asset : '
                .$asset->name
                .($asset->count_journal_report+1).
            'Month Depreciation',
        ];

        $total_credit += $detail[count($detail)-1]->credit;

        if (!$asset->coa_depreciation) {
            return [
                'status' => false,
                'message' => $asset->transaction_number . ' Account Depreciation not selected yet'
            ];
        }

        // add object in first array $detai
        array_unshift(
            $detail,
            (object) [
                'coa_detail' => $asset->coa_depreciation->id,
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
            'status' => 2,
            'count_journal_report' => $asset->count_journal_report+1
        ]);

        $autoJournal = TrxJournal::autoJournal(
            $header,
            $detail,
            'PRJR',
            'GJV',
            true // auto approve
        );

        if (!$autoJournal['status']) {
            return [
                'status' => false,
                'message' => 'Something went wrong'
            ];
        }

        DB::commit();

        return [
            'status' => true,
            'message' => 'Generate success'
        ];

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

    public function select2GetGRN(Request $request)
    {
        $grn = GoodsReceived::whereHas('items.categories', function($categories) {
                $categories->where('code', 'tool');
            })
            ->has('approvals')
            ->where('number', 'like', "%$request->q%")
            ->limit(100)
            ->get();

        $data['results'] = [];
        foreach ($grn as $grn_row) {
            $data['results'][] = [
                'id' => $grn_row->number,
                'text' => $grn_row->number,
            ];
        }

        return $data;
    }

    public function getGRNInfo(Request $request)
    {
        $grn = GoodsReceived::with([
                'purchase_order.vendor',
            ])
            ->where('number', $request->grnno)
            ->first();

        if (!$grn) {
            return [
                'status' => false,
                'message' => 'GRN not found'
            ];
        }

        return [
            'status' => true,
            'message' => 'GRN found',
            'data' => $grn
        ];
    }
}
