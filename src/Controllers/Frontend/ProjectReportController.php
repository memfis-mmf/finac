<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DefectCard;
use App\Models\HtCrr;
use App\Models\JobCard;
use App\Models\Pivots\ProjectWorkpackage;
use App\Models\Project;
use App\Models\Quotation;

class ProjectReportController extends Controller
{
    public function index()
    {
        return view('projectreport-profitlossview::index');
    }

    public function getActualManhour($project)
    {
        $jobcards = [];
        $htcrrs = HtCrr::where('project_id', $project->id)->whereNull('parent_id')->get();

        $additional_projects = $project->childs->pluck('id')->toArray();
        $additional_quotations = Quotation::select('id', 'quotationable_type', 'quotationable_id')->where('quotationable_type', 'App\Models\Project')->whereIn('quotationable_id', $additional_projects)->pluck('id')->toArray();

        $additionals = DefectCard::whereIn('quotation_additional_id', $additional_quotations)->get();

        $tat = ProjectWorkpackage::where('project_id', $project->id)->sum('tat');

        if (isset($project->data_htcrr)) {
            $tat += json_decode($project->data_htcrr)->tat;
        }

        $quotation_ids = Quotation::where('quotationable_id', $project->id)->orWhere('parent_id', $project->id)->has('approvals', '>', 1)->pluck('id')->toArray();

        $jobcard_routine = JobCard::select('id', 'uuid', 'progress', 'jobcardable_type', 'jobcardable_id', 'quotation_id', 'is_rii', 'type', 'is_mandatory', 'origin_jobcardable')
            ->whereIn('quotation_id', $quotation_ids)
            ->where('jobcardable_type', 'App\Models\TaskCard')->with('progresses', 'jobcardable')
            ->get();

        $jobcard_nonrotine = JobCard::select('id', 'uuid', 'progress', 'jobcardable_type', 'jobcardable_id', 'quotation_id', 'is_rii', 'type', 'is_mandatory', 'origin_jobcardable')
            ->whereIn('quotation_id', $quotation_ids)
            ->where('jobcardable_type', 'App\Models\EOInstruction')->with('progresses', 'jobcardable.eo_header.type')
            ->get();

        $jobcards["routine"] = $jobcards["non_routine"] = $jobcards["additionals"]  = 0;

        $result = 0;

        foreach ($jobcard_routine as $jobcard) {
            $result += floatval($jobcard->actual_manhourV2);
        }

        foreach ($jobcard_nonrotine as $jobcard) {
            $result += floatval($jobcard->actual_manhourV2);
        }

        foreach ($additionals as $jobcard) {
            $result += floatval($jobcard->actual_manhourV2);
        }

        foreach ($htcrrs as $jobcard) {
            $result += floatval(array_sum($jobcard->actual_manhour));
        }

        return $result;
    }

    public function view(Request $request)
    {
        $data = app('memfisfa\Finac\Controllers\Frontend\ProfitLossProjectController')
            ->getAllProject($request->project)['data'];

        $total = $data['total_revenue'] + $data['total_expense'];

        $data['total_revenue_percent'] = 0;
        $data['total_expense_percent'] = 0;

        if ($total > 1) {
            $data['total_revenue_percent'] = $data['total_revenue'] * 100 / $total;
            $data['total_expense_percent'] = $data['total_expense'] * 100 / $total;
        }

        $data['request'] = $request->all();

        // manhour=2000&hangar_space=20000&parking_area=10000&other_expense=9000

        $main_project = $data['main_project'];

        if ($request->manhour > 0) {
            $actual_manhour = $this->getActualManhour($main_project);

            $data['expense']['Manhour COGS'] = (object) [
                'name' => "Manhour COGS <br>(".$actual_manhour." * ".number_format($request->manhour, 2, ',', '.').")",
                'value' => $request->manhour * $actual_manhour
            ];

            $data['total_expense'] += $request->manhour;
        }

        if ($request->hangar_space > 0) {
            $data['expense']['Hangar Space COGS'] = (object) [
                'name' => 'Hangar Space COGS',
                'value' => $request->hangar_space
            ];

            $data['total_expense'] += $request->hangar_space;
        }

        if ($request->parking_area > 0) {
            $data['expense']['Parking Area COGS'] = (object) [
                'name' => 'Parking Area COGS',
                'value' => $request->parking_area
            ];

            $data['total_expense'] += $request->parking_area;
        }

        if ($request->other_expense > 0) {
            $data['expense']['Other'] = (object) [
                'name' => 'Other',
                'value' => $request->other_expense
            ];

            $data['total_expense'] += $request->other_expense;
        }

        // build bar chart data
        $bar_chart = [];
        foreach ($data['revenue'] as $revenue_index => $revenue_row) {
            $bar_chart[] = "{\"y\": \"$revenue_index\", \"a\": $revenue_row->value, \"b\": 0}";
        }

        foreach ($data['expense'] as $expense_index => $expense_row) {
            $bar_chart[] = "{\"y\": \"$expense_index\", \"a\": 0, \"b\": $expense_row->value}";
        }

        $data['bar_chart'] = implode('<>', $bar_chart);

        return view('projectreport-profitlossview::view', $data);
    }

