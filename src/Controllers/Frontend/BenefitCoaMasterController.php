<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Benefit;

class BenefitCoaMasterController extends Controller
{
    public function index()
    {
        return view('benefit-coa-master::index');
    }

    public function datatable()
    {
        $benefits = Benefit::query();

        return datatables()->of($benefits)
            ->addColumn('code_show', function(Benefit $benefit){
                return '<a href="/benefit/'.$benefit->uuid.'">' . $benefit->code . '</a>';
            })
            ->addColumn('description_show', function(Benefit $benefit){
                return substr($benefit->description, 0, 120);
            })
            ->escapeColumns([])
            ->make();
    }
}
