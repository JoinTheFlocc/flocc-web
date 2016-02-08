<?php

namespace Flocc\Events;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Members
 *
 * @package Flocc\Events
 */
class Members extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events_members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'event_id', 'user_id', 'status', 'join_data', 'status_change_date'];

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
        return (int) $this->id;
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
     * Set user ID
     *
     * @param int $user_id
     *
     * @return int
     */
    public function setUserId($user_id)
    {
        $this->user_id = (int) $user_id;

        return $this->user_id;
    }

    /**
     * Get user ID
     *
     * @return int
     */
    public function getUserId()
    {
        return (int) $this->user_id;
    }

    /**
     * Set status as awaiting
     *
     * @return $this
     */
    public function setStatusAsAwaiting()
    {
        $this->status = 'awaiting';

        return $this;
    }

    /**
     * Is status awaiting
     *
     * @return bool
     */
    public function isStatusAwaiting()
    {
        return ($this->status == 'awaiting');
    }

    /**
     * Set status as rejected
     *
     * @return $this
     */
    public function setStatusAsRejected()
    {
        $this->status = 'rejected';

        return $this;
    }

    /**
     * Is status rejected
     *
     * @return bool
     */
    public function isStatusRejected()
    {
        return ($this->status == 'rejected');
    }

    /**
     * Set status as follower
     *
     * @return $this
     */
    public function setStatusAsFollower()
    {
        $this->status = 'follower';

        return $this;
    }

    /**
     * Is status follower
     *
     * @return bool
     */
    public function isStatusFollower()
    {
        return ($this->status == 'follower');
    }

    /**
     * Set status as member
     *
     * @return $this
     */
    public function setStatusAsMember()
    {
        $this->status = 'member';

        return $this;
    }

    /**
     * Is status member
     *
     * @return bool
     */
    public function isStatusMember()
    {
        return ($this->status == 'member');
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set join date
     *
     * @param string $join_data
     *
     * @return $this
     */
    public function setJoinData($join_data)
    {
        $this->join_data = $join_data;

        return $this;
    }

    /**
     * Get join date
     *
     * @return string
     */
    public function getJoinData()
    {
        return $this->join_data;
    }

    /**
     * Set status change date
     *
     * @param string $status_change_date
     *
     * @return $this
     */
    public function setStatusChangeDate($status_change_date)
    {
        $this->status_change_date = $status_change_date;

        return $this;
    }

    /**
     * Get status change date
     *
     * @return string
     */
    public function getStatusChangeDate()
    {
        return $this->status_change_date;
    }

    /**
     * Get user
     *
     * @return \Flocc\User
     */
    public function getUser()
    {
        return $this->hasOne('Flocc\User', 'id', 'user_id')->first();
    }

    /**
     * Check user in event
     *
     * @param int $event_id
     * @param int $user_id
     *
     * @return false|\Flocc\Events\Members
     */
    public function getUserInEvent($event_id, $user_id)
    {
        return self::where('user_id', (int) $user_id)->where('event_id', (int) $event_id)->take(1)->first();
    }

    /**
     * Add new member or follower
     *
     * @param int $event_id
     * @param int $user_id
     * @param string $status
     *
     * @return bool
     */
    public function addNew($event_id, $user_id, $status)
    {
        $insert = Members::create([
            'event_id'  => $event_id,
            'user_id'   => $user_id,
            'status'    => $status
        ]);

        return ($insert === null) ? false : true;
    }

    /**
     * Add new member
     *
     * @param int $event_id
     * @param int $user_id
     *
     * @return bool
     */
    public function addNewMember($event_id, $user_id)
    {
        return $this->addNew($event_id, $user_id, 'awaiting');
    }

    /**
     * Add new follower
     *
     * @param int $event_id
     * @param int $user_id
     *
     * @return bool
     */
    public function addNewFollower($event_id, $user_id)
    {
        return $this->addNew($event_id, $user_id, 'follower');
    }

    /**
     * Update user status
     *
     * @param int $user_id
     * @param int $event_id
     * @param string $status
     *
     * @return bool
     */
    public function updateStatus($user_id, $event_id, $status)
    {
        return (self::where('user_id', (int) $user_id)->where('event_id', (int) $event_id)->update([
            'status'                => $status,
            'status_change_date'    => \DB::raw('CURRENT_TIMESTAMP')
        ]) == 1) ? true : false;
    }

    /**
     * Delete user from event
     *
     * @param int $event_id
     * @param int $user_id
     *
     * @return bool
     */
    public function deleteUserFromEvent($event_id, $user_id)
    {
        return (self::where('user_id', (int) $user_id)->where('event_id', (int) $event_id)->delete() == 1);
    }
}