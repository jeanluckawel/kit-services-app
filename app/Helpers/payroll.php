<?php
use Carbon\Carbon;

if (!function_exists('payrollPeriod')) {
    function payrollPeriod()
    {
        $today = Carbon::now();

        if ($today->day < 16) {

            $start = Carbon::create($today->year, $today->month, 16)->subMonth()->format('d F');
            $end   = Carbon::create($today->year, $today->month, 15)->format('d F');
        } else {

            $start = Carbon::create($today->year, $today->month, 16)->format('d F');
            $end   = Carbon::create($today->year, $today->month, 15)->addMonth()->format('d F');
        }

        return [
            'start' => $start,
            'end'   => $end,
        ];
    }
}

if (!function_exists('payrollMonth')) {
    function payrollMonth()
    {
        $today = Carbon::now();

        // Si avant le 16 → mois courant ; sinon → mois suivant
        return $today->day < 16 ? $today->month : $today->copy()->addMonth()->month;
    }
}
