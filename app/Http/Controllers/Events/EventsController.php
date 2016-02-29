<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Activities;
use Flocc\Events\Events;
use Flocc\Events\Search;
use Flocc\Http\Controllers\Controller;
use Flocc\Places;

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

        /**
         * Inject filters to model
         */
        $search->setFilters($filters);

        switch($action) {
            // Wydarzenia użytkownika
            case 'user':
                $events = $search->getByUserId();
                break;

            // Wydarzenia w których bierze udział
            case 'member':
                $events = $search->getByMemberId(['member', 'awaiting']);
                break;

            // Wydarzenia, które obserwuje
            case 'follower':
                $events = $search->getByMemberId('follower');
                break;

            // Filtrowanie wiadomości
            case 'by':
                $form_data      = unserialize(base64_decode($filters[1]));
                $events         = $search->search();
                $search_form    = true;
                break;

            // Wszystkie wydarzenia
            default:
                $events         = $search->getAll();
                $search_form    = true;
        }

        $activities = (new Activities())->get();
        $places     = (new Places())->get();

        return view('events.index', compact('events', 'user_id', 'activities', 'places', 'form_data', 'search_form'));
    }

    /**
     * Create new event
     *
     * @return mixed
     */
    public function newEvent()
    {
        $events     = new Events();

        $user_id    = \Flocc\Auth::getUserId();
        $draft      = $events->getUserDraft($user_id);

        if($draft === null) {
            $draft = $events->createDraft($user_id);
        }

        return \Redirect::to('events/edit/' . $draft->getId());
    }
}