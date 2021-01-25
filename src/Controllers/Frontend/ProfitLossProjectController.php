<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefectCard;
use App\Models\FefoIn;
use App\Models\InventoryOut;
use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\JobCard;
use App\Models\Pivots\MaterialRequestItem;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\Unit;
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
            ->has('approvals')
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
            'origin_aircraft',
            'origin_customer',
        ];

        // mengambil project utama/project induk (bukan additional project)
        $project = Project::select($selected_column)
            ->without('quotations')
            ->where('uuid', $project_uuid)
            ->withCount('approvals')
            ->having('approvals_count', '>=', 2) // mengambil status project yang minimal quotation approve
            ->whereNull('parent_id') // mengambil project induk (bukan additional project)
            ->firstOrFail();

        $project->customer = json_decode($project->origin_customer);

        // mengambil uid project additionalnya
        $project_tmp = Project::select($selected_column)
            ->without('quotations')
            ->withCount('approvals')
            ->having('approvals_count', '>=', 2) // mengambil status project yang minimal quotation approve
            ->where('parent_id', $project->id);

        $project_uuid = $project_tmp // mengambil project additional berdasarkan project induk
            ->pluck('uuid')
            ->all();
        
        $project_number = $project_tmp
            ->pluck('code')
            ->all();

        // menambahkan id project induk ke dalam array index pertama
        array_unshift($project_uuid, $project->uuid);
        array_unshift($project_number, $project->number);

        $all_project = Project::select($selected_column)
            ->without('quotations')
            ->whereIn('uuid', $project_uuid)
            ->get();

        $invoice_number = [];
        $quotation_number = [];

        $additional_project = [];

        foreach ($all_project as $all_project_row) {

            // mengambil nomer quotation dari project
            $all_project_row->quotation = Quotation::select([
                    'id',
                    'uuid',
                    'number'
                ])
                ->where('quotationable_type', 'App\Models\Project')
                ->where('quotationable_id', $all_project_row->id)
                ->has('approvals')
                ->first();

            $all_project_row->items = $this->getProjectItem($all_project_row, $all_project_row->quotation); 

            // mengambil nomer invoice dari quotation
            $all_project_row->invoice = Invoice::select(['id', 'transactionnumber'])
                ->where('id_quotation', $all_project_row->quotation->id)
                ->where('approve', true)
                ->first();
            
            // memasukan semua nomer invoice dari quotation ke dalam 1 array
            if ($all_project_row->invoice) {
                $invoice_number[] = $all_project_row->invoice->transactionnumber;
            }
            
            // memasukan semua nomer quotation dari project ke dalam 1 array
            $quotation_number[] = $all_project_row->quotation;

            // jika project utama
            if (!$all_project_row->parent_id) {
                $main_project = $all_project_row;
            }

            // jika ini additional
            if ($all_project_row->parent_id) {
                $additional_project[] = $all_project_row;
            }
        }

        // menganmbil material request atas project yang sudah diambil sebelumnya
        $item_request_id = ItemRequest::whereIn('ref_uuid', $project_uuid)
            ->has('approvals')
            ->pluck('id')
            ->all();

        $iv_out_number = InventoryOut::where('inventoryoutable_type', 'App\Models\ItemRequest')
            ->whereIn('inventoryoutable_id', $item_request_id)
            ->has('approvals')
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
            ->where('approve', true)
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
                    $value = $revenue[$detail_journal_row->coa->code]->value + $value;
                }

                $revenue[$detail_journal_row->coa->code] = (object) [
                    'name' => $detail_journal_row->coa->name,
                    'value' => $value,
                ];

                $total_revenue += $value;
            }

            if ($detail_journal_row->coa->type->code == 'biaya') {
                if (@$expense[$detail_journal_row->coa->code]) {
                    $value = $expense[$detail_journal_row->coa->code]->value + $value;
                }

                $expense[$detail_journal_row->coa->code] = (object) [
                    'name' => $detail_journal_row->coa->name,
                    'value' => $value,
                ];

                $total_expense += $value;
            }

        }

        $data = [
            'main_project' => $main_project,
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
            ->has('approvals')
            ->first();

        $data['quotation'] = $quotation;
        $data['invoice'] = Invoice::where('id_quotation', $quotation->id)->first();
        $data['main_project']->aircraft = json_decode($data['main_project']->origin_aircraft);
        $data['main_project']->items = $this->getProjectItem($data['main_project'], $data['quotation']);

        $pdf = \PDF::loadView('formview::inventory-expense-details', $data);
        return $pdf->stream();
    }

    public function getProjectItem($project, $quotation)
    {
        $items = [];
        if ($project->parent_id == null) {
            $quotation_id = $project->quotations->first()->id;
            $jobcards = JobCard::where('quotation_id', $quotation_id)->get();
            foreach ($jobcards as $jobcard) {
                foreach ($jobcard->materials as $item_jobcard_row) {
                    $item_jobcard_row = (object) $item_jobcard_row;

                    $unit = Unit::where('symbol', $item_jobcard_row->unit)
                        ->first();
                    $item_jobcard_row->unit_id = $unit->id;

                    $item = Item::where('code', $item_jobcard_row->code)->first();

                    $request_item = MaterialRequestItem::where('item_id', $item->id)
                        ->whereHas('request', function($request) use ($project) {
                            $request
                                ->has('approvals')
                                ->where('ref_uuid', $project->uuid);
                        })
                        ->first();

                    if (!$request_item) {
                        continue;
                    }

                    $actual_item = FefoIn::where('item_id', $item->id)
                        ->where('storage_id', $request_item->request->storage_id)
                        ->where('serial_number', $request_item->serial_number)
                        ->where('reference', $quotation->number)
                        ->first();

                    if (!$actual_item) {
                        continue;
                    }

                    $item->pivot = $item_jobcard_row;
                    $item->transaction_number = $request_item->request->number ?? null;
                    $item->quantity = $request_item->quantity;
                    $item->unit = $request_item->unit ?? null;
                    $item->price = $actual_item->price * $request_item->quantity_in_primary_unit;
                    $item->ref_no = $jobcard->number ?? null;
                    $item->used_date = $request_item->request->approvals()->orderBy('id', 'desc')->first()->created_at ?? null;
                    $item->category_name = $item->categories()->select('name')->first()->name ?? null;
                    $item->ref_status = $jobcard->progress ?? null; // ini di tiap object sudah punya field progress atau return 
                    $item->ref_type = json_decode($jobcard->origin_jobcardable)->type->code ?? json_decode($jobcard->origin_jobcardable)->eo_header->type->code ?? null; // kalau dari defect card valuenya "additional" kalau htcrr "HT/CRR"

                    $items[] = $item;
                }
            }
        } else {
            $defectcards = DefectCard::where('project_additional_id', $project->id)
                ->get();

            foreach ($defectcards as $defectcard) {
                $dc_items = $defectcard->items()
                    ->whereHas('categories', function($categories) {
                        $categories->where('code', 'raw')
                            ->orWhere('code', 'cons')
                            ->orWhere('code', 'comp');
                    })
                    ->get();

                foreach ($dc_items as $item) {

                    $request_item = MaterialRequestItem::where('item_id', $item->id)
                        ->whereHas('request', function($request) use ($project) {
                            $request
                                ->has('approvals')
                                ->where('ref_uuid', $project->uuid);
                        })
                        ->first();

                    if (!$request_item) {
                        continue;
                    }

                    $actual_item = FefoIn::where('item_id', $item->id)
                        ->where('storage_id', $request_item->request->storage_id)
                        ->where('serial_number', $request_item->serial_number)
                        ->where('reference', $quotation->number)
                        ->first();

                    if (!$actual_item) {
                        continue;
                    }

                    $item->transaction_number = $request_item->request->number;
                    $item->quantity = $request_item->quantity;
                    $item->unit = $request_item->unit;
                    $item->price = $actual_item->price * $request_item->quantity_in_primary_unit;
                    $item->ref_no = $defectcard->code;
                    $item->used_date = $request_item->request->approvals()->orderBy('id', 'desc')->first()->created_at;
                    $item->category = $item->categories()->select('name')->first();

                    $items[] = $item;
                }
            }
        }

        return $items;
    }
}
