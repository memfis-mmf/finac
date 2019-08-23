<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Directoryxx\Finac\Helpers\CashbookGenerateNumber;
use App\Http\Controllers\Controller;
use Directoryxx\Finac\Model\Cashbook;
use Directoryxx\Finac\Model\CashbookA;
use Directoryxx\Finac\Model\CashbookB;
use Directoryxx\Finac\Model\CashbookC;
use Illuminate\Support\Facades\Auth;

class CashbookBPJController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('cashbook-bpj.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cashbookCount = Cashbook::count();
        $cashbookno = CashbookGenerateNumber::generate('BPJ-MMF/', $cashbookCount+1);
        return view('cashbookview::bpj')->with('cashbookno',$cashbookno);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        
        $data = $request->data;
        //dd(Auth::user()->id);
        //dd($data['adj3']['adj3']);
        //dd();
        Cashbook::create([
            'transactionnumber' => $data['header']['header'][0],
            'transactiondate' => $data['header']['header'][1],
            'xstatus' => "payment",
            'personal' => $data['header']['header'][2],
            'refno' => $data['header']['header'][3],
            'currency' => $data['header']['header'][4],
            'exchangerate' => $data['header']['header'][5],
            'accountcode' => $data['header']['header'][6],
            'createdby' => Auth::user()->id,
            'description' => $data['header']['header'][7],
        ]);
        for ($i = 0; $i <= 9; $i++){
            if ($data['adj1']['adj1'][$i][0] != null){
                CashbookA::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj1']['adj1'][$i][1],
                    'code' => $data['adj1']['adj1'][$i][0],
                    'debit' => str_replace(',','',$data['adj1']['adj1'][$i][2]),
                    'credit' => 0,
                    'description' => $data['adj1']['adj1'][$i][4],
                    
                ]);
            }

        }

        for ($i = 0; $i <= 9; $i++){
            if ($data['adj2']['adj2'][$i][0] != null){
                CashbookB::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj2']['adj2'][$i][1],
                    'currency' => $data['adj2']['adj2'][$i][2],
                    'exchangerate' => $data['adj2']['adj2'][$i][3],
                    'code' => $data['adj2']['adj2'][$i][0],
                    'debit' => str_replace(',','',$data['adj2']['adj2'][$i][4]),
                    'credit' => str_replace(',','',$data['adj2']['adj2'][$i][5]),
                    'description' => $data['adj2']['adj2'][$i][6],
                    'createdby' => Auth::user()->id,
                ]);
            }

        }

        for ($i = 0; $i <= 9; $i++){
            if ($data['adj3']['adj3'][$i][0] != null){
                CashbookC::create([
                    'transactionnumber' => $data['header']['header'][0],
                    'name' => $data['adj3']['adj3'][$i][1],
                    'code' => $data['adj3']['adj3'][$i][0],
                    'debit' => str_replace(',','',$data['adj3']['adj3'][$i][2]),
                    'credit' => str_replace(',','',$data['adj3']['adj3'][$i][3]),
                    'description' => $data['adj3']['adj3'][$i][4],
                    'createdby' => Auth::user()->id,
                ]);
            }

        }

        dd($data['header']['header']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
