<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use memfisfa\Finac\Model\Coa;
use App\Models\GeneralCoaSetting;

class GeneralCoaMasterController extends Controller
{
    public function index()
    {
        return view('general-coa-master::index');
    }

    public function update(Request $request, $uuid_general)
    {
        // check apakah general ada
        GeneralCoaSetting::where('uuid', $uuid_general)->firstOrFail();

        // mengambil coa
        $check_coa = Coa::find($request->id_coa);

        // jika coa tidak ada
        if (!$check_coa) {
            return response([
                'status' => false,
                'message' => 'Coa Not found'
            ], 422);
        }

        GeneralCoaSetting::where('uuid', $uuid_general)
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
