<?php

namespace App\Helper;

class NumberHelper
{
    public static function castCurrency($input)
    {
        try {
            $split = explode(".", $input);
            $amount = implode("", $split);
        } catch (\Exception $e) {
            throw new \Exception("Terjadi kesalahan input data");
        }
        return $amount;
    }

    public static function numberFormat($input)
    {
        if (!$input) {
            return '';
        }
        return number_format($input, 0, ',', '.');
    }
}
