<?php

namespace Memfis\Financeaccounting\Controllers;

use Illuminate\Http\Request;
use Memfis\Financeaccounting\Model\Coa;
use App\Http\Controllers\Controller;



class CoaController extends Controller
{
    public function index()
    {
        return redirect()->route('coa.create');
    }

    public function getData(){
        echo "{
            \"iTotalRecords\": 350,
            \"iTotalDisplayRecords\": 350,
            \"sEcho\": 0,
            \"sColumns\": \"\",
            \"aaData\": [
                {
                    \"RecordID\": 1,
                    \"OrderID\": \"61715-075\",
                    \"Country\": \"China\",
                    \"ShipCity\": \"Tieba\",
                    \"ShipAddress\": \"746 Pine View Junction\",
                    \"CompanyAgent\": \"Nixie Sailor\",
                    \"CompanyName\": \"Gleichner, Ziemann and Gutkowski\",
                    \"ShipDate\": \"2\/12\/2018\",
                    \"Status\": 3,
                    \"Type\": 2,
                    \"Actions\": null
                },
                
            ]
        }";
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
