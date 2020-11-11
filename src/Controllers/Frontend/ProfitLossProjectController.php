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
        $project_tmp = Project::select($selected_column)
            ->withCount('approvals')
            ->having('approvals_count', '>=', 2) // mengambil status project yang minimal quotation approve
            ->where('parent_id', $project->id);

        $project_uuid = $project_tmp // mengambil project additional berdasarkan project induk
            ->pluck('uuid')
            ->all();
        
        $project_number = $project_tmp
            ->pluck('number')
            ->all();

        // menambahkan id project induk ke dalam array index pertama
        array_unshift($project_uuid, $project->uuid);
        array_unshift($project_number, $project->number);

        $additional_project = $project
            ->childs()
            ->select($selected_column)
            ->get();

        $all_project = Project::whereIn('uuid', $project_uuid)->get();

        $invoice_number = [];
        $quotation_number = [];

        foreach ($all_project as $all_project_row) {

            // mengambil nomer quotation dari project
            $all_project_row->quotation = Quotation::select([
                    'id',
                    'uuid',
                ])
                ->where('quotationable_type', 'App\Models\Project')
                ->where('quotationable_id', $all_project_row->id)
                ->first();

            // mengambil nomer invoice dari quotation
            $all_project_row->invoice = Invoice::select(['id', 'transactionnumber'])
                ->where('id_quotation', $all_project_row->quotation->id)
                ->first();
            
            // memasukan semua nomer invoice dari quotation ke dalam 1 array
            if ($all_project_row->invoice) {
                $invoice_number[] = $all_project_row->invoice->transactionnumber;
            }
            
            // memasukan semua nomer quotation dari project ke dalam 1 array
            $quotation_number[] = $all_project_row->quotation;
        }

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
        $journal_number = TrxJournal::where(function($journal_query) use($iv_out_number, $project_number, $invoice_number, $quotation_number) {
                /**
                 * mengambil journal yang mana ref_no nya adalah 
                 * nomer iv out, 
                 * atau nomer project, 
                 * atau nomer invoice, 
                 * atau nomer quotation
                 */
                $journal_query->whereIn('ref_no', $iv_out_number)
                    ->orWhereIn('ref_no', $project_number)
                    ->orWhereIn('ref_no', $invoice_number)
                    ->orWhereIn('ref_no', $quotation_number);
            })
            ->where('approve', 1)
            ->pluck('voucher_no')
            ->all();

        $detail_journal = TrxJournalA::whereIn('voucher_no', $journal_number)
            ->get();

        $revenue = [];
        $expense = [];
        $total_revenue = 0;
        $total_expense = 0;

        foreach ($detail_journal as $detail_journal_row) {

            $debit = $detail_journal_row->debit * $detail_journal_row->journal->exchange_rate;
            $credit = $detail_journal_row->credit * $detail_journal_row->journal->exchange_rate;

            $value = $debit + $credit;

            if ($detail_journal_row->coa->type->code == 'pendapatan') {
                if (@$revenue[$detail_journal_row->coa->code]) {
                    $value = $revenue[$detail_journal_row->coa->code] + $value;
                }

                $revenue[$detail_journal_row->coa->code] = (object) [
                    'name' => $detail_journal_row->coa->name,
                    'value' => $value,
                ];

                $total_revenue += $value;
            }

            if ($detail_journal_row->coa->type->code == 'biaya') {
                if (@$expense[$detail_journal_row->coa->code]) {
                    $value = $expense[$detail_journal_row->coa->code] + $value;
                }

                $expense[$detail_journal_row->coa->code] = (object) [
                    'name' => $detail_journal_row->coa->name,
                    'value' => $value,
                ];

                $total_expense += $value;
            }

        }

        $data = [
            'main_project' => $project,
            'additional_project' => $additional_project,
            'revenue' => $revenue,
            'expense' => $expense,
            'total_revenue' => $total_revenue,
            'total_expense' => $total_expense,
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
