<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    const EURUSD = 1.124;
    const EURGBP = 0.892;

    public static function convertTo(float $valueInEuros, string $target){
        switch($target) {
            case "EUR":
                return $valueInEuros;
            case "USD":
                return $valueInEuros * self::EURUSD;
            case "GBP":
                return $valueInEuros * self::EURGBP;
        }

        return $valueInEuros;
    }
}
