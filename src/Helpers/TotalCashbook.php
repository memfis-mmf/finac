<?php

namespace Directoryxx\Finac\Helpers;

use Directoryxx\Finac\Model\Cashbook;
use Directoryxx\Finac\Model\CashbookA;
use DB;
use Directoryxx\Finac\Model\CashbookB;
use Directoryxx\Finac\Model\CashbookC;



class TotalCashbook
{
    
    public static function calculate($transactionnumber) {
        $cashbook = Cashbook::where('transactionnumber', $transactionnumber)->first();
        $excrate = $cashbook->exchangerate;
        
        $cashbooka = CashbookA::where('transactionnumber',$transactionnumber)->get();
        $adj1 = 0;
        foreach($cashbooka as $ca){
            $temp = ($ca->debit-$ca->credit)*$excrate;
            $adj1 += $temp;
        }


        $cashbookb = CashbookB::where('transactionnumber',$transactionnumber)->get();
        $adj2 = 0;
        foreach($cashbookb as $cb){
            $temp = ($cb->debit-$cb->credit)*$excrate;
            $adj2 += $temp;
        }

        $cashbookc = CashbookC::where('transactionnumber',$transactionnumber)->get();
        $adj3 = 0;
        foreach($cashbookc as $cc){
            $temp = ($cc->debit-$cc->credit)*$excrate;
            $adj3 += $temp;
        }

        $final = abs($adj1+$adj2);
        DB::table('cashbooks')
            ->where('transactionnumber', $transactionnumber)
            ->update(['totaltransaction' => $final]);
        
        return true;
        //echo $adj1;
        
    }
}
