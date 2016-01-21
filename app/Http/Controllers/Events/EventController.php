<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Events\Events;
use Flocc\Events\Members;
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
        $events     = new Events();
        $event      = $events->getBySlug($slug);

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

    /**
     * Join to event
     *
     * @param string $slug
     * @param string $type
     *
     * @return mixed
     */
    public function join($slug, $type)
    {
        $events     = new Events();
        $members    = new Members();

        $event      = $events->getBySlug($slug);
        $user_id    = (int) \Auth::user()->id;

        if($event === null) {
            die; // @TODO:
        }

        if($event->isMine() === false) {
            if($members->isUserInEvent($event->getId(), $user_id) === false) {
                switch($type) {
                    case 'follower':
                        $members->addNewFollower($event->getId(), $user_id);
                        break;
                    case 'member':
                        $members->addNewMember($event->getId(), $user_id);
                        break;
                }
            }
        }

        return \Redirect::to('events/' . $slug);
    }
}