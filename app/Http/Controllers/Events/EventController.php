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
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $events = new Events();
        $event  = $events->getById($id);

        if($event === null) {
            die; // @TODO:
        }

        return view('events.event.index', [
            'event' => $event
        ]);
    }
}