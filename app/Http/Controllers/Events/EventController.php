<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Events\Events;
use Flocc\Events\Members;
use Flocc\Events\TimeLine\NewLine;
use Flocc\Http\Controllers\Controller;
use Flocc\User;

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

        /**
         * Facebook meta data
         */
        $meta_data = (new \Flocc\Social\Facebook\MetaData())
            ->setTitle($event->getTitle())
            ->setDescription($event->getDescription())
            ->setImage($event->getAvatarUrl())
        ;

        /**
         * Update views
         */
        $events->updateViews($event->getId(), $event->getViews()+1);

        return view('events.event.index', [
            'event'             => $event,
            'meta_facebook'     => $meta_data
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
        $profile    = new User();

        $event      = $events->getBySlug($slug);
        $user_id    = (int) \Auth::user()->id;
        $user       = $profile->getById($user_id);

        $user_name  = $user->getProfile()->getFirstName() . ' ' . $user->getProfile()->getLastName();

        if($event === null) {
            die; // @TODO:
        }

        if($event->isMine() === false) {
            if($members->isUserInEvent($event->getId(), $user_id) === false) {
                switch($type) {
                    case 'follower':
                        $members->addNewFollower($event->getId(), $user_id);
                        (new NewLine())
                            ->setEventId($event->getId())
                            ->setTypeAsMessage()
                            ->setMessage($user_name . ' zaczął obserwować to wydarzenie')
                        ->save();
                        break;
                    case 'member':
                        $members->addNewMember($event->getId(), $user_id);
                        break;
                }
            }
        }

        return \Redirect::to('events/' . $slug);
    }

    /**
     * Share event
     *
     * @param string $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function share($slug)
    {
        $events = new Events();
        $event  = $events->getBySlug($slug);

        if($event === null) {
            die; // @TODO:
        }

        /**
         * Facebook meta data
         */
        $meta_data = (new \Flocc\Social\Facebook\MetaData())
            ->setTitle($event->getTitle())
            ->setDescription($event->getDescription())
            ->setImage($event->getAvatarUrl())
        ;

        return view('events.event.share', [
            'event'             => $event,
            'meta_facebook'     => $meta_data
        ]);
    }
}