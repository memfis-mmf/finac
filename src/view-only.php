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


    /** BOND */

    Route::view('/bond', 'bondview::index')->name('bond.index');

    Route::view('/bond/create', 'bondview::create')->name('bond.create');
    Route::view('/bond/edit', 'bondview::edit')->name('bond.edit');
    Route::view('/bond/show', 'bondview::show')->name('bond.show');



    /** CASHBOOK (NEW) */


    Route::view('/cashbook-new', 'cashbooknewview::index')->name('cashbook-new.index');

    Route::view('/cashbook-new/create', 'cashbooknewview::create')->name('cashbook-new.create');
    Route::view('/cashbook-new/edit', 'cashbooknewview::edit')->name('cashbook-new.edit');
    Route::view('/cashbook-new/show', 'cashbooknewview::show')->name('cashbook-new.show');


    /** ASSET CATEGORY */

    Route::view('/asset-category', 'assetcategoryview::index')->name('asset-category.index');

    Route::view('/asset-category/create', 'assetcategoryview::create')->name('asset-category.create');
    Route::view('/asset-category/edit', 'assetcategoryview::edit')->name('asset-category.edit');
    Route::view('/asset-category/show', 'assetcategoryview::show')->name('asset-category.show');


    /** AR REPORT*/

    Route::view('/ar-report', 'arreportview::index')->name('ar-report.index');

    Route::view('/ar-report/outstanding-invoice', 'arreport-outstandingview::index')->name('ar-report.outstanding-invoice.index');
    Route::view('/ar-report/aging-receivables-detail', 'arreport-agingview::index')->name('ar-report.aging-receivables-detail.index');
    Route::view('/ar-report/customer-trial-balance', 'arreport-customertbview::index')->name('ar-report.customer-trial-balance.index');
    Route::view('/ar-report/account-receivables-history', 'arreport-accountrhview::index')->name('ar-report.account-receivables-history.index');
    Route::view('/ar-report/invoice-paid', 'arreport-invoicepview::index')->name('ar-report.invoice-paid.index');

});