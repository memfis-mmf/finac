<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FefoIn;
use App\Models\InventoryOut;
use App\Models\ItemRequest;
use App\Models\Pivots\MaterialRequestItem;
use App\Models\Project;
use memfisfa\Finac\Model\TrxJournal;
use memfisfa\Finac\Model\TrxJournalA;

class ProfitLossProjectController extends Controller
{
    /**
     * function ini berisi tentang PL Project HM dari journal (amount nya)
     * @param object $request
     * @return PDF
     */
    public function index(Request $request)
    {

        $get_item = $this->getProjectItem($request->project_uuid);

        if (!$get_item['status']) {
            return response([
                'status' => $get_item['status'],
                'message' => $get_item['message']
            ], 422);
        }

        $project = $get_item['main_project'];
        $project_number = $project->number;

        $journal_number = TrxJournal::select('voucher_no')
            ->where('ref_no', $project_number)
            ->where('approve', true)
            ->pluck('voucher_no')
            ->all();

        // mengambil debit dan credit journal
        $journal_value = TrxJournalA::select('debit', 'credit')
            ->whereHas('coa.type', function($type) {
                $type->where('code', 'biaya')
                    ->orWhere('code', 'pendapatan');
            })
            ->whereIn('voucher_no', $journal_number)
            ->get();

        $pdf = \PDF::loadView('formview::profit-loss-project', $data);
        return $pdf->stream();
    }

    public function getProjectItem($project_uuid)
    {
        $selected_column = [
            'id',
            'uuid',
            'code',
            'parent_id',
            'title',
            'customer_id',
            'aircraft_id',
            'no_wo',
            'aircraft_register',
            'aircraft_sn',
            'data_defectcard',
            'data_htcrr',
            'station',
            'csn',
            'cso',
            'tsn',
            'tso',
        ];

        // mengambil project utama/project induk (bukan additional project)
        $project = Project::select($selected_column)
            ->where('uuid', $project_uuid)
            ->withCount('approvals')
            ->having('approvals_count', '>=', 2) // mengambil status project yang minimal quotation approve
            ->whereNull('parent_id') // mengambil project induk (bukan additional project)
            ->firstOrFail();

        // mengambil uid project additionalnya
        $project_uuid = Project::select($selected_column)
            ->withCount('approvals')
            ->having('approvals_count', '>=', 2) // mengambil status project yang minimal quotation approve
            ->where('parent_id', $project->id) // mengambil project additional berdasarkan project induk
            ->pluck('uuid')
            ->all();
        
        // menambahkan id project induk ke dalam array index pertama
        array_unshift($project_uuid, $project->uuid);

        // menganmbil material request atas project yang sudah diambil sebelumnya
        $item_request_id = ItemRequest::whereIn('ref_uuid', $project_uuid)
            ->has('approvals')
            ->pluck('id')
            ->all();

        $iv_out_number = InventoryOut::where('inventoryoutable_type', 'App\Models\ItemRequest')
            ->where('inventoryoutable_id', $item_request_id)
            ->pluck('number')
            ->all();

        // mengambil data journal atas referensi iv out dari item request
        $journal_number = TrxJournal::whereIn('ref_no', $iv_out_number)
            ->where('approve', 1)
            ->pluck('voucher_no')
            ->all();

        $detail_journal = TrxJournalA::whereIn('voucher_no', $journal_number)
            ->get();

        $revenue = [];
        $expense = [];

        foreach ($detail_journal as $detail_journal_row) {
            if ($detail_journal_row->coa->type->code == 'pendapatan') {
                $value = $detail_journal_row->debit + $detail_journal_row->credit;
                if (@$revenue[$detail_journal_row->coa->code]) {
                    $value = $revenue[$detail_journal_row->coa->code] + $value;
                }

                $revenue[$detail_journal_row->coa->code] = [
                    'name' => $detail_journal_row->coa->name,
                    'value' => $value
                ];
            }

            if ($detail_journal_row->coa->type->code == 'biaya') {
                $value = $detail_journal_row->debit + $detail_journal_row->credit;
                if (@$expense[$detail_journal_row->coa->code]) {
                    $value = $expense[$detail_journal_row->coa->code] + $value;
                }

                $expense[$detail_journal_row->coa->code] = [
                    'name' => $detail_journal_row->coa->name,
                    'value' => $value
                ];
            }

        }

        $data = [
            'main_project' => $project,
            'revenue' => $revenue,
            'expense' => $expense,
        ];

        dd($data);

        return $data;
    }

    public function inventoryExpenseDetail(Request $request)
    {
        $get_item = $this->getProjectItem($request->project_uuid);

        if (!$get_item['status']) {
            return response([
                'status' => $get_item['status'],
                'message' => $get_item['message']
            ], 422);
        }

        array_unshift($project, $project);
    }
}
