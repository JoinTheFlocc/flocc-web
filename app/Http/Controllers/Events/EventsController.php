<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Budgets;
use Flocc\Activities;
use Flocc\Events\Events;
use Flocc\Events\Search;
use Flocc\Http\Controllers\Controller;
use Flocc\Infrastructure;
use Flocc\Intensities;
use Flocc\Tourist;
use Flocc\TravelWays;
use Flocc\Tribes;

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
     * @param \Illuminate\Http\Request $request
     * @param string|array $filters
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Illuminate\Http\Request $request, $filters = [])
    {
        $search         = new Search();

        $action         = 'all';
        $user_id        = \Flocc\Auth::getUserId();
        $form_data      = [];
        $search_form    = false;

        if(!empty($filters)) {
            $filters    = explode(',', $filters);
            $action     = $filters[0];
        }

        /**
         * Search criteria
         */
        if($request->isMethod('post')) {
            $post = $request->all();

            unset($post['_token']);

            return \Redirect::to('/search/by,' . base64_encode(serialize(array_filter($post, function($value) {
                return !empty($value);
            }))));
        }

        $activities     = (new Activities())->get();
        $tribes         = (new Tribes())->get();
        $intensities    = (new Intensities())->get();
        $travel_ways    = (new TravelWays())->get();
        $infrastructure = (new Infrastructure())->get();
        $tourist        = (new Tourist())->get();
        $budgets        = (new Budgets())->get();

        if($action == 'all') {
            return view('events.search.form', compact('activities', 'tribes'));
        } else {
            /**
             * Inject filters to model
             */
            $search->setFilters($filters);

            switch($action) {
                // Wydarzenia użytkownika
                case Search::TYPE_USER:
                    $events         = $search->getByUserId();
                    break;

                // Wydarzenia w których bierze udział
                case Search::TYPE_MEMBER:
                    $events         = $search->getByMemberId(['member', 'awaiting']);
                    break;

                // Wydarzenia, które obserwuje
                case Search::TYPE_FOLLOWER:
                    $events         = $search->getByMemberId('follower');
                    break;

                // Filtrowanie wiadomości
                case Search::TYPE_SEARCH:
                    $form_data      = unserialize(base64_decode($filters[1]));
                    $events         = $search->search();
                    $search_form    = true;
                    break;
            }

            return view('events.search.results', compact('events', 'user_id', 'activities', 'places', 'form_data', 'search_form', 'tribes', 'intensities', 'travel_ways', 'infrastructure', 'tourist', 'budgets'));
        }
    }

    /**
     * Create new event
     *
     * @param null|int $id
     *
     * @return mixed
     */
    public function newEvent($id = null)
    {
        $events     = new Events();

        $user_id    = \Flocc\Auth::getUserId();
        $draft      = $events->getUserDraft($user_id);

        if($draft !== null) {
            $draft->delete();
        }

        if($id !== null) {
            $event                  = $events->getById((int) $id);
            $event_data             = json_decode(json_encode($event), true);

            unset($event_data['id'], $event_data['views'], $event_data['status'], $event_data['is_inspiration'], $event_data['user_id']);

            $event_data['user_id']  = $user_id;
            $draft                  = $events->createFilledDraft($event_data);

            /**
             * Add activities
             */
            foreach($event->getActivities() as $activity) {
                (new \Flocc\Events\Activities())
                    ->setEventId($draft->getId())
                    ->setActivityId($activity->getId())
                    ->save();
            }
        } else {
            $draft = $events->createDraft($user_id);
        }

        return \Redirect::to('events/edit/' . $draft->getId());
    }

    /**
     * New inspiration
     *
     * @return mixed
     */
    public function newInspirationEvent()
    {
        $events     = new Events();

        $user_id    = \Flocc\Auth::getUserId();
        $draft      = $events->getUserDraft($user_id, true);

        if($draft !== null) {
            $draft->delete();
        }

        $draft = $events->createDraft($user_id, true);

        return \Redirect::to('events/edit/' . $draft->getId());
    }
}