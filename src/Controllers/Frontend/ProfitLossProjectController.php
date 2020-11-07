<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;

class ProfitLossProjectController extends Controller
{
    public function index(Request $request)
    {
        $project = Project::where('uuid', $request->project_uuid)->firstOrFail();

        $pdf = \PDF::loadView('formview::profit-loss-project');
        return $pdf->stream();
    }
}
