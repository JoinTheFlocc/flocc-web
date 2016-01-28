<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Events\Events;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('events.index');
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