    public function viewAdditional(Request $request)
    {
        $data = app('memfisfa\Finac\Controllers\Frontend\ProfitLossProjectController')
            ->getAllProject($request->project)['data'];

        $total = $data['total_revenue'] + $data['total_expense'];

        $data['total_revenue_percent'] = 0;
        $data['total_expense_percent'] = 0;

        if ($total > 1) {
            $data['total_revenue_percent'] = $data['total_revenue'] * 100 / $total;
            $data['total_expense_percent'] = $data['total_expense'] * 100 / $total;
        }

        $data['request'] = $request->all();

        // manhour=2000&hangar_space=20000&parking_area=10000&other_expense=9000

        if ($request->manhour > 0) {
            $data['expense']['Manhour COGS'] = (object) [
                'name' => 'Manhour COGS',
                'value' => $request->manhour
            ];

            $data['total_expense'] += $request->manhour;
        }

        if ($request->hangar_space > 0) {
            $data['expense']['Hangar Space COGS'] = (object) [
                'name' => 'Hangar Space COGS',
                'value' => $request->hangar_space
            ];

            $data['total_expense'] += $request->hangar_space;
        }

        if ($request->parking_area > 0) {
            $data['expense']['Parking Area COGS'] = (object) [
                'name' => 'Parking Area COGS',
                'value' => $request->parking_area
            ];

            $data['total_expense'] += $request->parking_area;
        }

        if ($request->other_expense > 0) {
            $data['expense']['Other'] = (object) [
                'name' => 'Other',
                'value' => $request->other_expense
            ];

            $data['total_expense'] += $request->other_expense;
        }

        // build bar chart data
        $bar_chart = [];
        foreach ($data['revenue'] as $revenue_index => $revenue_row) {
            $bar_chart[] = "{\"y\": \"$revenue_index\", \"a\": $revenue_row->value, \"b\": 0}";
        }

        foreach ($data['expense'] as $expense_index => $expense_row) {
            $bar_chart[] = "{\"y\": \"$expense_index\", \"a\": 0, \"b\": $expense_row->value}";
        }

        $data['bar_chart'] = implode('<>', $bar_chart);

        return view('projectreport-profitlossview::view-additional', $data);
    }

    public function select2Project(Request $request)
    {
        $q = $request->q;

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

        $project = Project::select($selected_column)
            ->where('code', 'like', "%$q%");

        if ($q) {
            $project = $project->whereHas('customer', function($customer) use($q) {
                $customer->where('name', 'like', "%$q%");
            });
        }
        
        $project = $project
            ->without('quotations')
            ->withCount('approvals')
            ->whereIn('status', ['Quotation Approved', 'Project Approved'])
            ->whereNull('parent_id')
            ->limit(50)
            ->get();

        $data['results'] = [];
        
        foreach ($project as $project_row) {
            $data['results'][] = [
                'id' => $project_row->uuid,
                'text' => $project_row->code . " [" . $project_row->customer->name . "]"
            ];
        }

		return $data;
    }
}
