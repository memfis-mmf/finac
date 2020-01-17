<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Helpers\CashbookGenerateNumber;
use App\Http\Controllers\Controller;
use memfisfa\Finac\Helpers\TotalCashbook;
use memfisfa\Finac\Model\Cashbook;
use memfisfa\Finac\Model\CashbookA;
use memfisfa\Finac\Model\CashbookB;
use memfisfa\Finac\Model\CashbookC;
use memfisfa\Finac\Model\Coa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CashbookBRJController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('cashbook-brj.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bpjsuggest = 'CBRJ-MMF/'.Carbon::now()->format('Y/m');
        $cashbookCount = Cashbook::where('transactionnumber', 'like', $bpjsuggest.'%')->withTrashed()->count();
        $cashbookno = CashbookGenerateNumber::generate('CBRJ-MMF/', $cashbookCount + 1);
        return view('cashbookview::brj')->with('cashbookno', $cashbookno);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->data;
        
        Cashbook::create([
            'transactionnumber' => $data['header']['header'][0],
            'transactiondate' => $data['header']['header'][1],
            'xstatus' => "receive",
            'personal' => $data['header']['header'][2],
            'refno' => $data['header']['header'][3],
            'currency' => $data['header']['header'][4],
            'exchangerate' => $data['header']['header'][5],
            'accountcode' => $data['header']['header'][6],
            'createdby' => Auth::user()->id,
            'description' => $data['header']['header'][7],
        ]);
        for ($i = 0; $i <= 9; $i++) {
            if ($data['adj1']['adj1'][$i][0] != null) {
                $firststep = str_replace(',', '', $data['adj1']['adj1'][$i][3]);
                $twostep = str_replace('.', '', $firststep);
                $str2 = substr($twostep, 4);
                CashbookA::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj1']['adj1'][$i][1],
                    'code' => $data['adj1']['adj1'][$i][0],
                    'debit' => 0,
                    'credit' => $str2,
                    'description' => $data['adj1']['adj1'][$i][4],

                ]);
            }
        }

        for ($i = 0; $i <= 9; $i++) {
            if ($data['adj2']['adj2'][$i][0] != null) {
                $firststep = str_replace(',', '', $data['adj2']['adj2'][$i][4]);
                $twostep = str_replace('.', '', $firststep);
                $str2 = substr($twostep, 4);
                $firststep2 = str_replace(',', '', $data['adj2']['adj2'][$i][5]);
                $twostep2 = str_replace('.', '', $firststep2);
                $str22 = substr($twostep2, 4);
                CashbookB::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj2']['adj2'][$i][1],
                    'currency' => $data['adj2']['adj2'][$i][2],
                    'exchangerate' => $data['adj2']['adj2'][$i][3],
                    'code' => $data['adj2']['adj2'][$i][0],
                    'debit' => $str2,
                    'credit' => $str22,
                    'description' => $data['adj2']['adj2'][$i][6],
                ]);
            }
        }

        for ($i = 0; $i <= 9; $i++) {
            if ($data['adj3']['adj3'][$i][0] != null) {
                $firststep = str_replace(',', '', $data['adj3']['adj3'][$i][2]);
                $twostep = str_replace('.', '', $firststep);
                $str2 = substr($twostep, 4);
                $firststep2 = str_replace(',', '', $data['adj3']['adj3'][$i][3]);
                $twostep2 = str_replace('.', '', $firststep2);
                $str22 = substr($twostep2, 4);
                CashbookC::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj3']['adj3'][$i][1],
                    'code' => $data['adj3']['adj3'][$i][0],
                    'debit' => $str2,
                    'credit' => $str22,
                    'description' => $data['adj3']['adj3'][$i][4],
                ]);
            }
        }
        TotalCashbook::calculate($data['header']['header'][0]);
        
        dd($data['header']['header']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cashbook $cashbook)
    {
        $header = $cashbook;
        $transnumber = $cashbook->transactionnumber;
        $cashbooka = CashbookA::where('transactionnumber',$transnumber)->get();
        $cashbookb = CashbookB::where('transactionnumber',$transnumber)->get();
        $cashbookc = CashbookC::where('transactionnumber',$transnumber)->get();
        $coa_detail = Coa::where('code',$cashbook->accountcode)->first();
        return view('cashbookview::brjshow')
        ->with('cashbookno',$transnumber)
        ->with('coa_detail',$coa_detail)
        ->with('transactiondate',$cashbook->transactiondate)
        ->with('paymentno',$cashbook->personal)
        ->with('refno',$cashbook->refno)
        ->with('currency',$cashbook->currency)
        ->with('coa',$cashbook->accountcode)
        ->with('description',$cashbook->description)
        ->with('uuid',$cashbook->uuid)
        ->with('exchange',$cashbook->exchangerate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cashbook $cashbook)
    {
        $header = $cashbook;
        $transnumber = $cashbook->transactionnumber;
        $cashbooka = CashbookA::where('transactionnumber',$transnumber)->get();
        $cashbookb = CashbookB::where('transactionnumber',$transnumber)->get();
        $cashbookc = CashbookC::where('transactionnumber',$transnumber)->get();
        $coa_detail = Coa::where('code',$cashbook->accountcode)->first();
        return view('cashbookview::brjedit')
        ->with('cashbookno',$transnumber)
        ->with('transactiondate',$cashbook->transactiondate)
        ->with('coa_detail',$coa_detail)
        ->with('paymentno',$cashbook->personal)
        ->with('refno',$cashbook->refno)
        ->with('currency',$cashbook->currency)
        ->with('coa',$cashbook->accountcode)
        ->with('description',$cashbook->description)
        ->with('uuid',$cashbook->uuid)
        ->with('exchange',$cashbook->exchangerate);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cashbook $cashbook)
    {
        $transnumber = $cashbook->transactionnumber;
        $cashbooka = CashbookA::where('transactionnumber',$transnumber)->delete();
        $cashbookb = CashbookB::where('transactionnumber',$transnumber)->delete();
        $cashbookc = CashbookC::where('transactionnumber',$transnumber)->delete();
        $data = $request->data;
        for ($i = 0; $i <= 9; $i++) {
            if ($data['adj1']['adj1'][$i][0] != null) {
                CashbookA::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj1']['adj1'][$i][1],
                    'code' => $data['adj1']['adj1'][$i][0],
                    'debit' => 0,
                    'credit' => str_replace(',', '', $data['adj1']['adj1'][$i][3]),
                    'description' => $data['adj1']['adj1'][$i][4],

                ]);
            }
        }

        for ($i = 0; $i <= 9; $i++) {
            if ($data['adj2']['adj2'][$i][0] != null) {
                CashbookB::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj2']['adj2'][$i][1],
                    'currency' => $data['adj2']['adj2'][$i][2],
                    'exchangerate' => $data['adj2']['adj2'][$i][3],
                    'code' => $data['adj2']['adj2'][$i][0],
                    'debit' => str_replace(',', '', $data['adj2']['adj2'][$i][4]),
                    'credit' => str_replace(',', '', $data['adj2']['adj2'][$i][5]),
                    'description' => $data['adj2']['adj2'][$i][6],
                ]);
            }
        }

        for ($i = 0; $i <= 9; $i++) {
            if ($data['adj3']['adj3'][$i][0] != null) {
                CashbookC::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj3']['adj3'][$i][1],
                    'code' => $data['adj3']['adj3'][$i][0],
                    'debit' => str_replace(',', '', $data['adj3']['adj3'][$i][2]),
                    'credit' => str_replace(',', '', $data['adj3']['adj3'][$i][3]),
                    'description' => $data['adj3']['adj3'][$i][4],
                ]);
            }
        }

        Cashbook::where('transactionnumber', $transnumber)
        ->update([
            'updateddate' => Carbon::now()->format('Y-m-d'),
            'updatedby'=> Auth::user()->id,
            'transactiondate' => $data['header']['header'][1],
            'personal' => $data['header']['header'][2],
            'refno' => $data['header']['header'][3],
            'currency' => $data['header']['header'][4],
            'exchangerate' => $data['header']['header'][5],
            'accountcode' => $data['header']['header'][6],
            'description' => $data['header']['header'][7],
        ]);

        TotalCashbook::calculate($data['header']['header'][0]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail(Request $request){
        
        $cashbooka = CashbookA::where('transactionnumber',$request->data)->get();
        $cashbookb = CashbookB::where('transactionnumber',$request->data)->get();
        $cashbookc = CashbookC::where('transactionnumber',$request->data)->get();
        $myObj = new \stdClass();
        $myObj->casha = $cashbooka;
        $myObj->cashb = $cashbookb;
        $myObj->cashc = $cashbookc;
        
        return response()->json($myObj);

    }
}
