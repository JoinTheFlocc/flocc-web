<?php

namespace Flocc\Events;

use Flocc\Auth;
use Flocc\Helpers\DateHelper;
use Flocc\Notifications\NewNotification;
use Flocc\Url;
use Flocc\User;
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
    protected $fillable = ['id', 'user_id', 'created_at', 'title', 'slug', 'description', 'event_from', 'event_to', 'event_span', 'views', 'avatar_url', 'users_limit', 'fixed', 'status', 'place_id', 'budget_id', 'intensities_id', 'travel_ways_id', 'infrastructure_id', 'tourist_id', 'voluntary', 'language_learning', 'is_inspiration', 'event_month', 'last_update_time', 'planning_id'];

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
     * Set photo URL
     *
     * @param string $url
     *
     * @return $this
     */
    public function setAvatarUrl($url)
    {
        $this->avatar_url = $url;

        return $this;
    }

    /**
     * Get photo URL
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return ($this->avatar_url === null) ? config('events.default_avatar') : $this->avatar_url;
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
     * Return owner, members and followers ID's
     *
     * @return array
     */
    public function getMembersAndFollowersIds()
    {
        $ids = [];

        foreach($this->getMembers() as $member) {
            $ids[$member->getUserId()] = 'member';
        }

        foreach($this->getFollowers() as $member) {
            $ids[$member->getUserId()] = 'follower';
        }

        return $ids;
    }

    /**
     * Get members and folowers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMembersAndFollowers()
    {
        return $this->hasMany('Flocc\Events\Members', 'event_id', 'id')->whereIn('status', ['member', 'follower', 'awaiting'])->get();
    }

    /**
     * Get event followers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFollowers()
    {
        return $this->hasMany('Flocc\Events\Members', 'event_id', 'id')->whereIn('status', ['follower', 'awaiting'])->get();
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
     * Get member by user ID
     *
     * @return \Flocc\Events\Members
     */
    public function getMember()
    {
        return $this->hasMany('Flocc\Events\Members', 'event_id', 'id')->where('user_id', Auth::getUserId())->take(1)->first();
    }

    /**
     * I'm the owner?
     *
     * @return bool
     */
    public function isMine()
    {
        return (Auth::getUserId() == $this->getUserId());
    }

    /**
     * Czy jestem w tym wydarzeniu
     *
     * @param bool $only_accept
     *
     * @return bool
     */
    public function isImIn($only_accept = false)
    {
        foreach($this->getMembers() as $user) {
            if ($user->getUserId() == Auth::getUserId()) {
                return true;
            }
        }

        if($only_accept !== false) {
            foreach($this->getAwaitingRequests() as $user) {
                if($user->getUserId() == Auth::getUserId()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Czy obserwuje to wydarzenie
     *
     * @return bool
     */
    public function isIFollow()
    {
        foreach($this->getFollowers() as $user) {
            if($user->getUserId() == Auth::getUserId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Czy jestem odrzucony
     *
     * @return bool
     */
    public function isImRejected()
    {
        foreach($this->getRejectedRequests() as $user) {
            if($user->getUserId() == Auth::getUserId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Can I join to event
     *
     * @return bool
     */
    public function canJoin()
    {
        if(Auth::getUserId() === null) {
            return false;
        }

        if($this->isMine()) {
            return false;
        }

        if($this->isStatusOpen() === false) {
            return false;
        }

        if($this->isImIn()) {
            return false;
        }

        if($this->getMembers()->count() >= $this->getUsersLimit()) {
            return false;
        }

        if($this->isImRejected()) {
            return false;
        }

        return true;
    }

    /**
     * Can I follow event
     *
     * @return bool
     */
    public function canFollow()
    {
        if($this->isMine()) {
            return false;
        }

        if($this->isStatusOpen() === false and $this->isStatusClose() === false) {
            return false;
        }

        if($this->isIFollow()) {
            return false;
        }

        if($this->isImIn()) {
            return false;
        }

        if($this->isImRejected()) {
            return false;
        }

        return true;
    }

    /**
     * Can I un follow
     *
     * @return bool
     */
    public function canUnFollow()
    {
        if($this->isIFollow()) {
            return true;
        }

        return false;
    }

    /**
     * Can i resign
     *
     * @return bool
     */
    public function canUnJoin()
    {
        foreach($this->getMembers() as $user) {
            if ($user->getUserId() == Auth::getUserId()) {
                return true;
            }
        }

        return false;
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
     * Get comments
     *
     * @return \Flocc\Events\Comments
     */
    public function getComments()
    {
        return (new Comments())->getByEventId($this->id, 'private');
    }

    /**
     * Get tribes
     *
     * @return \Flocc\Events\Tribes
     */
    public function getTribes()
    {
        return $this->hasMany('Flocc\Events\Tribes', 'event_id', 'id')->select('tribes.id', 'tribes.name')->join('tribes', 'tribes.id', '=', 'events_tribes.tribe_id')->get();
    }

    /**
     * Is tribe checked
     *
     * @param int $tribe_id
     * 
     * @return bool
     */
    public function isTribe($tribe_id)
    {
        foreach($this->getTribes() as $tribe) {
            if((int) $tribe_id === $tribe->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get travel ways ID
     *
     * @return null|int
     */
    public function getTravelWaysId()
    {
        return $this->travel_ways_id;
    }

    /**
     * Get infrastructure ID
     *
     * @return null|int
     */
    public function getInfrastructureId()
    {
        return $this->infrastructure_id;
    }

    /**
     * Get tourist ID
     *
     * @return null|int
     */
    public function getTouristId()
    {
        return $this->tourist_id;
    }

    /**
     * Get planning ID
     *
     * @return null|int
     */
    public function getPlanningId()
    {
        return $this->planning_id;
    }

    /**
     * Get plannings
     *
     * @return null|\Flocc\Plannings
     */
    public function getPlanning()
    {
        return $this->hasOne('Flocc\Plannings', 'id', 'planning_id')->first();
    }

    /**
     * Get travel ways
     *
     * @return \Flocc\TravelWays
     */
    public function getTravelWays()
    {
        return $this->hasOne('Flocc\TravelWays', 'id', 'travel_ways_id')->first();
    }

    /**
     * Get infrastructure
     *
     * @return \Flocc\Infrastructure
     */
    public function getInfrastructure()
    {
        return $this->hasOne('Flocc\Infrastructure', 'id', 'infrastructure_id')->first();
    }

    /**
     * Get tourist
     *
     * @return \Flocc\Tourist
     */
    public function getTourist()
    {
        return $this->hasOne('Flocc\Tourist', 'id', 'tourist_id')->first();
    }

    /**
     * Is voluntary
     *
     * @return bool
     */
    public function isVoluntary()
    {
        return ($this->voluntary == '1');
    }

    /**
     * Is language learning
     *
     * @return bool
     */
    public function isLanguageLearning()
    {
        return ($this->language_learning == '1');
    }

    /**
     * Is inspiration
     *
     * @return bool
     */
    public function isInspiration()
    {
        return ($this->is_inspiration == '1');
    }

    /**
     * Set travel ways ID
     *
     * @param int $travel_ways_id
     *
     * @return $this
     */
    public function setTravelWaysId($travel_ways_id)
    {
        $this->travel_ways_id = (int) $travel_ways_id;

        return $this;
    }

    /**
     * Set infrastructure ID
     *
     * @param int $infrastructure_id
     *
     * @return $this
     */
    public function setInfrastructureId($infrastructure_id)
    {
        $this->infrastructure_id = (int) $infrastructure_id;

        return $this;
    }

    /**
     * Set tourist ID
     *
     * @param int $tourist_id
     *
     * @return $this
     */
    public function setTouristId($tourist_id)
    {
        $this->tourist_id = (int) $tourist_id;

        return $this;
    }

    /**
     * Set planning ID
     *
     * @param int $planning_id
     *
     * @return $this
     */
    public function setPlanningId($planning_id)
    {
        $this->planning_id = (int) $planning_id;

        return $this;
    }

    /**
     * Set voluntary sa true
     *
     * @return $this
     */
    public function setVoluntaryAsTrue()
    {
        $this->voluntary = '1';

        return $this;
    }

    /**
     * Set voluntary sa false
     *
     * @return $this
     */
    public function setVoluntaryAsFalse()
    {
        $this->voluntary = '0';

        return $this;
    }

    /**
     * Set language learning as true
     *
     * @return $this
     */
    public function setLanguageLearningAsTrue()
    {
        $this->language_learning = '1';

        return $this;
    }

    /**
     * Set language learning as false
     *
     * @return $this
     */
    public function setLanguageLearningAsFalse()
    {
        $this->language_learning = '0';

        return $this;
    }

    /**
     * Set event month
     *
     * @param string|null $event_month
     *
     * @return $this
     */
    public function setEventMonth($event_month)
    {
        $this->event_month = $event_month;

        return $this;
    }

    /**
     * Get event month
     *
     * @return null|int
     */
    public function getEventMonth()
    {
        return ($this->event_month === null) ? null : (int) $this->event_month;
    }

    /**
     * Get event month name
     *
     * @return string|null
     */
    public function getEventMonthName()
    {
        return ($this->event_month === null) ? null : (new DateHelper())->getMonths($this->event_month);
    }

    /**
     * Set last update time
     *
     * @param int $last_update_time
     *
     * @return $this
     */
    public function setLastUpdateTime($last_update_time)
    {
        $this->last_update_time = (int) $last_update_time;

        return $this;
    }

    /**
     * Get last update time
     *
     * @return int
     */
    public function getLastUpdateTime()
    {
        return (int) $this->last_update_time;
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
     * @param bool $inspiration
     *
     * @return \Flocc\Events\Events
     */
    public function getUserDraft($user_id, $inspiration = false)
    {
        $find = self::where('user_id', $user_id)->where('status', 'draft');

        if($inspiration === true) {
            $find = $find->where('is_inspiration', '1');
        }

        return $find->take(1)->first();
    }

    /**
     * Create new draft
     *
     * @param int $user_id
     * @param bool $inspiration
     *
     * @return \Flocc\Events\Events
     */
    public function createDraft($user_id, $inspiration = false)
    {
        $data = ['user_id' => $user_id];

        if($inspiration === true) {
            $data['is_inspiration'] = '1';
        }

        self::create($data);

        $event = $this->getUserDraft($user_id, $inspiration);

        /**
         * Create events_scoring
         */
        Scoring::create(['event_id' => $event->getId()]);

        return $event;
    }

    /**
     * Create draft from data
     *
     * @param array $data
     * 
     * @return Events
     */
    public function createFilledDraft(array $data)
    {
        self::create($data);

        $event = $this->getUserDraft($data['user_id']);

        /**
         * Create events_scoring
         */
        Scoring::create(['event_id' => $event->getId()]);

        return $event;
    }

    /**
     * Open event
     *
     * @param int $id
     *
     * @return bool
     */
    public function openEvent($id)
    {
        return (self::where('id', $id)->update(['status' => 'open']) == 1);
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

    /**
     * Close events by date to
     *
     * @param string|null $date
     *
     * @return bool
     */
    public function closeAfterDate($date = null)
    {
        if($date === null) {
            $date = date('Y-m-d');
        }

        self::where('event_to', '>', $date)->update(['status' => 'close']);

        return true;
    }

    /**
     * Get events starting from today
     *
     * @return \Flocc\Events\Events
     */
    public function getEventsStartingToday()
    {
        return self::where('event_from', date('Y-m-d'))
            ->where('status', 'open')
        ->get();
    }

    /**
     * Get events ending from today
     *
     * @return \Flocc\Events\Events
     */
    public function getEventsEndingToday()
    {
        return self::where('event_to', date('Y-m-d'))
            ->where('status', 'open')
        ->get();
    }

    /**
     * Send notifications to starting & ending events
     *
     * @return bool
     */
    public function sendStartingAndEndingEventsNotifications()
    {
        /**
         * @var $event \Flocc\Events\Events
         */
        foreach($this->getEventsStartingToday() as $event) {
            /**
             * @var $member \Flocc\Events\Members
             */
            foreach($event->getMembers() as $member) {
                (new NewNotification())
                    ->setUserId($member->getUserId())
                    ->setUniqueKey('events.starting.' . $event->getId())
                    ->setCallback('/events/' . $event->getId() . '/' . $event->getSlug())
                    ->setTypeId('events.starting')
                    ->addVariable('event', $event->getTitle())
                ->save();
            }
        }

        /**
         * @var $event \Flocc\Events\Events
         */
        foreach($this->getEventsEndingToday() as $event) {
            /**
             * @var $member \Flocc\Events\Members
             */
            foreach($event->getMembers() as $member) {
                (new NewNotification())
                    ->setUserId($member->getUserId())
                    ->setUniqueKey('events.ending.' . $event->getId())
                    ->setCallback('/events/' . $event->getId() . '/' . $event->getSlug())
                    ->setTypeId('events.ending')
                    ->addVariable('event', $event->getTitle())
                ->save();
            }
        }

        return true;
    }

    /**
     * Update avatar URL
     *
     * @param int $id
     * @param string $avatar_url
     *
     * @return bool
     */
    public function updateAvatarUrl($id, $avatar_url)
    {
        return (self::where('id', $id)->update(['avatar_url' => $avatar_url]) == 1);
    }

    /**
     * Get latest events
     *
     * @param int $limit
     * @param bool $is_inspiration
     *
     * @return \Flocc\Events\Events
     */
    public function getLatestEvents($limit = 5, $is_inspiration = false)
    {
        return self::where('status', 'open')->where('is_inspiration', ($is_inspiration ? '1' : '0'))->orderBy('created_at', 'desc')->limit($limit)->get();
    }

    /**
     * Get latest updated events
     *
     * @param int $limit
     * @param bool $is_inspiration
     *
     * @return \Flocc\Events\Events
     */
    public function getLatestUpdatedTime($limit = 5, $is_inspiration = false)
    {
        return self::where('status', 'open')->where('is_inspiration', ($is_inspiration ? '1' : '0'))->orderBy('last_update_time', 'desc')->limit($limit)->get();
    }

    /**
     * Get users scoring
     *
     * @param int $user_id
     *
     * @return int
     */
    public function getUsersScoring($user_id)
    {
        $points = $x = 0;

        if($user_id === null) {
            return $points;
        }

        /**
         * @var $user \Flocc\Profile
         */
        $user   = (new User())->getById($user_id)->getProfile();

        /**
         * @var $owner \Flocc\Profile
         */
        $owner  = (new User())->getById($this->getUserId())->getProfile();

        /** X */
        if($user->getPartyingId() !== null)     { ++$x; }
        if($user->getAlcoholId() !== null)      { ++$x; }
        if($user->getSmokingId() !== null)      { ++$x; }
        if($user->getImprecationId() !== null)  { ++$x; }
        if(count($user->getFeaturesIds()) > 0)  { ++$x; }

        /** Imprezowanie */
        $user_partying_id       = $user->getPartyingId();
        $owner_partying_id      = $owner->getPartyingId();

        if($user->getPartyingId() !== null) {
            if($user_partying_id === $owner_partying_id) {
                $points += 1;
            }

            if($user_partying_id-1 === $owner_partying_id or $user_partying_id+1 === $owner_partying_id) {
                $points += 0.5;
            }
        }

        /** Alkohol */
        $user_alcohol_id    = $user->getAlcoholId();
        $owner_alcohol_id   = $owner->getAlcoholId();

        if($user->getAlcoholId() !== null) {
            if($user_alcohol_id === $owner_alcohol_id) {
                $points += 1;

            }
            if($user_alcohol_id-1 === $owner_alcohol_id or $user_alcohol_id+1 === $owner_alcohol_id) {
                $points += 0.5;
            }
        }

        /** Palenie */
        if($user->getSmokingId() !== null) {
            if($user->getSmokingId() === $owner->getSmokingId()) {
                $points += 1;
            }
        }

        /** Przeklinanie */
        if($user->getImprecationId() !== null) {
            if($user->getImprecationId() === $owner->getImprecationId()) {
                $points += 1;
            }
        }

        /** Wegetarianizm */
        if($user->getVegetarianId() !== null) {
            if($user->getVegetarianId() === $owner->getVegetarianId()) {
                $points += 1;
            }
        }

        /** Dzień poza pracą */
        if(count($user->getFeaturesIds()) > 0) {
            $user_features      = $user->getFeaturesIds();
            $owner_features     = $owner->getFeaturesIds();

            foreach($user_features as $user_features_id) {
                if(isset($owner_features[$user_features_id])) {
                    $points += 1/count($user_features);
                }
            }
        }

        if($points < 0) {
            $points = 0;
        }

        if($points > 1) {
            $points = 1;
        }

        if($points > 0) {
            return round(($points/$x)*100);
        }

        return 0;
    }
}