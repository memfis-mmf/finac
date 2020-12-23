<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\TypeAsset;
use memfisfa\Finac\Request\TypeAssetUpdate;
use memfisfa\Finac\Request\TypeAssetStore;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use DataTables;

class TypeAssetController extends Controller
{
    public function index()
    {
        return view('assetcategoryview::index');
    }

    public function create()
    {
        return view('assetcategoryview::create');
    }

    public function store(TypeAssetStore $request)
    {
        $typeasset = TypeAsset::create($request->all());
        return response()->json($typeasset);
    }

    public function edit(Request $request)
    {
		$data['typeasset'] = TypeAsset::where('uuid', $request->typeasset)->with([
			'coa'
		])->first();

        return view('assetcategoryview::edit', $data);
    }

    public function update(TypeAssetUpdate $request, TypeAsset $typeasset)
    {
        $typeasset->update([
            'usefullife' => $request->usefullife
        ]);

        return response()->json($typeasset);
    }

    public function destroy(TypeAsset $typeasset)
    {
        // $typeasset->delete();

        // return response()->json($typeasset);
    }

    public function api()
    {
        $typeassetdata = TypeAsset::all();

        return json_encode($typeassetdata);
    }

    public function apidetail(TypeAsset $typeasset)
    {
        return response()->json($typeasset);
    }

    public function datatables()
    {
        $data = TypeAsset::with(['coa']);

        return DataTables::of($data)
		->escapeColumns([])
		->make(true);
    }
}
