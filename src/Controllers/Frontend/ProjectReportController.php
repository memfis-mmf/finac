<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectReportController extends Controller
{
    public function index()
    {
        return view('projectreport-profitlossview::index');
    }

    public function view(Request $request)
    {
        $data = [
            'project' => Project::where('uuid', $request->project)->firstOrFail()
        ];

        return view('projectreport-profitlossview::view', $data);
    }

    public function select2Project(Request $request)
    {
        $q = $request->q;

        $project = Project::has('approvals')
            ->where('parent_id', NULL)
            ->where('code', 'like', "%$q%")
            ->limit(50)
            ->get();

        $data['results'] = [];
        
        foreach ($project as $project_row) {
            $data['results'][] = [
                'id' => $project_row->uuid,
                'text' => $project_row->code
            ];
        }

		return $data;
    }
}
