<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Benefit;
use memfisfa\Finac\Model\Coa;

class BenefitCoaMasterController extends Controller
{
    public function index()
    {
        return view('benefit-coa-master::index');
    }

    public function datatables()
    {
        $benefits = Benefit::query();

        return datatables()->of($benefits)
            ->addColumn('coa', function($row) {
                $coa = Coa::find($row->coa_id);

                if (!$coa) {
                    return '-';
                }

                return $coa->name." ($coa->code)";
            })
            ->addColumn('code_show', function(Benefit $benefit){
                return '<a href="/benefit/'.$benefit->uuid.'">' . $benefit->code . '</a>';
            })
            ->addColumn('description_show', function(Benefit $benefit){
                return substr($benefit->description, 0, 120);
            })
            ->addColumn('action', function($row) {
                    $html = 
                    '<button 
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill edit" 
                        title="Edit" data-uuid="'.$row->uuid.'"> 
                        <i class="la la-pencil"></i> 
                    </button>';

                    return $html;
                })
            ->escapeColumns([])
            ->make();
    }

    public function select2Coa()
    {
        $coa = Coa::where('description', 'Detail')
            ->limit(50)
            ->get();

        $data['results'] = [];
        foreach ($coa as $coa_row) {
            $data['results'][] = [
                'id' => $coa_row->id,
                'text' => $coa_row->name,
            ];
        }
    }
}
