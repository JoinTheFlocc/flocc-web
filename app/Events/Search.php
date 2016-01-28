<?php

namespace Flocc\Events;

/**
 * Class Search
 *
 * @package Flocc\Events
 */
class Search
{
    private $filters = [];
    private $on_page = 10;

    /**
     * Set filters
     *
     * @param array $filters
     *
     * @return $this
     */
    public function setFilters(array $filters)
    {
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
        return isset($this->filters[(int) $i]) ? $this->filters[(int) $i] : $default;
    }

    /**
     * Get by user ID
     *
     * @throws \Exception
     *
     * @return \Flocc\Events\Events
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
     * @return \Flocc\Events\Events
     */
    public function getAll()
    {
        return Events::where('status', '<>', 'draft')
            ->orderBy('created_at', 'desc')
        ->paginate($this->on_page);
    }
}