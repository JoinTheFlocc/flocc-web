<?php

namespace Flocc\Events;

use Flocc\Url;
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

        /**
         * Set slug
         */
        $this->setSlug((new Url())->slug($title));

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
     * Set slug
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
     * Set event start date
     *
     * @param string|null $event_from
     *
     * @return $this
     */
    public function setEventFrom($event_from)
    {
        $this->event_from = $event_from;

        return $this;
    }

    /**
     * Get event start date
     *
     * @return string|null
     */
    public function getEventFrom()
    {
        return $this->event_from;
    }

    /**
     * Set event finish date
     *
     * @param string|null $event_to
     *
     * @return $this
     */
    public function setEventTo($event_to)
    {
        $this->event_to = $event_to;

        return $this;
    }

    /**
     * Get event finish date
     *
     * @return string|null
     */
    public function getEventTo()
    {
        return $this->event_to;
    }

    /**
     * set event span
     *
     * @param null|event $event_span
     *
     * @return $this
     */
    public function setEventSpan($event_span)
    {
        $this->event_span = ($event_span === null) ? null : (int) $event_span;

        return $this;
    }

    /**
     * Get event span
     *
     * @return int|null
     */
    public function getEventSpan()
    {
        return ($this->event_span === null) ? null : (int) $this->event_span;
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
     * Set fixed as true
     *
     * @return $this
     */
    public function setAsFixed()
    {
        $this->fixed = '1';

        return $this;
    }

    /**
     * Set fixed as false
     *
     * @return $this
     */
    public function setAsNonFixed()
    {
        $this->fixed = '0';

        return $this;
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
     * Set status as draft
     *
     * @return $this
     */
    public function setStatusDraft()
    {
        $this->status = 'draft';

        return $this;
    }

    /**
     * Is status draft
     *
     * @return bool
     */
    public function isStatusDraft()
    {
        return ($this->status == 'draft');
    }

    /**
     * Set status as open
     *
     * @return $this
     */
    public function setStatusOpen()
    {
        $this->status = 'open';

        return $this;
    }

    /**
     * Is status open
     *
     * @return bool
     */
    public function isStatusOpen()
    {
        return ($this->status == 'open');
    }

    /**
     * Set status as private
     *
     * @return $this
     */
    public function setStatusPrivate()
    {
        $this->status = 'private';

        return $this;
    }

    /**
     * Is status private
     *
     * @return bool
     */
    public function isStatusPrivate()
    {
        return ($this->status == 'private');
    }

    /**
     * Set status as canceled
     *
     * @return $this
     */
    public function setStatusCanceled()
    {
        $this->status = 'canceled';

        return $this;
    }

    /**
     * Set status as close
     *
     * @return $this
     */
    public function setStatusClose()
    {
        $this->status = 'close';

        return $this;
    }

    /**
     * Is status close
     *
     * @return bool
     */
    public function isStatusClose()
    {
        return ($this->status == 'close');
    }

    /**
     * Is status canceled
     *
     * @return bool
     */
    public function isStatusCanceled()
    {
        return ($this->status == 'canceled');
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
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
     * Set place ID
     *
     * @param int|null $place_id
     *
     * @return $this
     */
    public function setPlaceId($place_id)
    {
        $this->place_id = $place_id;

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
     * User check place?
     *
     * @return bool
     */
    public function isPlace()
    {
        return ($this->place_id === null) ? false : true;
    }

    /**
     * Set budget ID
     *
     * @param int $budget_id
     *
     * @return $this
     */
    public function setBudgetId($budget_id)
    {
        $this->budget_id = (int) $budget_id;

        return $this;
    }

    /**
     * Get budget ID
     *
     * @return int
     */
    public function getBudgetId()
    {
        return (int) $this->budget_id;
    }

    /**
     * Set intensities ID
     *
     * @param int $intensities_id
     *
     * @return $this
     */
    public function setIntensitiesId($intensities_id)
    {
        $this->intensities_id = (int) $intensities_id;

        return $this;
    }

    /**
     * Get intensities ID
     *
     * @return int
     */
    public function getIntensitiesId()
    {
        return (int) $this->intensities_id;
    }

    /**
     * Get budget
     *
     * @return \Flocc\Budgets
     */
    public function getBudget()
    {
        return $this->hasOne('Flocc\Budgets', 'id', 'budget_id')->first();
    }

    /**
     * Get intensities
     *
     * @return \Flocc\Intensities
     */
    public function getIntensity()
    {
        return $this->hasOne('Flocc\Intensities', 'id', 'intensities_id')->first();
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
     * Get routes
     *
     * @return \Flocc\Places
     */
    public function getRoutes()
    {
        return $this->hasOne('Flocc\Events\Routes', 'event_id', 'id')
            ->join('places', 'places.id', '=', 'events_routes.place_id')
        ->get();
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
     * Is activity is checked
     *
     * @param int $id
     *
     * @return bool
     */
    public function isActivity($id)
    {
        foreach($this->getActivities() as $activity) {
            if($activity->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get awaiting request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAwaitingRequests()
    {
        return $this->hasMany('Flocc\Events\Members', 'event_id', 'id')->where('status', 'awaiting')->get();
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
     * Get rejected request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRejectedRequests()
    {
        return $this->hasMany('Flocc\Events\Members', 'event_id', 'id')->where('status', 'rejected')->get();
    }

    /**
     * I'm the owner?
     *
     * @return bool
     */
    public function isMine()
    {
        $user_id = null;

        if(\Auth::user() !== null) {
            $user_id = \Auth::user()->id;
        }

        return ($user_id == $this->getUserId());
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
     * @param bool $allow_draft
     *
     * @return \Flocc\Events\Events
     */
    public function getById($id, $allow_draft = false)
    {
        $get = self::where('id', (int) $id);

        if($allow_draft === false) {
            $get = $get->where('status', '<>', 'draft');
        }

        $get = $get->take(1)->first();

        return $get;
    }

    /**
     * Get event by slug
     *
     * @param string $slug
     * @param bool $allow_draft
     *
     * @return \Flocc\Events\Events
     */
    public function getBySlug($slug, $allow_draft = false)
    {
        $get = self::where('slug', $slug);

        if($allow_draft === false) {
            $get = $get->where('status', '<>', 'draft');
        }

        $get = $get->take(1)->first();

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

    /**
     * Get user draft
     *
     * @param int $user_id
     *
     * @return \Flocc\Events\Events
     */
    public function getUserDraft($user_id)
    {
        return self::where('user_id', $user_id)->where('status', 'draft')->take(1)->first();
    }

    /**
     * Create new draft
     *
     * @param int $user_id
     *
     * @return \Flocc\Events\Events
     */
    public function createDraft($user_id)
    {
        self::create(['user_id' => $user_id]);

        return $this->getUserDraft($user_id);
    }

    /**
     * Close event
     *
     * @param int $id
     *
     * @return bool
     */
    public function closeEvent($id)
    {
        return (self::where('id', $id)->update(['status' => 'close']) == 1);
    }
}