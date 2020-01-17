<?php

namespace memfisfa\Finac\Helpers;

use Carbon\Carbon;

class CashbookGenerateNumber
{
    static function setNumber($count) {
        $date = Carbon::now()->format('Y/m');

        $number = '00000' . $count;
        
        $doc_number = $date . '/' . substr($number, strlen($number - 1));

        return $doc_number;
    }

    public static function generate($prefix, $count, $suffix = '') {
        return $prefix . self::setNumber($count) . $suffix;
    }
}
