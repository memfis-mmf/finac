<?php


Route::group(['middleware' => ['web','auth']], function () {

    /** JOURNAL */

    Route::view('/journal', 'journalview::index')->name('journal.index');
    Route::view('/journal/create', 'journalview::create')->name('journal.create');
    Route::view('/journal/edit', 'journalview::edit')->name('journal.edit');
    Route::view('/journal/show', 'journalview::show')->name('journal.show');


    /** SUPPLIER INVOICE */

    Route::view('/supplier-invoice', 'supplierinvoiceview::index')->name('supplier-invoice.index');

    Route::view('/supplier-invoice-grn/create', 'supplierinvoicegrnview::create')->name('supplier-invoice-grn.create');
    Route::view('/supplier-invoice-grn/edit', 'supplierinvoicegrnview::edit')->name('supplier-invoice-grn.edit');
    Route::view('/supplier-invoice-grn/show', 'supplierinvoicegrnview::show')->name('supplier-invoice-grn.show');

    Route::view('/supplier-invoice-general/create', 'supplierinvoicegeneralview::create')->name('supplier-invoice-general.create');
    Route::view('/supplier-invoice-general/edit', 'supplierinvoicegeneralview::edit')->name('supplier-invoice-general.edit');
    Route::view('/supplier-invoice-general/show', 'supplierinvoicegeneralview::show')->name('supplier-invoice-general.show');

});