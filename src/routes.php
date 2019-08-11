<?php
Route::get('/coa', 'Directoryxx\Finac\Controllers\CoaController@create')->name('coa.index');
Route::post('/coa/getdata','Directoryxx\Finac\Controllers\CoaController@getdata');
Route::get('test', function(){
	echo 'Hello from the Finance Accounting package!';
});