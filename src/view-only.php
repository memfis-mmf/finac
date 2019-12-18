<?php


Route::group(['middleware' => ['web','auth']], function () {

    /** JOURNAL */

    Route::view('/journal', 'journalview::index')->name('journal.index');
    Route::view('/journal/create', 'journalview::create')->name('journal.create');
    Route::view('/journal/edit', 'journalview::edit')->name('journal.edit');
    Route::view('/journal/show', 'journalview::show')->name('journal.show');


    /** SUPPLIER INVOICE */

    Route::view('/supplier-invoice', 'supplierinvoiceview::index')->name('supplier-invoice.index');

    Route::view('/supplier-invoice/grn/create', 'supplierinvoicegrnview::create')->name('supplier-invoice-grn.create');
    Route::view('/supplier-invoice/grn/edit', 'supplierinvoicegrnview::edit')->name('supplier-invoice-grn.edit');
    Route::view('/supplier-invoice/grn/show', 'supplierinvoicegrnview::show')->name('supplier-invoice-grn.show');

    Route::view('/supplier-invoice/general/create', 'supplierinvoicegeneralview::create')->name('supplier-invoice-general.create');
    Route::view('/supplier-invoice/general/edit', 'supplierinvoicegeneralview::edit')->name('supplier-invoice-general.edit');
    Route::view('/supplier-invoice/general/show', 'supplierinvoicegeneralview::show')->name('supplier-invoice-general.show');
    

    /** ACCOUNT PAYABLE */

    Route::view('/account-payable', 'accountpayableview::index')->name('account-payable.index');

    Route::view('/account-payable/create', 'accountpayableview::create')->name('account-payable.create');
    Route::view('/account-payable/edit', 'accountpayableview::edit')->name('account-payable.edit');
    Route::view('/account-payable/show', 'accountpayableview::show')->name('account-payable.show');


    /** TRIAL BALANCE */

    Route::view('/trial-balance', 'trialbalanceview::index')->name('trial-balance.index');


    /** PROFIT AND LOSS */

    Route::view('/profit-loss', 'profitlossview::index')->name('profit-loss.index');
    Route::view('/profit-loss/view-pl', 'profitlossview::view-pl')->name('profit-loss.view-pl');
    Route::view('/profit-loss/detail-pl', 'profitlossview::detail-pl')->name('profit-loss.detail-pl');


    /** GENERAL LEDGER */

    Route::view('/general-ledger', 'generalledgerview::index')->name('general-ledger.index');
    Route::view('/general-ledger/show', 'generalledgerview::show')->name('general-ledger.show');



    /** BALANCE SHEET */

    Route::view('/balance-sheet', 'balancesheetview::index')->name('balance-sheet.index');
    Route::view('/balance-sheet/show', 'balancesheetview::view')->name('balance-sheet.view');


    /** MASTER ASSET */

    Route::view('/master-asset', 'masterassetview::index')->name('master-asset.index');

    Route::view('/master-asset/create', 'masterassetview::create')->name('master-asset.create');
    Route::view('/master-asset/edit', 'masterassetview::edit')->name('master-asset.edit');
    Route::view('/master-asset/show', 'masterassetview::show')->name('master-asset.show');

});