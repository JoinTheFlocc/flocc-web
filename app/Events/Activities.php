<?php

namespace Flocc\Events;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activities
 *
 * @package Flocc\Events
 */
class Activities extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'activity_id', 'event_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set ID
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
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
     * Get activity name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}