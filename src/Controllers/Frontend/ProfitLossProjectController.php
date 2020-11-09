<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use memfisfa\Finac\Model\TrxJournal;

class ProfitLossProjectController extends Controller
{
    public function index(Request $request)
    {
        $project = Project::where('uuid', $request->project_uuid)->firstOrFail();

        // mengambil id project additionalnya
        $project_number = $project->childs->pluck('number')->all();
        
        // menambahkan id project induk ke dalam array
        $project_number[] = $project->id;

        $journal = TrxJournal::where('ref_no', $project_number)->get();

        $pdf = \PDF::loadView('formview::profit-loss-project');
        return $pdf->stream();
    }
}
