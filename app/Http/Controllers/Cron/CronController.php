<?php

namespace Flocc\Http\Controllers\Cron;

use Flocc\Cron\Cron;
use Flocc\Http\Controllers\Controller;

/**
 * Class CronController
 *
 * @package Flocc\Http\Controllers\Cron
 */
class CronController extends Controller
{
    /**
     * Run CRON
     *
     * @param string $schedule
     * 
     * @return int
     */
    public function execute($schedule)
    {
        return (new Cron())->execute($schedule);
    }
}