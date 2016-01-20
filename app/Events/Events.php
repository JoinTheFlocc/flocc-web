<?php

namespace Flocc\Events;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Events
 *
 * @package Flocc\Events
 */
class Events extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'created_at', 'title', 'description', 'date_from', 'date_to', 'duration', 'views', 'photo', 'users_limit', 'place_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set event ID
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
     * Get event ID
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
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
     * Set created date
     *
     * @param string $created_at
     *
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get created date
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set event title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get event title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get event description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date from
     *
     * @param string $date_from
     *
     * @return $this
     */
    public function setDateFrom($date_from)
    {
        $this->date_from = $date_from;

        return $this;
    }

    /**
     * Get date from
     *
     * @return string
     */
    public function getDateFrom()
    {
        return $this->date_from;
    }

    /**
     * Set date to
     *
     * @param string $date_to
     *
     * @return $this
     */
    public function setDateTo($date_to)
    {
        $this->date_to = $date_to;

        return $this;
    }

    /**
     * Get date to
     *
     * @return string
     */
    public function getDateTo()
    {
        return $this->date_to;
    }

    /**
     * Set event duration days
     *
     * @param int $duration
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = (int) $duration;

        return $this;
    }

    /**
     * Get event duration days
     *
     * @return int
     */
    public function getDuration()
    {
        return (int) $this->duration;
    }

    /**
     * Set event views sum
     *
     * @param int $views
     *
     * @return $this
     */
    public function setViews($views)
    {
        $this->views = (int) $views;

        return $this;
    }

    /**
     * Get event views sum
     *
     * @return int
     */
    public function getViews()
    {
        return (int) $this->views;
    }

    /**
     * Get photo URL
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatar_url;
    }

    /**
     * Is fixed?
     *
     * @return bool
     */
    public function isFixed()
    {
        return ($this->fixed == '1') ? true : false;
    }

    /**
     * Set members limit
     *
     * @param int $users_limit
     *
     * @return $this
     */
    public function setUsersLimit($users_limit)
    {
        $this->users_limit = (int) $users_limit;

        return $this;
    }

    /**
     * Get members limit
     *
     * @return int
     */
    public function getUsersLimit()
    {
        return (int) $this->users_limit;
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

    /**
     * Get user owner
     *
     * @return \Flocc\User
     */
    public function getOwner()
    {
        return $this->hasOne('Flocc\User', 'id', 'user_id')->first();
    }

    /**
     * Get event place
     *
     * @return \Flocc\Places
     */
    public function getPlace()
    {
        return $this->hasOne('Flocc\Places', 'id', 'place_id')->first();
    }

    /**
     * Get event activities
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivities()
    {
        return $this->hasMany('Flocc\Events\Activities', 'event_id', 'id')->join('activities', 'activities.id', '=', 'events_activities.activity_id')->get();
    }

    /**
     * Get event members
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMembers()
    {
        return $this->hasMany('Flocc\Events\Members', 'event_id', 'id')->where('status', 'member')->get();
    }

    /**
     * Get event followers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFollowers()
    {
        return $this->hasMany('Flocc\Events\Members', 'event_id', 'id')->where('status', 'follower')->get();
    }

    /**
     * Get event time line
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTimeLine()
    {
        return (new TimeLine())->getByEventId($this->id);
    }

    /**
     * Get event by ID
     *
     * @param int $id
     *
     * @return \Flocc\Events\Events
     */
    public function getById($id)
    {
        $get = self::where('id', (int) $id)->take(1)->first();

        if($get !== null) {
            $this->updateViews($get->getId(), $get->getViews()+1);
        }

        return $get;
    }

    /**
     * Get event by slug
     *
     * @param string $slug
     *
     * @return \Flocc\Events\Events
     */
    public function getBySlug($slug)
    {
        $get = self::where('slug', $slug)->take(1)->first();

        if($get !== null) {
            $this->updateViews($get->getId(), $get->getViews()+1);
        }

        return $get;
    }

    /**
     * Uodate views sum
     *
     * @param int $id
     * @param int $views
     *
     * @return bool
     */
    public function updateViews($id, $views)
    {
        return (self::where('id', $id)->update(['views' => (int) $views]) == 1);
    }
}