<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Events\Events;
use Flocc\Http\Controllers\Controller;

/**
 * Class EventController
 *
 * @package Flocc\Http\Controllers\Events
 */
class EventController extends Controller
{
    /**
     * Display event
     *
     * @param int $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($slug)
    {
        $events = new Events();
        $event  = $events->getBySlug($slug);

        if($event === null) {
            die; // @TODO:
        }

        return view('events.event.index', [
            'event' => $event
        ]);
    }
}