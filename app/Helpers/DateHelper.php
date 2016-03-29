<?php

namespace Flocc\Helpers;

/**
 * Class DateHelper
 *
 * @package Flocc\Helpers
 */
class DateHelper
{
    /**
     * Get months list
     *
     * @param null|int $month
     *
     * @return array
     */
    public function getMonths($month = null)
    {
        $months = [
            1 => 'Styczeń',
            2 => 'Luty',
            3 => 'Marzec',
            4 => 'Kwiecień',
            5 => 'Maj',
            6 => 'Czerwiec',
            7 => 'Lipiec',
            8 => 'Sierpień',
            9 => 'Wrzesień',
            10 => 'Październik',
            11 => 'Listopad',
            12 => 'Grudzień'
        ];

        return ($month === null) ? $months : $months[$month];
    }
}