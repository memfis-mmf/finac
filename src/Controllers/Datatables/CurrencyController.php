<?php

namespace memfisfa\Finac\Controllers\Datatables;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function index(){
        $currencies = Currency::whereIn('code',['idr','usd'])
            ->get();

        foreach ($currencies as $currencies_row) {
            $data[$currencies_row->code] = $currencies_row->full_name;
        }

        return json_encode($data);
    }
}
