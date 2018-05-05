<?php

namespace redzjovi\php;

class MathHelper
{
    public static function isBuzz($number)
    {
        return ($number % 5 == 0) ? true : false;
    }

    public static function isFizz($number)
    {
        return ($number % 3 == 0) ? true : false;
    }

    public static function isFizzBuzz($number)
    {
        return ($number % 3 == 0 && $number % 5 == 0) ? true : false;
    }

    public static function isEven($number)
    {
        return ($number % 2 == 0) ? true : false;
    }

    public static function isOdd($number)
    {
        return ($number % 2 != 0) ? true : false;
    }

    public static function isPrime($number)
    {
        for ($i = 2; $i < $number; $i++) {
            if ($number % $i == 0) {
                return false;
            }
        }

        return true;
    }

    public static function roundUp($number, $precisionDecimal)
    {
        $numberDecimal = $number - (int) $number;
        $numberDecimalRound = $numberDecimal > $precisionDecimal ? 1 : 0;
        $number = (int) $number + $numberDecimalRound;
        return $number;
    }
}
