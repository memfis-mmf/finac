<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BPJS;
use App\User;
use memfisfa\Finac\Model\Coa;

class BPJSCoaMasterController extends Controller
{
    public function index()
    {
        return view('benefit-coa-master::index');
    }

    public function datatables()
    {
        $bpjss = BPJS::query();

        return datatables()->of($bpjss)
            ->addColumn('coa', function($row) {
                $coa = Coa::find($row->coa_id);

                if (!$coa) {
                    $val = '';
                    $result = '-';
                } else {                        
                    $val = $coa->id;
                    $result = $coa->name." ($coa->code)";
                }

                $html = 
                    '<select class="form-control select2" style="width:400px">
                        <option selected value="'.$val.'">'.$result.'</option>
                    </select>';

                return $html;
            })
            ->addColumn('code_show', function(BPJS $bpjs){
                return '<a href="/benefit/'.$bpjs->uuid.'">' . $bpjs->code . '</a>';
            })
            ->addColumn('description_show', function(BPJS $bpjs){
                return substr($bpjs->name, 0, 120);
            })
            ->addColumn('approved_by', function(BPJS $bpjs){
                $audit = $bpjs->audits;

                $result = '-';

                if (count($audit) > 1) {
                    $result =  @User::find($audit[count($audit)-1]->user_id)->name
                    .' '.$bpjs->created_at;
                }

                return $result;
            })
            ->addColumn('action', function($row) {
                    $html = 
                    '<button 
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill update-coa-bpjs" 
                        title="Save" data-uuid="'.$row->uuid.'"> 
                        <i class="la la-check"></i> 
                    </button>';

                    return $html;
                })
            ->escapeColumns([])
            ->make();
    }

    public function update(Request $request, $uuid_benefit)
    {
        // check apakah benefit ada
        BPJS::where('uuid', $uuid_benefit)->firstOrFail();

        // mengambil coa
        $check_coa = Coa::find($request->id_coa);

        // jika coa tidak ada
        if (!$check_coa) {
            return response([
                'status' => false,
                'message' => 'Coa Not found'
            ], 422);
        }

        BPJS::where('uuid', $uuid_benefit)
            ->first()
            ->update([
                'coa_id' => $request->id_coa
            ]);

        return response([
            'status' => true,
            'message' => 'Coa updated'
        ]);
    }

    public function select2Coa(Request $request)
    {
        $coa = Coa::where('description', 'Detail')
            ->where(function($coa_query) use ($request) {
                $coa_query->where('code', 'like', "%$request->q%")
                    ->orWhere('name', 'like', "%$request->q%");
            })
            ->limit(50)
            ->get();

        $data['results'] = [];
        foreach ($coa as $coa_row) {
            $data['results'][] = [
                'id' => $coa_row->id,
                'text' => $coa_row->name . " ($coa_row->code)",
            ];
        }

        return $data;
    }
}
