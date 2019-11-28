<?php

require('view-only.php');
require('print.php');

Route::get('test', function(){
	echo 'Hello from the Finance Accounting package!';
});

Route::group(['middleware' => ['web','auth']], function () {

    Route::prefix('coa')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CoaController@create')->name('coa.index');
		Route::get('/export', 'Directoryxx\Finac\Controllers\Frontend\CoaController@export')->name('coa.export');
		Route::get('/type','Directoryxx\Finac\Controllers\Frontend\CoaController@getdata');
		Route::post('/','Directoryxx\Finac\Controllers\Frontend\CoaController@store')->name('coa.store');
		Route::put('/{coa}','Directoryxx\Finac\Controllers\Frontend\CoaController@update')->name('coa.update');
		Route::delete('/{coa}','Directoryxx\Finac\Controllers\Frontend\CoaController@destroy')->name('coa.delete');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CoaController@datatables')->name('coa.datatables');
		Route::get('/{coa}/edit','Directoryxx\Finac\Controllers\Frontend\CoaController@edit');
		Route::get('/type/{id}','Directoryxx\Finac\Controllers\Frontend\CoaController@gettype');
		Route::get('/data','Directoryxx\Finac\Controllers\Frontend\CoaController@api');
		Route::get('/data/{coa}','Directoryxx\Finac\Controllers\Frontend\CoaController@apidetail');
		Route::get('/datatables/modal','Directoryxx\Finac\Controllers\Frontend\CoaController@basicModal');
	});

    Route::prefix('journal')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@create'
		)->name('journal.index');
		Route::post(
			'/approve',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@approve'
		);
		Route::get(
			'/type',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@getType'
		);
		Route::get(
			'/type-json',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@getTypeJson'
		);
		Route::get(
			'/currency',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@getCurrency'
		);
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@store'
		)->name('journal.store');
		Route::post(
			'/journala',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@journalaStore'
		)->name('journal.coaStore');
		Route::put(
			'/{journal}',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@update'
		)->name('journal.update');
		Route::delete(
			'/{journal}',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@destroy'
		)->name('journal.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@datatables'
		)->name('journal.datatables');
		Route::get(
			'/{journal}/edit',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@api'
		);
		Route::get(
			'/data/{journal}',
			'Directoryxx\Finac\Controllers\Frontend\JournalController@apidetail'
		);
	});

    Route::prefix('trial-balance')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TrialBalanceController@index'
		)->name('trialbalance.index');
		Route::get(
			'/print',
			'Directoryxx\Finac\Controllers\Frontend\TrialBalanceController@print_trial_balance'
		)->name('trialbalance.print');
	});

    Route::prefix('journala')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\JournalAController@create'
		)->name('journala.index');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\JournalAController@store'
		)->name('journala.store');
		Route::put(
			'/{journala}',
			'Directoryxx\Finac\Controllers\Frontend\JournalAController@update'
		)->name('journala.update');
		Route::delete(
			'/{journala}',
			'Directoryxx\Finac\Controllers\Frontend\JournalAController@destroy'
		)->name('journala.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\JournalAController@datatables'
		)->name('journala.datatables');
		Route::get(
			'/{journala}/edit',
			'Directoryxx\Finac\Controllers\Frontend\JournalAController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\JournalAController@api'
		);
		Route::get(
			'/data/{journala}',
			'Directoryxx\Finac\Controllers\Frontend\JournalAController@apidetail'
		);
	});

    Route::prefix('supplier-invoice')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@index'
		)->name('trxpayment.index');
		Route::post(
			'/approve',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@approve'
		);
		Route::get(
			'/create',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@create'
		)->name('trxpayment.create');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@store'
		)->name('trxpayment.store');
		Route::put(
			'/{trxpayment}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@update'
		)->name('trxpayment.update');
		Route::delete(
			'/{trxpayment}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@destroy'
		)->name('trxpayment.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@datatables'
		)->name('trxpayment.datatables');
		Route::get(
			'/{trxpayment}/edit',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@api'
		);
		Route::get(
			'/data/{trxpayment}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@apidetail'
		);
		Route::post(
			'/coa/use',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@coaUse'
		)->name('trxpayment.grn.use');
		Route::get(
			'/coa/items/datatables',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@coaDatatables'
		)->name('trxpayment.grn.datatables');

		//GRN
		Route::get(
			'/grn/create',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@grnCreate'
		)->name('trxpayment.grn.create');
		Route::put(
			'/grn/update',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@grnUpdate'
		)->name('trxpayment.grn.update');
		Route::post(
			'/grn/create',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@grnStore'
		)->name('trxpayment.grn.store');
		Route::post(
			'/grn/use',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@grnUse'
		)->name('trxpayment.grn.use');
		Route::get(
			'/grn/datatables',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@grnDatatables'
		)->name('trxpayment.grn.datatables');
		Route::get(
			'/grn/items/datatables',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@grnItemsDatatables'
		)->name('trxpayment.grn.datatables');
		Route::get(
			'/grn/{trxpayment}/edit',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@grnEdit'
		);
		Route::get(
			'/get-vendors',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentController@getVendor'
		)->name('trxpayment.vendor.get');
	});

    Route::prefix('trxpaymenta')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentAController@create'
		)->name('trxpaymenta.index');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentAController@store'
		)->name('trxpaymenta.store');
		Route::put(
			'/{trxpaymenta}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentAController@update'
		)->name('trxpaymenta.update');
		Route::delete(
			'/{trxpaymenta}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentAController@destroy'
		)->name('trxpaymenta.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentAController@datatables'
		)->name('trxpaymenta.datatables');
		Route::get(
			'/{trxpaymenta}/edit',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentAController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentAController@api'
		);
		Route::get(
			'/data/{trxpaymenta}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentAController@apidetail'
		);
	});

    Route::prefix('trxpaymentb')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentBController@create'
		)->name('trxpaymentb.index');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentBController@store'
		)->name('trxpaymentb.store');
		Route::put(
			'/{trxpaymentb}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentBController@update'
		)->name('trxpaymentb.update');
		Route::delete(
			'/{trxpaymentb}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentBController@destroy'
		)->name('trxpaymentb.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentBController@datatables'
		)->name('trxpaymentb.datatables');
		Route::get(
			'/{trxpaymentb}/edit',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentBController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentBController@api'
		);
		Route::get(
			'/data/{trxpaymentb}',
			'Directoryxx\Finac\Controllers\Frontend\TrxPaymentBController@apidetail'
		);
	});

    Route::prefix('account-payable')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\APController@create'
		)->name('apayment.index');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\APController@store'
		)->name('apayment.store');
		Route::put(
			'/{apayment}',
			'Directoryxx\Finac\Controllers\Frontend\APController@update'
		)->name('apayment.update');
		Route::delete(
			'/{apayment}',
			'Directoryxx\Finac\Controllers\Frontend\APController@destroy'
		)->name('apayment.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\APController@datatables'
		)->name('apayment.datatables');
		Route::get(
			'/coa/datatables',
			'Directoryxx\Finac\Controllers\Frontend\APController@coaDatatables'
		)->name('apayment.datatables');
		Route::get(
			'/{apayment}/edit',
			'Directoryxx\Finac\Controllers\Frontend\APController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\APController@api'
		);
		Route::get(
			'/data/{apayment}',
			'Directoryxx\Finac\Controllers\Frontend\APController@apidetail'
		);
		Route::get(
			'/si/modal/datatable',
			'Directoryxx\Finac\Controllers\Frontend\APController@SIModalDatatables'
		)->name('apayment.datatables');
	});

    Route::prefix('apaymenta')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\APAController@create'
		)->name('apaymenta.index');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\APAController@store'
		)->name('apaymenta.store');
		Route::put(
			'/{apaymenta}',
			'Directoryxx\Finac\Controllers\Frontend\APAController@update'
		)->name('apaymenta.update');
		Route::delete(
			'/{apaymenta}',
			'Directoryxx\Finac\Controllers\Frontend\APAController@destroy'
		)->name('apaymenta.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\APAController@datatables'
		)->name('apaymenta.datatables');
		Route::get(
			'/{apaymenta}/edit',
			'Directoryxx\Finac\Controllers\Frontend\APAController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\APAController@api'
		);
		Route::get(
			'/data/{apaymenta}',
			'Directoryxx\Finac\Controllers\Frontend\APAController@apidetail'
		);
	});

    Route::prefix('apaymentb')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\APBController@create'
		)->name('apaymentb.index');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\APBController@store'
		)->name('apaymentb.store');
		Route::put(
			'/{apaymentb}',
			'Directoryxx\Finac\Controllers\Frontend\APBController@update'
		)->name('apaymentb.update');
		Route::delete(
			'/{apaymentb}',
			'Directoryxx\Finac\Controllers\Frontend\APBController@destroy'
		)->name('apaymentb.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\APBController@datatables'
		)->name('apaymentb.datatables');
		Route::get(
			'/{apaymentb}/edit',
			'Directoryxx\Finac\Controllers\Frontend\APBController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\APBController@api'
		);
		Route::get(
			'/data/{apaymentb}',
			'Directoryxx\Finac\Controllers\Frontend\APBController@apidetail'
		);
	});

    Route::prefix('asset')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\AssetController@create'
		)->name('asset.index');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\AssetController@store'
		)->name('asset.store');
		Route::put(
			'/{asset}',
			'Directoryxx\Finac\Controllers\Frontend\AssetController@update'
		)->name('asset.update');
		Route::delete(
			'/{asset}',
			'Directoryxx\Finac\Controllers\Frontend\AssetController@destroy'
		)->name('asset.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\AssetController@datatables'
		)->name('asset.datatables');
		Route::get(
			'/{asset}/edit',
			'Directoryxx\Finac\Controllers\Frontend\AssetController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\AssetController@api'
		);
		Route::get(
			'/data/{asset}',
			'Directoryxx\Finac\Controllers\Frontend\AssetController@apidetail'
		);
	});

    Route::prefix('typeasset')->group(function () {
		Route::get(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TypeAssetController@create'
		)->name('typeasset.index');
		Route::post(
			'/',
			'Directoryxx\Finac\Controllers\Frontend\TypeAssetController@store'
		)->name('typeasset.store');
		Route::put(
			'/{typeasset}',
			'Directoryxx\Finac\Controllers\Frontend\TypeAssetController@update'
		)->name('typeasset.update');
		Route::delete(
			'/{typeasset}',
			'Directoryxx\Finac\Controllers\Frontend\TypeAssetController@destroy'
		)->name('typeasset.delete');
		Route::get(
			'/datatables',
			'Directoryxx\Finac\Controllers\Frontend\TypeAssetController@datatables'
		)->name('typeasset.datatables');
		Route::get(
			'/{typeasset}/edit',
			'Directoryxx\Finac\Controllers\Frontend\TypeAssetController@edit'
		);
		Route::get(
			'/data',
			'Directoryxx\Finac\Controllers\Frontend\TypeAssetController@api'
		);
		Route::get(
			'/data/{typeasset}',
			'Directoryxx\Finac\Controllers\Frontend\TypeAssetController@apidetail'
		);
	});

	Route::prefix('cashbook')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookController@index')->name('cashbook.index');
		Route::delete('/{cashbook}', 'Directoryxx\Finac\Controllers\Frontend\CashbookController@destroy')->name('cashbook.destroy');
		Route::post('/{cashbook}/approve', 'Directoryxx\Finac\Controllers\Frontend\CashbookController@approve')->name('cashbook.approve');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook.datatable');
	});

	Route::prefix('cashbook-bpj')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookBPJController@index')->name('cashbook-bpj.index');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\CashbookBPJController@create')->name('cashbook-bpj.create');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookBPJController@store')->name('cashbook-bpj.store');
		Route::get('/{cashbook}/edit', 'Directoryxx\Finac\Controllers\Frontend\CashbookBPJController@edit')->name('cashbook-bpj.edit');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-bpj.datatable');
		Route::post('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookBPJController@detail')->name('cashbook-bpj.datatabledetail');
		Route::post('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookBPJController@update')->name('cashbook-bpj.update');
		Route::get('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookBPJController@show')->name('cashbook-bpj.show');
	});


	Route::prefix('cashbook-brj')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@index')->name('cashbook-brj.index');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@create')->name('cashbook-brj.create');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@store')->name('cashbook-brj.store');
		Route::get('/{cashbook}/edit', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@edit')->name('cashbook-brj.edit');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-brj.datatable');
		Route::post('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@detail')->name('cashbook-brj.datatabledetail');
		Route::post('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@update')->name('cashbook-brj.update');
		Route::get('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@show')->name('cashbook-brj.show');
	});

	Route::prefix('cashbook-cpj')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@index')->name('cashbook-cpj.index');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@create')->name('cashbook-cpj.create');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@store')->name('cashbook-cpj.store');
		Route::get('/{cashbook}/edit', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@edit')->name('cashbook-cpj.edit');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-cpj.datatable');
		Route::post('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@detail')->name('cashbook-cpj.datatabledetail');
		Route::post('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@update')->name('cashbook-cpj.update');
		Route::get('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@show')->name('cashbook-cpj.show');
	});

	Route::prefix('cashbook-crj')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@index')->name('cashbook-crj.index');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@create')->name('cashbook-crj.create');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@store')->name('cashbook-crj.store');
		Route::get('/{cashbook}/edit', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@edit')->name('cashbook-crj.edit');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-crj.datatable');
		Route::post('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@detail')->name('cashbook-crj.datatabledetail');
		Route::post('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@update')->name('cashbook-crj.update');
		Route::get('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@show')->name('cashbook-crj.show');
	});

	Route::prefix('invoice')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@index')->name('invoice.index');
		Route::get('/datatables', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@datatables')->name('invoice.datatables');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@store')->name('invoice.store');
		Route::post('/{invoice}/approve', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@approve')->name('invoice.approve');
		Route::get('/{invoice}/edit', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@edit')->name('invoice.edit');
		Route::post('/{invoice}/edit', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@update')->name('invoice.update');
		Route::delete('/{invoice}', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@destroy')->name('invoice.delete');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@create')->name('invoice.create');
		Route::get('/quotation/datatables/modal', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@quodatatables')->name('invoice.quodatable');
		Route::get('/quotation/datatables/modal/{quotation}/detail', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@apidetail')->name('invoice.apidetail');
		Route::get('/quotation/table/modal/{quotation}/detail', 'Directoryxx\Finac\Controllers\Frontend\InvoiceController@table')->name('invoice.table');
	});

	Route::prefix('ar')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\ARController@index')->name('ar.index');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\ARController@store')->name('ar.store');
		Route::get('/{arecieve}/edit', 'Directoryxx\Finac\Controllers\Frontend\ARController@edit')->name('ar.edit');
		Route::get('/datatables', 'Directoryxx\Finac\Controllers\Frontend\ARController@datatables')->name('ar.datatables');
		Route::post('/{arecieve}/edit', 'Directoryxx\Finac\Controllers\Frontend\ARController@update')->name('ar.update');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\ARController@create')->name('ar.create');
		Route::delete('/{arecieve}', 'Directoryxx\Finac\Controllers\Frontend\ARController@destroy')->name('ar.delete');
	});
	Route::get('/currencyfa', 'Directoryxx\Finac\Controllers\Datatables\CurrencyController@index')->name('currency.fa');
	Route::get('/bankfa', 'Directoryxx\Finac\Controllers\Datatables\BankController@index')->name('bank.fa');
	Route::get('/bankfa/{bankaccount}', 'Directoryxx\Finac\Controllers\Datatables\BankController@detail')->name('bank.detailfa');
	Route::get('/customerfa/{customer}', 'Directoryxx\Finac\Controllers\Frontend\ARController@cust_detail')->name('detailcusttt');
	//Route::resource('cashbook', 'Directoryxx\Finac\Controllers\Frontend\CashbookController');

	//Route::resource('cashbook-bpj', 'Directoryxx\Finac\Controllers\Frontend\CashbookBPJController');
	//Route::resource('cashbook-brj', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController');
	//Route::resource('cashbook-cpj', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController');
	//Route::resource('cashbook-crj', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController');


});
