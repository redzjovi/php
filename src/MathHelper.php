<?php

namespace redzjovi\php;

class MathHelper
{
    public static function roundUp($number, $precisionDecimal)
    {
        $numberDecimal = $number - (int) $number;
        $numberDecimalRound = $numberDecimal > $precisionDecimal ? 1 : 0;
        $number = (int) $number + $numberDecimalRound;
        return $number;
    }
}
