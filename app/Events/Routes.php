<?php

namespace Flocc\Events;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Routes
 *
 * @package Flocc\Events
 */
class Routes extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events_routes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'event_id', 'place_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set comment ID
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
     * Get comment ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Set place ID
     *
     * @param int $place_id
     *
     * @return $this
     */
    public function setPlaceId($place_id)
    {
        $this->place_id = (int) $place_id;

        return $this;
    }

    /**
     * Get place ID
     *
     * @return int
     */
    public function getPlaceId()
    {
        return (int) $this->place_id;
    }
}