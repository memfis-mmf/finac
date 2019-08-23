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

	//Route::resource('cashbook', 'Directoryxx\Finac\Controllers\Frontend\CashbookController');
	
	Route::resource('cashbook-bpj', 'Directoryxx\Finac\Controllers\Frontend\CashbookBPJController');
	Route::resource('cashbook-brj', 'Directoryxx\Finac\Controllers\Frontend\CashbookBRJController');
	Route::resource('cashbook-cpj', 'Directoryxx\Finac\Controllers\Frontend\CashbookCPJController');
	Route::resource('cashbook-crj', 'Directoryxx\Finac\Controllers\Frontend\CashbookCRJController');
	

});