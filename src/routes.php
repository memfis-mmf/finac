<?php


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
	});


	Route::prefix('cashbook-brj')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@index')->name('cashbook-brj.index');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@create')->name('cashbook-brj.create');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@store')->name('cashbook-brj.store');
		Route::get('/{cashbook}/edit', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@edit')->name('cashbook-brj.edit');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-brj.datatable');
		Route::post('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@detail')->name('cashbook-brj.datatabledetail');
		Route::post('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookBRJController@update')->name('cashbook-brj.update');
	});

	Route::prefix('cashbook-cpj')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@index')->name('cashbook-cpj.index');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@create')->name('cashbook-cpj.create');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@store')->name('cashbook-cpj.store');
		Route::get('/{cashbook}/edit', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@edit')->name('cashbook-cpj.edit');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-cpj.datatable');
		Route::post('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@detail')->name('cashbook-cpj.datatabledetail');
		Route::post('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookCPJController@update')->name('cashbook-cpj.update');
	});

	Route::prefix('cashbook-crj')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@index')->name('cashbook-crj.index');
		Route::get('/create', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@create')->name('cashbook-crj.create');
		Route::post('/', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@store')->name('cashbook-crj.store');
		Route::get('/{cashbook}/edit', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@edit')->name('cashbook-crj.edit');
		Route::get('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookController@datatables')->name('cashbook-crj.datatable');
		Route::post('/datatables','Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@detail')->name('cashbook-crj.datatabledetail');
		Route::post('/{cashbook}','Directoryxx\Finac\Controllers\Frontend\CashbookCRJController@update')->name('cashbook-crj.update');
	});

	//Route::resource('cashbook', 'Directoryxx\Finac\Controllers\Frontend\CashbookController');
	
	//Route::resource('cashbook-bpj', 'Directoryxx\Finac\Controllers\Frontend\CashbookBPJController');
	//Route::resource('cashbook-brj', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController');
	//Route::resource('cashbook-cpj', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController');
	//Route::resource('cashbook-crj', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController');
	

});