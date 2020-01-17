<?php

namespace memfisfa\Finac\Controllers\Datatables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankAccount;

class BankController extends Controller
{
    public function index(){
        /*
        $currencies = Currency::selectRaw('id, CONCAT(name, " (", symbol ,")") as full_name')->whereIn('code',['idr','usd'])
        ->pluck('full_name', 'id');

        return json_encode($currencies);
        */
        $bank = BankAccount::selectRaw('uuid, CONCAT(name, " (", number ,")") as full')->pluck('uuid','full');
        //dd($bank);

        return json_encode($bank);
    }

    public function detail($bankAccount){
        $bankAccountget = BankAccount::where('uuid',$bankAccount)->first();
        $bankget = Bank::where('id',$bankAccountget->bank_id)->first();
        return json_encode($bankget);
        //$detail = Bank::where('',);
    }
}
