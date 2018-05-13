<?php

namespace redzjovi\php\algorithm;

class Kaprekar
{
    public static function selfNumbers($fromNumber = 1, $toNumber)
    {
        $allNumbers = [];
        $notSelfNumbers = [];

        for ($i = $fromNumber; $i <= $toNumber; $i++) {
            $allNumbers[] = $i;
            $generators = str_split($i);
            $notSelfNumbers[] = $i + array_sum($generators);
        }

        $selfNumbers = array_diff($allNumbers, $notSelfNumbers);

        return $selfNumbers;
    }
}
