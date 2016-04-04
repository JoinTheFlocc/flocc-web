<?php

namespace Flocc\Searches;

/**
 * Class Top
 *
 * @package Flocc\Searches
 */
class Top
{
    private $activities, $places, $tribes, $limit;

    /**
     * Top constructor.
     *
     * @param \Flocc\Searches $activities
     * @param \Flocc\Searches $places
     * @param \Flocc\Searches $tribes
     * @param int $limit
     */
    public function __construct($activities, $places, $tribes, $limit)
    {
        $this->activities   = $activities;
        $this->places       = $places;
        $this->tribes       = $tribes;
        $this->limit        = $limit;
    }

    /**
     * Get top tribes
     *
     * @return array
     */
    public function getTribes()
    {
        $data = [];

        foreach($this->tribes as $tribe) {
            $tribes = $tribe->getTribes();

            if(is_array($tribes)) {
                foreach($tribes as $tribe_id) {
                    $tribe_id = (int) $tribe_id;
                    
                    if(!isset($data[$tribe_id])) {
                        $data[$tribe_id] = 0;
                    }

                    ++$data[$tribe_id];
                }
            }
        }

        uasort($data, function($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a > $b) ? -1 : 1;
        });

        return array_slice($data, 0, $this->limit, true);
    }

    /**
     * Get top places
     *
     * @return array
     */
    public function getPlaces()
    {
        $data = [];

        foreach($this->places as $place) {
            $data[$place->getPlace()] = $place->getCount();
        }

        return $data;
    }

    /**
     * Get top activities
     *
     * @return array
     */
    public function getActivities()
    {
        $data = [];

        foreach($this->activities as $activity) {
            $data[(int) $activity->getActivityId()] = $activity->getCount();
        }

        return $data;
    }
}