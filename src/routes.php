<?php

require('view-only.php');
require('print.php');

Route::get('test', function(){
	echo 'Hello from the Finance Accounting Package!';
});

Route::get('token', function(){
	return ['token' => csrf_token()];
})->middleware('web');

Route::group(['middleware' => ['web','auth']], function () {

    Route::prefix('coa')->group(function () {
		Route::get('/', 'memfisfa\Finac\Controllers\Frontend\CoaController@create')->name('coa.index');
		Route::get('/export', 'memfisfa\Finac\Controllers\Frontend\CoaController@export')->name('coa.export');
		Route::get('/type','memfisfa\Finac\Controllers\Frontend\CoaController@getdata');
		Route::post('/','memfisfa\Finac\Controllers\Frontend\CoaController@store')->name('coa.store');
		Route::put('/{coa}','memfisfa\Finac\Controllers\Frontend\CoaController@update')->name('coa.update');
		Route::delete('/{coa}','memfisfa\Finac\Controllers\Frontend\CoaController@destroy')->name('coa.delete');
		Route::get('/datatables','memfisfa\Finac\Controllers\Frontend\CoaController@datatables')->name('coa.datatables');
		Route::get('/{coa}/edit','memfisfa\Finac\Controllers\Frontend\CoaController@edit');
		Route::get('/type/{id}','memfisfa\Finac\Controllers\Frontend\CoaController@gettype');
		Route::get('/data','memfisfa\Finac\Controllers\Frontend\CoaController@api');
		Route::get('/data/{coa}','memfisfa\Finac\Controllers\Frontend\CoaController@apidetail');
		Route::get('/datatables/modal','memfisfa\Finac\Controllers\Frontend\CoaController@basicModal');
	});

    Route::prefix('cashbook')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@index'
		)->name('cashbook.index');
		Route::get(
			'/create',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@create'
		)->name('cashbook.create');
		Route::get(
			'/export',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@export'
		)->name('cashbook.export');
		Route::get(
			'/type',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@getdata'
		);
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@store'
		)->name('cashbook.store');
		Route::put(
			'/{cashbook}',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@update'
		)->name('cashbook.update');
		Route::delete(
			'/{cashbook}',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@destroy'
		)->name('cashbook.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@datatables'
		)->name('cashbook.datatables');
		Route::get(
			'/{cashbook}/edit',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@edit'
		);
		Route::get(
			'/type/{id}',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@gettype'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@api'
		);
		Route::get(
			'/data/{cashbook}',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@apidetail'
		);
		Route::get(
			'/datatables/modal',
			'memfisfa\Finac\Controllers\Frontend\CashbookController@basicModal'
		);
	});

    Route::prefix('journal')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\JournalController@create'
		)->name('journal.index');
		Route::get(
			'/get-account-code-select2',
			'memfisfa\Finac\Controllers\Frontend\JournalController@getAccountCodeSelect2'
		)->name('journal.get-account-code-select2');
		Route::post(
			'/approve',
			'memfisfa\Finac\Controllers\Frontend\JournalController@approve'
		);
		Route::get(
			'/type',
			'memfisfa\Finac\Controllers\Frontend\JournalController@getType'
		);
		Route::get(
			'/type-json',
			'memfisfa\Finac\Controllers\Frontend\JournalController@getTypeJson'
		);
		Route::get(
			'/currency',
			'memfisfa\Finac\Controllers\Frontend\JournalController@getCurrency'
		);
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\JournalController@store'
		)->name('journal.store');
		Route::post(
			'/journala',
			'memfisfa\Finac\Controllers\Frontend\JournalController@journalaStore'
		)->name('journal.coaStore');
		Route::put(
			'/{journal}',
			'memfisfa\Finac\Controllers\Frontend\JournalController@update'
		)->name('journal.update');
		Route::delete(
			'/{journal}',
			'memfisfa\Finac\Controllers\Frontend\JournalController@destroy'
		)->name('journal.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\JournalController@datatables'
		)->name('journal.datatables');
		Route::get(
			'/{journal}/edit',
			'memfisfa\Finac\Controllers\Frontend\JournalController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\JournalController@api'
		);
		Route::get(
			'/data/{journal}',
			'memfisfa\Finac\Controllers\Frontend\JournalController@apidetail'
		);
		Route::get(
			'/print',
			'memfisfa\Finac\Controllers\Frontend\JournalController@print'
		);
	});

    Route::prefix('bond')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxBSController@create'
		)->name('bs.index');
		Route::post(
			'/approve',
			'memfisfa\Finac\Controllers\Frontend\TrxBSController@approve'
		);
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxBSController@store'
		)->name('bs.store');
		Route::put(
			'/{bs}',
			'memfisfa\Finac\Controllers\Frontend\TrxBSController@update'
		)->name('bs.update');
		Route::delete(
			'/{bs}',
			'memfisfa\Finac\Controllers\Frontend\TrxBSController@destroy'
		)->name('bs.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrxBSController@datatables'
		)->name('bs.datatables');
		Route::get(
			'/{bs}/edit',
			'memfisfa\Finac\Controllers\Frontend\TrxBSController@edit'
		);
		Route::get(
			'/print',
			'memfisfa\Finac\Controllers\Frontend\TrxBSController@print'
		);
	});

    Route::prefix('bsr')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxBSRController@create'
		)->name('bsr.index');
		Route::post(
			'/approve',
			'memfisfa\Finac\Controllers\Frontend\TrxBSRController@approve'
		);
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxBSRController@store'
		)->name('bsr.store');
		Route::put(
			'/{bsr}',
			'memfisfa\Finac\Controllers\Frontend\TrxBSRController@update'
		)->name('bsr.update');
		Route::delete(
			'/{bsr}',
			'memfisfa\Finac\Controllers\Frontend\TrxBSRController@destroy'
		)->name('bsr.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrxBSRController@datatables'
		)->name('bsr.datatables');
		Route::get(
			'/{bsr}/edit',
			'memfisfa\Finac\Controllers\Frontend\TrxBSRController@edit'
		);
		Route::get(
			'/print',
			'memfisfa\Finac\Controllers\Frontend\TrxBSRController@print'
		);
	});

    Route::prefix('trial-balance')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrialBalanceController@index'
		)->name('trialbalance.index');
		Route::get(
			'/print',
			'memfisfa\Finac\Controllers\Frontend\TrialBalanceController@print'
		)->name('trialbalance.print');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrialBalanceController@datatables'
		)->name('trialbalance.datatables');
	});

    Route::prefix('balance-sheet')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\BalanceSheetController@index'
		)->name('balancesheet.index');
		Route::get(
			'/print',
			'memfisfa\Finac\Controllers\Frontend\BalanceSheetController@print'
		)->name('balancesheet.print');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\BalanceSheetController@datatables'
		)->name('balancesheet.datatables');
	});

    Route::prefix('profit-loss')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\ProfitLossController@index'
		)->name('profitloss.index');
		Route::get(
			'/view-pl',
			'memfisfa\Finac\Controllers\Frontend\ProfitLossController@viewPL'
		)->name('profitloss.view.pl');
		Route::get(
			'/detail-pl',
			'memfisfa\Finac\Controllers\Frontend\ProfitLossController@detailPL'
		)->name('profitloss.detail.pl');
		Route::get(
			'/print-view-pl',
			'memfisfa\Finac\Controllers\Frontend\ProfitLossController@printViewPL'
		)->name('profitloss.print');
		Route::get(
			'/print-detail-pl',
			'memfisfa\Finac\Controllers\Frontend\ProfitLossController@printDetailPL'
		)->name('profitloss.print');
	});

    Route::prefix('general-ledger')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\GeneralLedgerController@index'
		)->name('profitloss.index');
	});

    Route::prefix('journala')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\JournalAController@create'
		)->name('journala.index');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\JournalAController@store'
		)->name('journala.store');
		Route::put(
			'/{journala}',
			'memfisfa\Finac\Controllers\Frontend\JournalAController@update'
		)->name('journala.update');
		Route::delete(
			'/{journala}',
			'memfisfa\Finac\Controllers\Frontend\JournalAController@destroy'
		)->name('journala.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\JournalAController@datatables'
		)->name('journala.datatables');
		Route::get(
			'/{journala}/edit',
			'memfisfa\Finac\Controllers\Frontend\JournalAController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\JournalAController@api'
		);
		Route::get(
			'/data/{journala}',
			'memfisfa\Finac\Controllers\Frontend\JournalAController@apidetail'
		);
	});

    Route::prefix('supplier-invoice')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@index'
		)->name('trxpayment.index');
		Route::post(
			'/approve',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@approve'
		);
		Route::get(
			'/create',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@create'
		)->name('trxpayment.create');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@store'
		)->name('trxpayment.store');
		Route::put(
			'/{trxpayment}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@update'
		)->name('trxpayment.update');
		Route::delete(
			'/{trxpayment}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@destroy'
		)->name('trxpayment.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@datatables'
		)->name('trxpayment.datatables');
		Route::get(
			'/{trxpayment}/edit',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@api'
		);
		Route::get(
			'/data/{trxpayment}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@apidetail'
		);
		Route::post(
			'/coa/use',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@coaUse'
		)->name('trxpayment.grn.use');
		Route::get(
			'/coa/items/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@coaDatatables'
		)->name('trxpayment.grn.datatables');

		//GRN
		Route::post(
			'/grn/approve',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@grnApprove'
		);
		Route::get(
			'/grn/create',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@grnCreate'
		)->name('trxpayment.grn.create');
		Route::put(
			'/grn/{trxpayment}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@grnUpdate'
		)->name('trxpayment.grn.update');
		Route::post(
			'/grn/create',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@grnStore'
		)->name('trxpayment.grn.store');
		Route::post(
			'/grn/use',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@grnUse'
		)->name('trxpayment.grn.use');
		Route::get(
			'/grn/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@grnDatatables'
		)->name('trxpayment.grn.datatables');
		Route::get(
			'/grn/items/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@grnItemsDatatables'
		)->name('trxpayment.grn.datatables');
		Route::get(
			'/grn/{trxpayment}/edit',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@grnEdit'
		);
		Route::get(
			'/get-vendors',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentController@getVendor'
		)->name('trxpayment.vendor.get');
	});

    Route::prefix('trxpaymenta')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentAController@create'
		)->name('trxpaymenta.index');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentAController@store'
		)->name('trxpaymenta.store');
		Route::put(
			'/{trxpaymenta}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentAController@update'
		)->name('trxpaymenta.update');
		Route::delete(
			'/{trxpaymenta}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentAController@destroy'
		)->name('trxpaymenta.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentAController@datatables'
		)->name('trxpaymenta.datatables');
		Route::get(
			'/{trxpaymenta}/edit',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentAController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentAController@api'
		);
		Route::get(
			'/data/{trxpaymenta}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentAController@apidetail'
		);
	});

    Route::prefix('trxpaymentb')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentBController@create'
		)->name('trxpaymentb.index');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentBController@store'
		)->name('trxpaymentb.store');
		Route::put(
			'/{trxpaymentb}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentBController@update'
		)->name('trxpaymentb.update');
		Route::delete(
			'/{trxpaymentb}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentBController@destroy'
		)->name('trxpaymentb.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentBController@datatables'
		)->name('trxpaymentb.datatables');
		Route::get(
			'/{trxpaymentb}/edit',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentBController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentBController@api'
		);
		Route::get(
			'/data/{trxpaymentb}',
			'memfisfa\Finac\Controllers\Frontend\TrxPaymentBController@apidetail'
		);
	});

    Route::prefix('account-payable')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\APController@create'
		)->name('apayment.index');
		Route::get(
			'/print',
			'memfisfa\Finac\Controllers\Frontend\APController@print'
		)->name('apayment.print');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\APController@store'
		)->name('apayment.store');
		Route::put(
			'/{apayment}',
			'memfisfa\Finac\Controllers\Frontend\APController@update'
		)->name('apayment.update');
		Route::delete(
			'/{apayment}',
			'memfisfa\Finac\Controllers\Frontend\APController@destroy'
		)->name('apayment.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\APController@datatables'
		)->name('apayment.datatables');
		Route::get(
			'/coa/datatables',
			'memfisfa\Finac\Controllers\Frontend\APController@coaDatatables'
		)->name('apayment.datatables');
		Route::get(
			'/{apayment}/edit',
			'memfisfa\Finac\Controllers\Frontend\APController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\APController@api'
		);
		Route::get(
			'/data/{apayment}',
			'memfisfa\Finac\Controllers\Frontend\APController@apidetail'
		);
		Route::get(
			'/si/modal/datatable',
			'memfisfa\Finac\Controllers\Frontend\APController@SIModalDatatables'
		)->name('apayment.datatables');
		Route::post(
			'/approve',
			'memfisfa\Finac\Controllers\Frontend\APController@approve'
		);
	});

    Route::prefix('account-receivable')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\ARController@index'
		)->name('areceive.index');
		Route::get(
			'/create',
			'memfisfa\Finac\Controllers\Frontend\ARController@create'
		)->name('areceive.create');
		Route::get(
			'/print',
			'memfisfa\Finac\Controllers\Frontend\ARController@print'
		)->name('areceive.print');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\ARController@store'
		)->name('areceive.store');
		Route::put(
			'/{areceive}',
			'memfisfa\Finac\Controllers\Frontend\ARController@update'
		)->name('areceive.update');
		Route::delete(
			'/{areceive}',
			'memfisfa\Finac\Controllers\Frontend\ARController@destroy'
		)->name('areceive.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\ARController@datatables'
		)->name('areceive.datatables');
		Route::get(
			'/coa/datatables',
			'memfisfa\Finac\Controllers\Frontend\ARController@coaDatatables'
		)->name('areceive.datatables');
		Route::get(
			'/{areceive}/edit',
			'memfisfa\Finac\Controllers\Frontend\ARController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\ARController@api'
		);
		Route::get(
			'/data/{areceive}',
			'memfisfa\Finac\Controllers\Frontend\ARController@apidetail'
		);
		Route::get(
			'/invoice/modal/datatable',
			'memfisfa\Finac\Controllers\Frontend\ARController@InvoiceModalDatatables'
		)->name('areceive.datatables');
		Route::post(
			'/approve',
			'memfisfa\Finac\Controllers\Frontend\ARController@approve'
		);
	});

    Route::prefix('areceivea')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\ARAController@create'
		)->name('areceivea.index');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\ARAController@store'
		)->name('areceivea.store');
		Route::put(
			'/{areceivea}',
			'memfisfa\Finac\Controllers\Frontend\ARAController@update'
		)->name('areceivea.update');
		Route::delete(
			'/{areceivea}',
			'memfisfa\Finac\Controllers\Frontend\ARAController@destroy'
		)->name('areceivea.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\ARAController@datatables'
		)->name('areceivea.datatables');
		Route::get(
			'/{areceivea}/edit',
			'memfisfa\Finac\Controllers\Frontend\ARAController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\ARAController@api'
		);
		Route::get(
			'/data/{areceivea}',
			'memfisfa\Finac\Controllers\Frontend\ARAController@apidetail'
		);
	});

    Route::prefix('areceiveb')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\ARBController@create'
		)->name('areceiveb.index');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\ARBController@store'
		)->name('areceiveb.store');
		Route::put(
			'/{areceiveb}',
			'memfisfa\Finac\Controllers\Frontend\ARBController@update'
		)->name('areceiveb.update');
		Route::delete(
			'/{areceiveb}',
			'memfisfa\Finac\Controllers\Frontend\ARBController@destroy'
		)->name('areceiveb.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\ARBController@datatables'
		)->name('areceiveb.datatables');
		Route::get(
			'/{areceiveb}/edit',
			'memfisfa\Finac\Controllers\Frontend\ARBController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\ARBController@api'
		);
		Route::get(
			'/data/{areceiveb}',
			'memfisfa\Finac\Controllers\Frontend\ARBController@apidetail'
		);
	});

    Route::prefix('apaymenta')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\APAController@create'
		)->name('apaymenta.index');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\APAController@store'
		)->name('apaymenta.store');
		Route::put(
			'/{apaymenta}',
			'memfisfa\Finac\Controllers\Frontend\APAController@update'
		)->name('apaymenta.update');
		Route::delete(
			'/{apaymenta}',
			'memfisfa\Finac\Controllers\Frontend\APAController@destroy'
		)->name('apaymenta.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\APAController@datatables'
		)->name('apaymenta.datatables');
		Route::get(
			'/{apaymenta}/edit',
			'memfisfa\Finac\Controllers\Frontend\APAController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\APAController@api'
		);
		Route::get(
			'/data/{apaymenta}',
			'memfisfa\Finac\Controllers\Frontend\APAController@apidetail'
		);
	});

    Route::prefix('apaymentb')->group(function () {
		Route::get(
			'/',
			'memfisfa\Finac\Controllers\Frontend\APBController@create'
		)->name('apaymentb.index');
		Route::post(
			'/',
			'memfisfa\Finac\Controllers\Frontend\APBController@store'
		)->name('apaymentb.store');
		Route::put(
			'/{apaymentb}',
			'memfisfa\Finac\Controllers\Frontend\APBController@update'
		)->name('apaymentb.update');
		Route::delete(
			'/{apaymentb}',
			'memfisfa\Finac\Controllers\Frontend\APBController@destroy'
		)->name('apaymentb.delete');
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\APBController@datatables'
		)->name('apaymentb.datatables');
		Route::get(
			'/{apaymentb}/edit',
			'memfisfa\Finac\Controllers\Frontend\APBController@edit'
		);
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\APBController@api'
		);
		Route::get(
			'/data/{apaymentb}',
			'memfisfa\Finac\Controllers\Frontend\APBController@apidetail'
		);
	});

	Route::resource(
		'asset',
		'memfisfa\Finac\Controllers\Frontend\AssetController',
		['except' => 'show']
	);
    Route::prefix('asset')->group(function () {
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\AssetController@datatables'
		)->name('asset.datatables');
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\AssetController@data'
		);
	});

	Route::resource(
		'typeasset',
		'memfisfa\Finac\Controllers\Frontend\TypeAssetController',
		['except' => 'show']
	);
    Route::prefix('typeasset')->group(function () {
		Route::get(
			'/datatables',
			'memfisfa\Finac\Controllers\Frontend\TypeAssetController@datatables'
		)->name('typeasset.datatables');
		Route::get(
			'/data',
			'memfisfa\Finac\Controllers\Frontend\TypeAssetController@data'
		);
	});

	// Route::prefix('cashbook')->group(function () {
	// 	Route::get('/', 'memfisfa\Finac\Controllers\Frontend\CashbookController@index')->name('cashbook.index');
	// 	Route::delete('/{cashbook}', 'memfisfa\Finac\Controllers\Frontend\CashbookController@destroy')->name('cashbook.destroy');
	// 	Route::post('/{cashbook}/approve', 'memfisfa\Finac\Controllers\Frontend\CashbookController@approve')->name('cashbook.approve');
	// 	Route::get('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook.datatable');
	// });
	//
	// Route::prefix('cashbook-bpj')->group(function () {
	// 	Route::get('/', 'memfisfa\Finac\Controllers\Frontend\CashbookBPJController@index')->name('cashbook-bpj.index');
	// 	Route::get('/create', 'memfisfa\Finac\Controllers\Frontend\CashbookBPJController@create')->name('cashbook-bpj.create');
	// 	Route::post('/', 'memfisfa\Finac\Controllers\Frontend\CashbookBPJController@store')->name('cashbook-bpj.store');
	// 	Route::get('/{cashbook}/edit', 'memfisfa\Finac\Controllers\Frontend\CashbookBPJController@edit')->name('cashbook-bpj.edit');
	// 	Route::get('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-bpj.datatable');
	// 	Route::post('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookBPJController@detail')->name('cashbook-bpj.datatabledetail');
	// 	Route::post('/{cashbook}','memfisfa\Finac\Controllers\Frontend\CashbookBPJController@update')->name('cashbook-bpj.update');
	// 	Route::get('/{cashbook}','memfisfa\Finac\Controllers\Frontend\CashbookBPJController@show')->name('cashbook-bpj.show');
	// });
	//
	//
	// Route::prefix('cashbook-brj')->group(function () {
	// 	Route::get('/', 'memfisfa\Finac\Controllers\Frontend\CashbookBRJController@index')->name('cashbook-brj.index');
	// 	Route::get('/create', 'memfisfa\Finac\Controllers\Frontend\CashbookBRJController@create')->name('cashbook-brj.create');
	// 	Route::post('/', 'memfisfa\Finac\Controllers\Frontend\CashbookBRJController@store')->name('cashbook-brj.store');
	// 	Route::get('/{cashbook}/edit', 'memfisfa\Finac\Controllers\Frontend\CashbookBRJController@edit')->name('cashbook-brj.edit');
	// 	Route::get('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-brj.datatable');
	// 	Route::post('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookBRJController@detail')->name('cashbook-brj.datatabledetail');
	// 	Route::post('/{cashbook}','memfisfa\Finac\Controllers\Frontend\CashbookBRJController@update')->name('cashbook-brj.update');
	// 	Route::get('/{cashbook}','memfisfa\Finac\Controllers\Frontend\CashbookBRJController@show')->name('cashbook-brj.show');
	// });
	//
	// Route::prefix('cashbook-cpj')->group(function () {
	// 	Route::get('/', 'memfisfa\Finac\Controllers\Frontend\CashbookCPJController@index')->name('cashbook-cpj.index');
	// 	Route::get('/create', 'memfisfa\Finac\Controllers\Frontend\CashbookCPJController@create')->name('cashbook-cpj.create');
	// 	Route::post('/', 'memfisfa\Finac\Controllers\Frontend\CashbookCPJController@store')->name('cashbook-cpj.store');
	// 	Route::get('/{cashbook}/edit', 'memfisfa\Finac\Controllers\Frontend\CashbookCPJController@edit')->name('cashbook-cpj.edit');
	// 	Route::get('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-cpj.datatable');
	// 	Route::post('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookCPJController@detail')->name('cashbook-cpj.datatabledetail');
	// 	Route::post('/{cashbook}','memfisfa\Finac\Controllers\Frontend\CashbookCPJController@update')->name('cashbook-cpj.update');
	// 	Route::get('/{cashbook}','memfisfa\Finac\Controllers\Frontend\CashbookCPJController@show')->name('cashbook-cpj.show');
	// });
	//
	// Route::prefix('cashbook-crj')->group(function () {
	// 	Route::get('/', 'memfisfa\Finac\Controllers\Frontend\CashbookCRJController@index')->name('cashbook-crj.index');
	// 	Route::get('/create', 'memfisfa\Finac\Controllers\Frontend\CashbookCRJController@create')->name('cashbook-crj.create');
	// 	Route::post('/', 'memfisfa\Finac\Controllers\Frontend\CashbookCRJController@store')->name('cashbook-crj.store');
	// 	Route::get('/{cashbook}/edit', 'memfisfa\Finac\Controllers\Frontend\CashbookCRJController@edit')->name('cashbook-crj.edit');
	// 	Route::get('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-crj.datatable');
	// 	Route::post('/datatables','memfisfa\Finac\Controllers\Frontend\CashbookCRJController@detail')->name('cashbook-crj.datatabledetail');
	// 	Route::post('/{cashbook}','memfisfa\Finac\Controllers\Frontend\CashbookCRJController@update')->name('cashbook-crj.update');
	// 	Route::get('/{cashbook}','memfisfa\Finac\Controllers\Frontend\CashbookCRJController@show')->name('cashbook-crj.show');
	// });

	Route::prefix('invoice')->group(function () {
		Route::get('/', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@index')->name('invoice.index');
		Route::get('/datatables', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@datatables')->name('invoice.datatables');
		Route::post('/', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@store')->name('invoice.store');
		Route::post('/{invoice}/approve', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@approve')->name('invoice.approve');
		Route::get('/{invoice}/edit', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@edit')->name('invoice.edit');
		Route::post('/{invoice}/edit', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@update')->name('invoice.update');
		Route::delete('/{invoice}', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@destroy')->name('invoice.delete');
		Route::get('/create', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@create')->name('invoice.create');
		Route::get('/quotation/datatables/modal', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@quodatatables')->name('invoice.quodatable');
		Route::get('/quotation/datatables/modal/{quotation}/detail', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@apidetail')->name('invoice.apidetail');
		Route::get('/quotation/table/modal/{quotation}/detail', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@table')->name('invoice.table');
		Route::get('/print', 'memfisfa\Finac\Controllers\Frontend\InvoiceController@print')->name('invoice.print');
		Route::get(
			'/get-customers',
			'memfisfa\Finac\Controllers\Frontend\InvoiceController@getCustomer'
		)->name('invoice.customer.get');
	});

	// Route::prefix('ar')->group(function () {
	// 	Route::get('/', 'memfisfa\Finac\Controllers\Frontend\ARController@index')->name('ar.index');
	// 	Route::post('/', 'memfisfa\Finac\Controllers\Frontend\ARController@store')->name('ar.store');
	// 	Route::get('/{arecieve}/edit', 'memfisfa\Finac\Controllers\Frontend\ARController@edit')->name('ar.edit');
	// 	Route::get('/datatables', 'memfisfa\Finac\Controllers\Frontend\ARController@datatables')->name('ar.datatables');
	// 	Route::post('/{arecieve}/edit', 'memfisfa\Finac\Controllers\Frontend\ARController@update')->name('ar.update');
	// 	Route::get('/create', 'memfisfa\Finac\Controllers\Frontend\ARController@create')->name('ar.create');
	// 	Route::delete('/{arecieve}', 'memfisfa\Finac\Controllers\Frontend\ARController@destroy')->name('ar.delete');
	// });
	Route::get('/currencyfa', 'memfisfa\Finac\Controllers\Datatables\CurrencyController@index')->name('currency.fa');
	Route::get('/bankfa', 'memfisfa\Finac\Controllers\Datatables\BankController@index')->name('bank.fa');
	Route::get('/bankfa/{bankaccount}', 'memfisfa\Finac\Controllers\Datatables\BankController@detail')->name('bank.detailfa');
	Route::get('/customerfa/{customer}', 'memfisfa\Finac\Controllers\Frontend\ARController@cust_detail')->name('detailcusttt');
	//Route::resource('cashbook', 'memfisfa\Finac\Controllers\Frontend\CashbookController');

	//Route::resource('cashbook-bpj', 'memfisfa\Finac\Controllers\Frontend\CashbookBPJController');
	//Route::resource('cashbook-brj', 'memfisfa\Finac\Controllers\Frontend\CashbookBRJController');
	//Route::resource('cashbook-cpj', 'memfisfa\Finac\Controllers\Frontend\CashbookCPJController');
	//Route::resource('cashbook-crj', 'memfisfa\Finac\Controllers\Frontend\CashbookCRJController');


});
