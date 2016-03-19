<?php

namespace Flocc\Events;

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
        $query      = $query->leftjoin('events_activities', 'events.id', '=', 'events_activities.event_id');

        if($this->getParam('place_id') !== null) {
            $query = $query->leftjoin('events_routes', function ($join) {
                $join->on('events.id', '=', 'events_routes.event_id');
                $join->on('events_routes.place_id', '=', \DB::raw($this->getParam('place_id')));
            });
        }

        $query = $query->where('status', 'open');

        if ($this->getParam('activity_id') !== null) {
            $query = $query->where('activity_id', (int) $this->getParam('activity_id'));
        }

        if ($this->getParam('place_id') !== null) {
            $query = $query->where(function($query) {
                $query->where('events.place_id', '=', $this->getParam('place_id'));
                $query->orWhere('events_routes.place_id', '=', $this->getParam('place_id'));
            });
        }

        $query = $query->orderBy(\DB::raw($this->getScoringFunction()), 'desc');
        $query = $query->groupBy('events.id');
        
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
        $event_from     = ($this->getParam('event_from') === null) ? date('Y') . '-01-01' : $this->getParam('event_from');
        $event_to       = ($this->getParam('event_to') === null) ? date('Y') . '-12-31' : $this->getParam('event_to');
        $event_span     = ((int) $this->getParam('event_span') === 0) ? 4 : (int) $this->getParam('event_span');

        return sprintf(
            'eventScore("%s", "%s", %d, events.event_from, events.event_to, events.event_span)',
            $event_from,
            $event_to,
            $event_span
        );
    }
}