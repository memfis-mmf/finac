<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use memfisfa\Finac\Model\TrxJournal;
use memfisfa\Finac\Model\TrxJournalA;

class ProfitLossProjectController extends Controller
{
    public function index(Request $request)
    {
        $project = Project::where('uuid', $request->project_uuid)->firstOrFail();

        // mengambil id project additionalnya
        $project_number = $project->childs->pluck('number')->all();
        
        // menambahkan id project induk ke dalam array
        $project_number[] = $project->id;

        $journal_number = TrxJournal::select('voucher_no')
            ->where('ref_no', $project_number)
            ->where('approve', true)
            ->pluck('voucher_no')
            ->all();

        // mengambil debit dan credit journal
        $journal_value = TrxJournalA::select('debit', 'credit')
            ->whereHas('coa.type', function($type) {
                $type->where('code', 'biaya')
                    ->orWehere('code', 'pendapatan');
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

        $pdf = \PDF::loadView('formview::profit-loss-project', $data);
        return $pdf->stream();
    }
}
