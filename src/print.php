<?php

Route::get('/journal-docs', function () {
    $pdf = \PDF::loadView('formview::journal');
    return $pdf->stream();
});

Route::get('/trial-balance-docs', function () {
    $pdf = \PDF::loadView('formview::trial-balance');
    return $pdf->stream();
});


Route::get('/coa-docs', function () {
    $pdf = \PDF::loadView('formview::coa');
    return $pdf->stream();
});


Route::get('/bpj', function () {
    $pdf = \PDF::loadView('formview::bpj');
    $pdf->setPaper('A5', 'landscape');
    return $pdf->stream();
});

Route::get('/brj', function () {
    $pdf = \PDF::loadView('formview::brj');
    $pdf->setPaper('A5', 'landscape');
    return $pdf->stream();
});

Route::get('/cpj', function () {
    $pdf = \PDF::loadView('formview::cpj');
    $pdf->setPaper('A5', 'landscape');
    return $pdf->stream();
});

Route::get('/crj', function () {
    $pdf = \PDF::loadView('formview::crj');
    $pdf->setPaper('A5', 'landscape');
    return $pdf->stream();
});

Route::get('/ar-ap', function () {
    $pdf = \PDF::loadView('formview::ar-ap');
    $pdf->setPaper('A5', 'landscape');
    return $pdf->stream();
});

Route::get('/view-pl', function () {
    $pdf = \PDF::loadView('formview::view-pl');
    return $pdf->stream();
});


Route::get('/view-balance-sheet-docs', function () {
    $pdf = \PDF::loadView('formview::view-bs');
    return $pdf->stream();
});


Route::get('/detail-pl', function () {
    $pdf = \PDF::loadView('formview::detail-pl');
    return $pdf->stream();
});

Route::get('/invoice-docs', function () {
    $pdf = \PDF::loadView('formview::invoice');
    return $pdf->stream();
});

Route::get('/invoice-lampiran', function () {
    $pdf = \PDF::loadView('formview::invoice-lampiran');
    return $pdf->stream();
});

Route::get('/cashbook-docs', function () {
    $pdf = \PDF::loadView('formview::cashbook');
    return $pdf->stream();
});

Route::get('/customer-trial-balance-docs', function () {
    $pdf = \PDF::loadView('formview::customer-tb');
    return $pdf->stream();
});


Route::get('/ap-docs', function () {
    $pdf = \PDF::loadView('formview::ap');
    return $pdf->stream();
});


Route::get('/ar-docs', function () {
    $pdf = \PDF::loadView('formview::ar');
    return $pdf->stream();
});


Route::get('/outstanding-invoices-docs', function () {
    $pdf = \PDF::loadView('formview::outstanding-invoices');
    $pdf->setPaper('A4', 'landscape');
    return $pdf->stream();
});

Route::get('/aging-receivable-detail-docs', function () {
    $pdf = \PDF::loadView('formview::aging-receivable-detail-docs');
    $pdf->setPaper('A4', 'landscape');
    return $pdf->stream();
});

Route::get('/general-ledger-docs', function () {
    $pdf = \PDF::loadView('formview::general-ledger-docs');
    $pdf->setPaper('A4', 'landscape');
    return $pdf->stream();
});

Route::get('/supplier-invoice-grn', function () {
    $pdf = \PDF::loadView('formview::supplier-invoice-grn');
    $pdf->setPaper('A5', 'landscape');
    return $pdf->stream();
});

Route::get('/supplier-invoice-general', function () {
    $pdf = \PDF::loadView('formview::supplier-invoice-general');
    $pdf->setPaper('A5', 'landscape');
    return $pdf->stream();
});

Route::get('/profit-loss-project', function () {
    $pdf = \PDF::loadView('formview::profit-loss-project');
    return $pdf->stream();
});

Route::get('/inventory-expense-details', function () {
    $pdf = \PDF::loadView('formview::inventory-expense-details');
    return $pdf->stream();
});
