<?php


Route::group(['middleware' => ['web','auth']], function () {

    /** JOURNAL */

    Route::view('/journal', 'journalview::index')->name('journal.index');
    Route::view('/journal/create', 'journalview::create')->name('journal.create');
    Route::view('/journal/edit', 'journalview::edit')->name('journal.edit');
    Route::view('/journal/show', 'journalview::show')->name('journal.show');

});