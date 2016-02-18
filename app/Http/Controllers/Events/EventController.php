<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Auth;
use Flocc\Events\Events;
use Flocc\Events\Members;
use Flocc\Events\TimeLine\NewLine;
use Flocc\Http\Controllers\Controller;
use Flocc\Notifications\NewNotification;
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
     * @param \Illuminate\Http\Request $request
     * @param int $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Illuminate\Http\Request $request, $slug)
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
            'meta_facebook'     => $meta_data,
            'message'           => $request->session()->get('message')
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
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @param string $type
     *
     * @return mixed
     */
    public function join(\Illuminate\Http\Request $request, $slug, $type)
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
            $user_in_event  = $members->getUserInEvent($event->getId(), $user_id);
            $can_add        = true;

            /**
             * If user in
             */
            if($user_in_event !== null) {
                $can_add = false;

                /**
                 * Delete if follower
                 */
                if($type == 'member' and $user_in_event->isStatusFollower()) {
                    $can_add = true;

                    $members->deleteUserFromEvent($event->getId(), $user_id);
                }
            }

            /**
             * Add
             */
            if($can_add === true) {
                /**
                 * Prepare notification
                 */
                $notification = (new NewNotification())
                    ->setUserId($event->getUserId())
                    ->setUniqueKey('events.members.join.' . $type . '.' . $event->getId())
                    ->setTypeId('events.members.join.' . $type)
                    ->addVariable('user', $user_name)
                    ->addVariable('event', $event->getTitle());

                switch($type) {
                    case 'follower':
                        $members->addNewFollower($event->getId(), $user_id);
                        (new NewLine())
                            ->setEventId($event->getId())
                            ->setTypeAsMessage()
                            ->setMessage($user_name . ' zaczął obserwować to wydarzenie')
                            ->save();
                        $notification->setCallback('/events/' . $event->getSlug());
                        $request->session()->flash('message', 'Obserwujesz to wydarzenie');
                        break;
                    case 'member':
                        $members->addNewMember($event->getId(), $user_id);
                        $notification->setCallback('/events/edit/' . $event->getId() . '/members');
                        $request->session()->flash('message', 'Zapisałeś się do wydarzenia. Zostaniesz poinformwany, gdy organizator Cie zaakceptuje');
                        break;
                }

                /**
                 * Send notification to owner
                 */
                $notification->save();
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

    /**
     * Resign
     *
     * @param string $slug
     *
     * @return mixed
     */
    public function resign($slug)
    {
        $events = new Events();
        $event  = $events->getBySlug($slug);

        if($event === null) {
            die; // @TODO:
        }

        Members::where('event_id', $event->getId())->where('user_id', Auth::getUserId())->delete();

        return \Redirect::to('events/' . $slug);
    }
}