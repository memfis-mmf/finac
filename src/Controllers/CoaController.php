<?php

namespace Directoryxx\Finac\Controllers;

use Illuminate\Http\Request;
use Directoryxx\Finac\Model\Coa;
use App\Http\Controllers\Controller;



class CoaController extends Controller
{
    public function index()
    {
        return redirect()->route('coa.create');
    }

    public function getData(){
        $type = [
            '1' => 'AKTIVA',
            '2' => 'PASIVA',
            '3' => 'EKUITAS',
            '4' => 'PENDAPATAN',
            '5' => 'BIAYA'
        ];

        return json_encode($type,JSON_PRETTY_PRINT);







    }

    public function create()
    {
        $coa = Coa::all();
        //$submit = 'Add';
        return view('coaview::index');
    }

    public function store()
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update($id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
