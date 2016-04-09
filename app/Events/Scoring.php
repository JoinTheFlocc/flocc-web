<?php

namespace Flocc\Events;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Scoring
 *
 * @package Flocc\Events
 */
class Scoring extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events_scoring';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['event_id', 'activity_id', 'tribes'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'event_id';

    /**
     * Set event ID
     *
     * @param int $event_id
     *
     * @return $this
     */
    public function setEventId($event_id)
    {
        $this->event_id = (int) $event_id;

        return $this;
    }

    /**
     * Get event ID
     *
     * @return int
     */
    public function getEventId()
    {
        return (int) $this->event_id;
    }

    /**
     * Set activity ID
     *
     * @param int $activity_id
     *
     * @return $this
     */
    public function setActivityId($activity_id)
    {
        $this->activity_id = (int) $activity_id;

        return $this;
    }

    /**
     * Get activity ID
     *
     * @return int
     */
    public function getActivityId()
    {
        return (int) $this->activity_id;
    }

    /**
     * Set tribes
     *
     * @param array $tribes
     *
     * @return $this
     */
    public function setTribes(array $tribes)
    {
        $tribes_string     = '';
        $all_tribes        = \Flocc\Tribes::all();

        foreach($all_tribes as $tribe) {
            $tribe_id = $tribe->getId();

            $tribes_string .= (in_array($tribe_id, $tribes) ? 1 : 0);
        }

        $this->tribes = $tribes_string;

        return $this;
    }

    /**
     * Get tribes
     *
     * @return string
     */
    public function getTribes()
    {
        return $this->tribes;
    }

    /**
     * Set place name
     *
     * @param string $place
     * 
     * @return $this
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return $this
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get scoring by event ID
     *
     * @param int $event_id
     *
     * @return \Flocc\Events\Scoring
     */
    public function getByEventId($event_id)
    {
        return self::where('event_id', $event_id)->take(1)->first();
    }
}