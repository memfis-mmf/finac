<?php

require('view-only.php');

Route::get('test', function(){
	echo 'Hello from the Finance Accounting package!';
});

Route::group(['middleware' => ['web','auth']], function () {

    Route::prefix('coa')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CoaController@create')->name('coa.index');
		Route::get('/type','Directoryxx\Finac\Controllers\Frontend\CoaController@getdata');
		Route::post('/','Directoryxx\Finac\Controllers\Frontend\CoaController@store')->name('coa.store');
		Route::put('/{coa}','Directoryxx\Finac\Controllers\Frontend\CoaController@update')->name('coa.update');
		Route::delete('/{coa}','Directoryxx\Finac\Controllers\Frontend\CoaController@destroy')->name('coa.delete');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CoaController@datatables')->name('coa.datatables');
		Route::get('/{coa}/edit','Directoryxx\Finac\Controllers\Frontend\CoaController@edit');
		Route::get('/type/{id}','Directoryxx\Finac\Controllers\Frontend\CoaController@gettype');
		Route::get('/data','Directoryxx\Finac\Controllers\Frontend\CoaController@api');
		Route::get('/data/{coa}','Directoryxx\Finac\Controllers\Frontend\CoaController@apidetail');
		Route::get('/datatables/modal','Directoryxx\Finac\Controllers\Datatables\CoaDatatables@basicModal');
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
	Route::get('/customerfa/{customer}', 'Directoryxx\Finac\Controllers\Frontend\ARController@cust_detail')->name('customer.detailfa');
	//Route::resource('cashbook', 'Directoryxx\Finac\Controllers\Frontend\CashbookController');
	
	//Route::resource('cashbook-bpj', 'Directoryxx\Finac\Controllers\Frontend\CashbookBPJController');
	//Route::resource('cashbook-brj', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController');
	//Route::resource('cashbook-cpj', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController');
	//Route::resource('cashbook-crj', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController');
	

});