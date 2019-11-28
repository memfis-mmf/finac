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