<?php

namespace Flocc\Profile\TimeLine;

use Flocc\Events\Events;
use Flocc\Events\Search;

/**
 * Class TimeLine
 *
 * @package Flocc\Profile\TimeLine
 */
class TimeLine
{
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get latest by last update date
     *
     * @return Events
     */
    public function getLatestUpdatedEvents()
    {
        return (new Events())->getLatestUpdatedTime(5);
    }

    /**
     * Get latest inspirations
     *
     * @return Events
     */
    public function getInspirations()
    {
        return (new Events())->getLatestEvents(5, true);
    }

    /**
     * Get latest events
     *
     * @return Events
     */
    public function getEvents()
    {
        return (new Events())->getLatestEvents(5);
    }
}