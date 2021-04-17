<?php
function priceFormat($number) {
    $decimal_point = '.';
    $thousand_point = ' ';
    $symbol_left   = '';
    $symbol_right  = ' pуб.';
    $decimal_place = 0;

    $string = '';

    if ($symbol_left) {
        $string .= $symbol_left;
    }

    $string .= number_format(round((float)$number, (int)$decimal_place), (int)$decimal_place, $decimal_point, $thousand_point);

    if ($symbol_right) {
        $string .= $symbol_right;
    }

    return $string;
}