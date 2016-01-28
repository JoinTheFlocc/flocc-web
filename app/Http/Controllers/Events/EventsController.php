<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Events\Events;
use Flocc\Events\Search;
use Flocc\Http\Controllers\Controller;

/**
 * Class EventsController
 *
 * @package Flocc\Http\Controllers\Events
 */
class EventsController extends Controller
{
    /**
     * Events list
     *
     * @param string|array $filters
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($filters = [])
    {
        $search     = new Search();

        $action     = 'all';
        $user_id    = (int) \Auth::user()->id;

        if(!empty($filters)) {
            $filters    = explode(',', $filters);
            $action     = $filters[0];
        }

        /**
         * Inject filters to model
         */
        $search->setFilters($filters);

        switch($action) {
            case 'user':
                $events = $search->getByUserId();
                break;
            default:
                $events = $search->getAll();
        }

        return view('events.index', compact('events', 'user_id'));
    }

    /**
     * Create new event
     *
     * @return mixed
     */
    public function newEvent()
    {
        $events     = new Events();

        $user_id    = (int) \Auth::user()->id;
        $draft      = $events->getUserDraft($user_id);

        if($draft === null) {
            $draft = $events->createDraft($user_id);
        }

        return \Redirect::to('events/edit/' . $draft->getId());
    }
}