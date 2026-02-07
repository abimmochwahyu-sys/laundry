<?php

if (!function_exists('formatTanggal')) {
    function formatTanggal($tanggal)
    {
        if (is_object($tanggal) && method_exists($tanggal, 'format')) {
            return $tanggal->format('d/m/Y');
        } else {
            return date('d/m/Y', strtotime($tanggal));
        }
    }
}
