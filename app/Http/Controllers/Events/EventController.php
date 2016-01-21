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

    /**
     * Members and followers list
     *
     * @param string $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function members($slug)      { return $this->users($slug, 'members'); }
    public function followers($slug)    { return $this->users($slug, 'followers'); }

    /**
     * Users list
     *
     * @param string $slug
     * @param string $status
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function users($slug, $status)
    {
        $events = new Events();
        $event  = $events->getBySlug($slug);

        if($event === null) {
            die; // @TODO:
        }

        switch($status) {
            case 'members';     $users = $event->getMembers(); break;
            case 'followers';   $users = $event->getFollowers(); break;
        }

        return view('events.event.users', [
            'event' => $event,
            'users' => $users
        ]);
    }

    /**
     * Close event
     *
     * @param string $slug
     *
     * @return mixed
     */
    public function cancel($slug)
    {
        $events = new Events();
        $event  = $events->getBySlug($slug);

        if($event === null) {
            die; // @TODO:
        }

        if($event->isMine() === false) {
            die; // @TODO:
        }

        $event->setStatusCanceled()->save();

        return \Redirect::to('events/' . $slug);
    }
}