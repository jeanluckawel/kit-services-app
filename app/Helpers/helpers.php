<?php



if (!function_exists('payrollPeriod')) {

    function payrollPeriod()
    {
        $today = now();

        if ($today->day < 16) {
            $start = $today->copy()->subMonth()->day(16);
            $end   = $today->copy()->day(15);
        } else {
            $start = $today->copy()->day(16);
            $end   = $today->copy()->addMonth()->day(15);
        }

        return [
            'start' => $start->format('d/m/Y'),
            'end'   => $end->format('d/m/Y')
        ];
    }
}

