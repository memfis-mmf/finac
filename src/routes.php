<?php


Route::get('test', function(){
	echo 'Hello from the Finance Accounting package!';
});

Route::group(['middleware' => ['web']], function () {

    Route::prefix('coa')->group(function () {
		Route::get('/', 'Directoryxx\Finac\Controllers\CoaController@create')->name('coa.index');
		Route::get('/type','Directoryxx\Finac\Controllers\CoaController@getdata');
		Route::post('/','Directoryxx\Finac\Controllers\CoaController@store')->name('coa.store');
		Route::put('/{coa}','Directoryxx\Finac\Controllers\CoaController@update')->name('coa.update');
		Route::delete('/{coa}','Directoryxx\Finac\Controllers\CoaController@destroy')->name('coa.delete');
		Route::get('/datatables','Directoryxx\Finac\Controllers\CoaController@datatables')->name('coa.datatables');
		Route::get('/{coa}/edit','Directoryxx\Finac\Controllers\CoaController@edit');
		Route::get('/type/{id}','Directoryxx\Finac\Controllers\CoaController@gettype');
		Route::get('/data','Directoryxx\Finac\Controllers\CoaController@api');
		Route::get('/data/{coa}','Directoryxx\Finac\Controllers\CoaController@apidetail');
	});

	Route::resource('cashbook', 'Directoryxx\Finac\Controllers\CashbookController');
	Route::resource('cashbook-bpj', 'Directoryxx\Finac\Controllers\CashbookBPJController');
	Route::resource('cashbook-brj', 'Directoryxx\Finac\Controllers\CashbookBRJController');
	Route::resource('cashbook-cpj', 'Directoryxx\Finac\Controllers\CashbookCPJController');
	Route::resource('cashbook-crj', 'Directoryxx\Finac\Controllers\CashbookCRJController');


});