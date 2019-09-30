<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Directoryxx\Finac\Model\ARecieve;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Directoryxx\Finac\Helpers\CashbookGenerateNumber;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use Directoryxx\Finac\Model\Coa;

class ARController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('arview::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arview::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Customer::where('name',$request->customer)->first();
        $accountcode = Coa::where('name', $request->coa)->first();
        $arsuggest = 'AR-MMF/' . Carbon::now()->format('Y/m');
        $currency_substring = substr($request->currency, 0, strpos($request->currency, ' ('));
        $currency = Currency::where('name',$currency_substring)->first();
        $arcount = ARecieve::where('transactionnumber', 'like', $arsuggest . '%')->withTrashed()->count();
        $arno = CashbookGenerateNumber::generate('AR-MMF/', $arcount + 1);
        $ar = ARecieve::create([
            'id_branch' => 1,
            'approve' => 0,
            'transactionnumber' => $arno,
            'transactiondate' => $request->date,
            'id_customer' => $customer->id,
            'accountcode' => $accountcode->id,
            'refno' => $request->refno,
            'currency' => $currency->id,
            'exchangerate' => $request->exchangerate,
            'totaltransaction' => 0,
            'description' => $request->description
        ]);

        return response()->json($ar); 
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
    public function edit(ARecieve $arecieve)
    {
        dd($arecieve);
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


    public function datatables()
    {
        # code...
    }

    public function cust_detail(Customer $customer){
        $cust_detail = $customer->journal;
        return response()->json($cust_detail);
    }
}
