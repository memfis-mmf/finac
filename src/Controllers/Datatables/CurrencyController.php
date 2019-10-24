<?php

namespace Directoryxx\Finac\Controllers\Datatables;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    public function index(){
        $currencies = Currency::selectRaw('code, CONCAT(name, " (", symbol ,")") as full_name')->whereIn('code',['idr','usd'])
        ->pluck('full_name', 'code');

        return json_encode($currencies);
    }
}
