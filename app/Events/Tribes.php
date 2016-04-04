<?php

namespace Flocc\Events;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tribes
 *
 * @package Flocc\Events
 */
class Tribes extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events_tribes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'event_id', 'tribe_id'];

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
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Get ID
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
        return $this->event_id;
    }

    /**
     * Set tribe ID
     *
     * @param int $tribe_id
     *
     * @return $this
     */
    public function setTribeId($tribe_id)
    {
        $this->tribe_id = (int) $tribe_id;

        return $this;
    }

    /**
     * Get tribe ID
     *
     * @return int
     */
    public function getTribeId()
    {
        return $this->tribe_id;
    }

    /**
     * Get tribe name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Delete all tribes from event
     *
     * @param int $event_id
     *
     * @return mixed
     */
    public function clear($event_id)
    {
        return self::where('event_id', (int) $event_id)->delete();
    }

    /**
     * Add new tribe to event
     *
     * @param int $event_id
     * @param int $tribe_id
     *
     * @return static
     */
    public function add($event_id, $tribe_id)
    {
        return self::create(['event_id' => (int) $event_id, 'tribe_id' => (int) $tribe_id]);
    }
}