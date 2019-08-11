<?php
Route::get('/coa', 'Memfis\Financeaccounting\Controllers\CoaController@create')->name('coa.index');
Route::post('/coa/getdata','Memfis\Financeaccounting\Controllers\CoaController@getdata');
Route::get('test', function(){
	echo 'Hello from the Finance Accounting package!';
});