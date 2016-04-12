<?php

namespace Flocc\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Logs
 *
 * @package Flocc\User
 */
class Logs extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'type', 'time', 'search_id', 'event_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set user ID
     *
     * @param int $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = (int) $user_id;

        return $this;
    }

    /**
     * Set type as users.registry
     *
     * @return $this
     */
    public function setTypeUsersRegistry()
    {
        $this->type = 'users.registry';

        return $this;
    }

    /**
     * Set type as users.login
     *
     * @return $this
     */
    public function setTypeUsersLogin()
    {
        $this->type = 'users.login';

        return $this;
    }

    /**
     * Set type as users.logout
     *
     * @return $this
     */
    public function setTypeUsersLogout()
    {
        $this->type = 'users.logout';

        return $this;
    }

    /**
     * Set type as events.create
     *
     * @return $this
     */
    public function setTypeEventsCreate()
    {
        $this->type = 'events.create';

        return $this;
    }

    /**
     * Set type as events.search
     *
     * @return $this
     */
    public function setTypeEventsSearch()
    {
        $this->type = 'events.search';

        return $this;
    }

    /**
     * Set type as events.display
     *
     * @return $this
     */
    public function setTypeEventsDisplay()
    {
        $this->type = 'events.display';

        return $this;
    }

    /**
     * Set ID from searches table
     *
     * @param int $id
     *
     * @return $this
     */
    public function setSearchId($id)
    {
        if($this->type == 'events.search') {
            $this->search_id = (int) $id;
        }

        return $this;
    }

    /**
     * Set ID from events table
     *
     * @param int $id
     *
     * @return $this
     */
    public function setEventId($id)
    {
        if(in_array($this->type, ['events.create', 'events.display'])) {
            $this->event_id = (int) $id;
        }

        return $this;
    }
}