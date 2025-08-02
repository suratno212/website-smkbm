<?php

if (!function_exists('getStatusTextHelper')) {
    function getStatusTextHelper($status)
    {
        $statusMap = [
            'H' => 'Hadir',
            'S' => 'Sakit',
            'I' => 'Izin',
            'A' => 'Alpha'
        ];

        return $statusMap[$status] ?? $status;
    }
}
