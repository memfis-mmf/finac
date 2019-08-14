<?php
Route::prefix('coa')->group(function () {
    Route::get('/', 'Directoryxx\Finac\Controllers\CoaController@create')->name('coa.index');
	Route::get('/type','Directoryxx\Finac\Controllers\CoaController@getdata');

});

Route::get('test', function(){
	echo 'Hello from the Finance Accounting package!';
});