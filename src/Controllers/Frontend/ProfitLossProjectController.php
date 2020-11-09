<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FefoIn;
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
        
        $revenue = [];
        $expense = [];

        foreach ($journal_value as $value_row) {
            if ($value_row->coa->type->code == 'pendapatan') {
                $revenue[] = [
                    'debit' => $value_row->debit,
                    'credit' => $value_row->credit,
                ];
            }

            if ($value_row->coa->type->code == 'biaya') {
                $expense[] = [
                    'debit' => $value_row->debit,
                    'credit' => $value_row->credit,
                ];
            }
        }

        $data = [
            'revenue' => $revenue,
            'expense' => $expense,
        ];

        dd($data);

        $pdf = \PDF::loadView('formview::profit-loss-project', $data);
        return $pdf->stream();
    }

    public function getProjectItem($project_uuid)
    {
        $project = Project::where('uuid', $project_uuid)
            ->withCount('approvals')
            ->having('approvals_count', '>=', 2) // mengambil status project yang minimal quotation approve
            ->whereNull('parent_id') // mengambil project induk (bukan additional project)
            ->firstOrFail();

        // mengambil id project additionalnya
        $project_number = Project::withCount('approvals')
            ->having('approvals_count', '>=', 2) // mengambil status project yang minimal quotation approve
            ->where('parent_id', $project->id) // mengambil project additional berdasarkan project induk
            ->pluck('uuid')
            ->all();
        
        // menambahkan id project induk ke dalam array
        array_unshift($project_number, $project->id);

        $item = MaterialRequestItem::where();

        $item_request = ItemRequest::whereIn('ref_uuid', $project_number)
            ->get();

        foreach ($item_request as $item_request_row) {
            $item = $item_request_row->items;

            $fefo_in = FefoIn::where('item_id', $item->id)
                ->where('storage_id', $item_request_row->storage_id)
                ->where('serial_number', $item->pivot->serial_number)
                ->whereRaw('quantity - used_quantity - IFNULL(loaned_quantity, 0) > 0');

            if ($item->pivot->reference) {
                $query = $fefo_in
                    ->where('reference', $item->pivot->reference);
            }
        }

        return [
            'main_project' => $project
        ];
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
