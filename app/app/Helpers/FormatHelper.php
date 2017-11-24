<?php

namespace App\Helpers;

use App;

class FormatHelper
{
    public function __construct()
    {
    }

    public function getNumberWithUnit($number) {
        $unit = "";

        if($number >= 1000000) {
            $number /= 1000000;
            $unit = "M";
        }

        if($number >= 1000) {
            $number /= 1000;
            $unit = "K";
        }

        if(is_integer($number))
            return $number . $unit;

        return number_format($number, 1) . $unit;
    }
}