<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InventoryOut;
use App\Models\ItemRequest;
use App\Models\Project;
use App\Models\Quotation;
use Carbon\Carbon;
use memfisfa\Finac\Model\Invoice;
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
        $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date);

        $get_data = $this->getAllProject($request->project_uuid);

        if (!$get_data['status']) {
            return response([
                'status' => $get_data['status'],
                'message' => $get_data['message']
            ], 422);
        }

        $data = $get_data['data'];

        $quotation = Quotation::select([
                'id',
                'uuid',
                'number',
                'parent_id',
                'quotationable_type',
                'quotationable_id',
                'attention',
                'requested_at',
                'valid_until',
                'currency_id',
                'exchange_rate',
                'subtotal',
                'charge',
                'grandtotal',
                'title',
                'no_wo',
                'scheduled_payment_type',
                'scheduled_payment_amount',
                'term_of_payment',
                'term_of_condition',
                'description',
                'data_defectcard',
                'data_htcrr',
                'additionals',
            ])
            ->where('quotationable_type', 'App\Models\Project')
            ->where('quotationable_id', $data['main_project']->id)
            ->first();

        $data['quotation'] = $quotation;
        $data['invoice'] = Invoice::where('id_quotation', $quotation->id)->first();
        $data['main_project']->aircraft = json_decode($data['main_project']->origin_aircraft);

        $pdf = \PDF::loadView('formview::profit-loss-project', $data);
        return $pdf->stream();
    }

    public function getAllProject($project_uuid)
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
            'origin_aircraft'
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

        $additional_project = $project
            ->childs()
            ->select($selected_column)
            ->get();
        
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
            'additional_project' => $additional_project,
            'revenue' => $revenue,
            'expense' => $expense
        ];

        return [
            'status' => true,
            'data' => $data
        ];
    }

    public function inventoryExpenseDetail(Request $request)
    {
        $all_project = $this->getAllProject($request->project_uuid);

        if (!$all_project['status']) {
            return response([
                'status' => $all_project['status'],
                'message' => $all_project['message']
            ], 422);
        }

        $data = $all_project['data'];

        $pdf = \PDF::loadView('formview::inventory-expense-details', $data);
        return $pdf->stream();
    }
}
