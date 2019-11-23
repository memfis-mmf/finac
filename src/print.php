<?php

Route::get('/journal-docs', function () {
    $pdf = \PDF::loadView('formview::journal');
    return $pdf->stream();
});

Route::get('/trial-balance-docs', function () {
    $pdf = \PDF::loadView('formview::trial-balance');
    return $pdf->stream();
});