<?php

function formatNumber($value, $attributes = array())
{
    $format = 'number';
    $decimals = 0;
    $currency = "USD";

    foreach ($attributes AS $key => $attribute) {
        if ($attribute) {
            $$key = $attribute;
        }
    }

    if (!isset($attributes['decimals']) && ($format == 'currency' || $format == 'percentage' || $format == 'crypto')) {
        $decimals = 2;
    }

    if (!isset($attributes['currency']) && $format == 'crypto') {
        $currency = 'TRX';
    }

    switch($format)
    {
        case 'currency' :
            $result = getCurrencySymbol($currency).number_format($value, $decimals);
            break;

        case 'percentage' :
            $result = number_format($value, $decimals).'%';
            break;

        case 'crypto' :
            $result = number_format($value, $decimals).' '.strtoupper($currency);
            break;

        default :
            $result = number_format($value, $decimals);
    }

    if ($value > 0) {
        $result = '<span class="text-success">'.$result.'</span>';
    } elseif ($value < 0) {
        $result = '<span class="text-danger">'.$result.'</span>';
    } else {
        $result = '<span class="text-muted">'.$result.'</span>';
    }

    return $result;
}

function getCurrencySymbol($currency = "USD")
{
    switch($currency)
    {
        case 'GBP' :
            $currencySymbol = '£';
            break;

        default :
            $currencySymbol = '$';
    }

    return $currencySymbol;
}
