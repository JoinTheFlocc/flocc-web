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
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Illuminate\Http\Request $request, $id)
    {
        $events     = new Events();
        $event      = $events->getById($id);

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
            'message'           => $request->session()->get('message'),
            'comments_label'    => $request->session()->get('comments_label', 'public'),
            'user_id'           => Auth::getUserId()
        ]);
    }

    /**
     * Members and followers list
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function members($id)      { return $this->users($id, 'members'); }
    public function followers($id)    { return $this->users($id, 'followers'); }

    /**
     * User list
     *
     * @param int $id
     * @param string $status
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function users($id, $status)
    {
        $events = new Events();
        $event  = $events->getById($id);

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
     * @param int $id
     *
     * @return mixed
     */
    public function cancel($id)
    {
        $events = new Events();
        $event  = $events->getById($id);

        if($event === null) {
            die; // @TODO:
        }

        if($event->isMine() === false) {
            die; // @TODO:
        }

        $event->setStatusCanceled()->save();

        return redirect()->route('events.event', ['id' => $event->getId(), 'slug' => $event->getSlug()]);
    }

    /**
     * Join to event
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param string $slug
     * @param string $type
     *
     * @return mixed
     */
    public function join(\Illuminate\Http\Request $request, $id, $slug, $type)
    {
        $events     = new Events();
        $members    = new Members();
        $profile    = new User();

        $event      = $events->getById($id);
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

                        // New line on event time line
                        (new NewLine())
                            ->setEventId($event->getId())
                            ->setTypeAsMessage()
                            ->setMessage($user_name . ' zaczął obserwować to wydarzenie')
                        ->save();

                        $notification->setCallback('/events/' . $event->getId() . '/' . $event->getSlug());
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

        return redirect()->route('events.event', ['id' => $event->getId(), 'slug' => $event->getSlug()]);
    }

    /**
     * Share event
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function share($id)
    {
        $events = new Events();
        $event  = $events->getById($id);

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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @param string $slug
     *
     * @return mixed
     */
    public function resign(\Illuminate\Http\Request $request, $id, $slug)
    {
        $events     = new Events();
        $members    = new Members();

        $event      = $events->getById($id);
        $member     = $members->where('event_id', $event->getId())->where('user_id', Auth::getUserId())->first();

        if($event === null) {
            die; // @TODO:
        }

        if($member->status == 'member') {
            $ids = [];

            foreach($event->getMembers() as $user) {
                if($user->getUserId() !== Auth::getUserId()) {
                    $ids[] = $user->getUserId();
                }
            }

            foreach($ids as $user_id) {
                /**
                 * @var $user \Flocc\Profile
                 */
                $user = (new User())->getById(Auth::getUserId())->getProfile();

                (new NewNotification())
                    ->setUserId($user_id)
                    ->setUniqueKey('events.resign.' . Auth::getUserId())
                    ->setCallback('/events/' . $event->getId() . '/' . $event->getSlug())
                    ->setTypeId('events.resign')
                    ->addVariable('user', $user->getFirstName() . ' ' . $user->getLastName())
                    ->addVariable('event', $event->getTitle())
                ->save();
            }

            /**
             * Notification to owner
             */
            (new NewNotification())
                ->setUserId($event->getUserId())
                ->setUniqueKey('events.reopen.' . $event->getId())
                ->setCallback('/events/' . $event->getId() . '/' . $event->getSlug())
                ->setTypeId('events.reopen')
                ->addVariable('user', $user->getFirstName() . ' ' . $user->getLastName())
                ->addVariable('event', $event->getTitle())
            ->save();

            /**
             * Reopen event
             */
            if($event->isStatusClose()) {
                $event->setStatusOpen()->save();
            }
        }

        $member->delete();

        $request->session()->flash('message', 'Wypisałeś się z wydarzenia');

        return redirect()->route('events.event', ['id' => $event->getId(), 'slug' => $event->getSlug()]);
    }
}