<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('format_price')) {
    function format_price($amount) {
        $currency = Session::get('currency', 'VND');
        $raw = is_numeric($amount) ? $amount : str_replace([',', ' '], '', (string) $amount);
        $value = is_numeric($raw) ? (float) $raw : 0;

        if ($currency === 'USD') {
            $rate = 25000;
            return number_format($value / $rate, 2) . ' USD';
        }

        return number_format($value) . ' VND';
    }
}
