<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FixedAssetDispositionController extends Controller
{
    public function index()
    {
        return view('fixassetdispositionview::index');
    }

    public function datatable()
    {
    }

    public function create()
    {
        return view('fixassetdispositionview::create');
    }

    public function store(Request $request)
    {
        # code...
    }


    public function show(Request $request)
    {
        return view('fixassetdispositionview::show');
    }

    public function edit($uuid)
    {
        return view('fixassetdispositionview::edit');
    }

    public function update(Request $request)
    {
        # code...
    }

    public function destroy($uuid)
    {
        # code...
    }
}