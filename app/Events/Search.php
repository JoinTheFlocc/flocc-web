<?php

namespace Flocc\Events;

use Flocc\Auth;
use Flocc\Tribes;

/**
 * Class Search
 *
 * @package Flocc\Events
 */
class Search
{
    // Typy wyszukiwań
    const TYPE_USER         = 'user';
    const TYPE_MEMBER       = 'member';
    const TYPE_FOLLOWER     = 'follower';
    const TYPE_SEARCH       = 'by';

    private $filters        = [];
    private $on_page        = 10;

    /**
     * Set filters
     *
     * @param array $filters
     *
     * @return $this
     */
    public function setFilters(array $filters)
    {
        if(isset($filters[0])) {
            if($filters[0] == 'by') {
                $filters = array_merge($filters, unserialize(base64_decode($filters[1])));
            }
        }

        $this->filters = $filters;

        return $this;
    }

    /**
     * Set param
     *
     * @param int|string $i
     * @param int|string $value
     *
     * @return $this
     */
    public function setParam($i, $value)
    {
        $this->filters[$i] = $value;

        return $this;
    }

    /**
     * Get param
     *
     * @param int $i
     * @param null|mixed $default
     *
     * @return null|mixed
     */
    public function getParam($i, $default = null)
    {
        return isset($this->filters[$i]) ? $this->filters[$i] : $default;
    }

    /**
     * Get by user ID
     *
     * @throws \Exception
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getByUserId()
    {
        $user_id = $this->getParam(1);

        if($user_id === null) {
            throw new \Exception('Empty user ID');
        }

        /**
         * Display my events
         */
        if($user_id == 'my') {
            $user_id = (int) \Auth::user()->id;
        }

        return Events::where('status', '<>', 'draft')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
        ->paginate($this->on_page);
    }

    /**
     * Get all events
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Events::where('status', '<>', 'draft')
            ->orderBy('created_at', 'desc')
        ->paginate($this->on_page);
    }

    /**
     * Get all events with criterias
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function search()
    {
        $query      = Events::select('events.*', \DB::raw($this->getScoringFunction() . ' as scoring'));
        $query      = $query->leftjoin('events_scoring', 'events.id', '=', 'events_scoring.event_id');

        $query      = $query->where('status', 'open');
        $query      = $query->where('is_inspiration', '0');

        if(Auth::getUserId() !== null) {
            $query  = $query->where('user_id', '<>', Auth::getUserId());
        }

        $query      = $query->orderBy(\DB::raw($this->getScoringFunction()), 'desc');
        $query      = $query->groupBy('events.id');
        
        return $query->paginate($this->on_page);
    }

    /**
     * Get member and follower events
     *
     * @param string|array $status
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     *
     * @throws \Exception
     */
    public function getByMemberId($status)
    {
        $user_id = $this->getParam(1);

        if($user_id === null) {
            throw new \Exception('Empty user ID');
        }

        /**
         * Display my events
         */
        if($user_id == 'my') {
            $user_id = (int) \Auth::user()->id;
        }

        $get_events_ids = Members::where('user_id', $user_id);

        if(is_array($status)) {
            $get_events_ids = $get_events_ids->whereIn('status', $status);
        } else {
            $get_events_ids = $get_events_ids->where('status', $status);
        }

        $get_events_ids     = $get_events_ids->get();
        $ids                = [];

        foreach($get_events_ids as $event) {
            $ids[] = $event->getEventId();
        }

        return Events::where('status', '<>', 'draft')
            ->whereIn('id', $ids)
            ->orderBy('created_at', 'desc')
        ->paginate($this->on_page);
    }

    /**
     * Get scoring function SQL
     *
     * @return string
     */
    private function getScoringFunction()
    {
        $event_from             = ($this->getParam('event_from') === null) ? date('Y-m-d') : $this->getParam('event_from');
        $event_to               = ($this->getParam('event_to') === null) ? date('Y') . '-12-31' : $this->getParam('event_to');
        $event_span             = ((int) $this->getParam('event_span') === 0) ? 4 : (int) $this->getParam('event_span');
        $u_activity_id          = $this->getParam('activity_id', 'NULL');
        $u_tribes               = $this->getTribes();
        $u_place                = $this->getParam('place', 'NULL');
        $u_voluntary            = ($this->getParam('voluntary') !== null) ? '1' : 'NULL';
        $u_language_learning    = ($this->getParam('language_learning') !== null) ? '1' : 'NULL';
        $u_budget               = $this->getParam('budget_id', 'NULL');
        $u_intensity            = $this->getParam('intensities_id', 'NULL');
        $u_travel_ways          = $this->getParam('travel_ways_id', 'NULL');
        $u_infrastructure       = $this->getParam('infrastructure_id', 'NULL');
        $u_tourist              = $this->getParam('tourist_id', 'NULL');

        if($u_tribes != 'NULL') {
            $u_tribes = '"' . $u_tribes . '"';
        }

        if($u_place != 'NULL') {
            $u_place = '"' . $u_place . '"';
        }

        return sprintf(
            'eventScore("%s", "%s", %d, events.event_from, events.event_to, events.event_span, %s, events_scoring.activity_id, %s, events_scoring.tribes, %s, events_scoring.place, events_scoring.route, %s, events.voluntary, %s, events.language_learning, %s, events.budget_id, %s, events.intensities_id, %s, events.travel_ways_id, %s, events.infrastructure_id, %s, events.tourist_id)',
            $event_from,
            $event_to,
            $event_span,
            $u_activity_id,
            $u_tribes,
            $u_place,
            $u_voluntary,
            $u_language_learning,
            $u_budget,
            $u_intensity,
            $u_travel_ways,
            $u_infrastructure,
            $u_tourist
        );
    }

    /**
     * Get tribes like binary
     *
     * @return array|string
     */
    private function getTribes()
    {
        $all_tribes = Tribes::get();
        $tribes     = [];
        $tmp        = [];

        foreach($this->getParam('tribes', []) as $tribe) {
            $tmp[(int) $tribe] = (int) $tribe;
        }

        foreach($all_tribes as $tribe) {
            $tribes[] = isset($tmp[$tribe->getId()]) ? 1 : 0;
        }

        return (count($tribes) > 0 ) ? implode('', $tribes) : 'NULL';
    }
}