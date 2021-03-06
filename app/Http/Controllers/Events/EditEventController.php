<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Activities;
use Flocc\Auth;
use Flocc\Budgets;
use Flocc\Events\EditEvent;
use Flocc\Events\Events;
use Flocc\Events\Members;
use Flocc\Events\Routes;
use Flocc\Events\Scoring;
use Flocc\Events\TimeLine;
use Flocc\Helpers\DateHelper;
use Flocc\Helpers\ImageHelper;
use Flocc\Http\Controllers\Controller;
use Flocc\Infrastructure;
use Flocc\Intensities;
use Flocc\Notifications\NewNotification;
use Flocc\Places;
use Flocc\Plannings;
use Flocc\Tourist;
use Flocc\TravelWays;
use Flocc\Tribes;
use Flocc\User;

/**
 * Class EditEventController
 *
 * @package Flocc\Http\Controllers\Events
 */
class EditEventController extends Controller
{
    /**
     * @var \Flocc\Events\Events
     */
    private $event;

    /**
     * Initialize
     *
     * @param int $id
     *
     * @return $this
     */
    private function init($id)
    {
        $user_id    = Auth::getUserId();
        $event      = (new Events())->getById($id, true);

        if($event === null) {
            die; // @TODO
        }

        if($event->getUserId() != $user_id) {
            die; // @TODO:
        }

        $this->event = $event;

        return $this;
    }

    /**
     * Edit members in event
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function members($id)
    {
        $this->init($id);

        return view('events.edit.members', [
            'event' => $this->event
        ]);
    }

    /**
     * Update user status in event
     *
     * @param int $id
     * @param int $user_id
     * @param int $status
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function status($id, $user_id, $status)
    {
        $this->init($id);

        if($status == 'member') {
            /**
             * Sprawdzenie limitu
             */
            if($this->event->getMembers()->count() == $this->event->getUsersLimit()) {
                // @TODO:
                throw new \Exception('Przekroczony limit');
            }

            /**
             * Powiadomienia do pozostałych uczestników
             *
             * @var $user \Flocc\Profile
             */
            $user = (new User())->getById($user_id)->getProfile();

            foreach($this->event->getMembersAndFollowers() as $member) {
                (new NewNotification())
                    ->setUserId($member->getUserId())
                    ->setUniqueKey('events.members.new.' . $id . '.' . $user_id)
                    ->setTypeId('events.members.new')
                    ->setCallback('/events/' . $event->getId() . '/' . $event->getSlug())
                    ->addVariable('user', $user->getFirstName() . ' ' . $user->getLastName())
                    ->addVariable('event', $this->event->getTitle())
                ->save();
            }

            /**
             * Powiadomienie do usera, że został zaakceptowany
             */
            (new NewNotification())
                ->setUserId($user_id)
                ->setUniqueKey('events.members.accept.' . $id)
                ->setTypeId('events.members.accept')
                ->setCallback('/events/' . $event->getId() . '/' . $event->getSlug())
                ->addVariable('event', $this->event->getTitle())
            ->save();

            /**
             * Powiadomienie na tablicy wydarzenia
             */
            (new TimeLine\NewLine())
                ->setEventId($id)
                ->setTypeAsMessage()
                ->setMessage(sprintf('[b]%s[/b] dołączył do wydarzenia dnia [b]%s[/b]', $user->getFirstName() . ' ' . $user->getLastName(), date('Y-m-d')))
                ->setUserId(Auth::getUserId())
            ->save();

            /**
             * Zmiana statusu
             */
            (new Members())->updateStatus($user_id, $id, $status);

            /**
             * Po dodaniu tego jest przekroczny limit
             */
            if($this->event->getUsersLimit() == $this->event->getMembers()->count()) {
                (new Events())->closeEvent($id);

                /**
                 * Wysłanie powiadomienia do użytkowników
                 */
                foreach($this->event->getMembersAndFollowers() as $member) {
                    (new NewNotification())
                        ->setUserId($member->getUserId())
                        ->setUniqueKey('events.limit.' . $this->event->getId())
                        ->setCallback('/events/' . $event->getId() . '/' . $event->getSlug())
                        ->setTypeId('events.limit')
                        ->addVariable('event', $this->event->getTitle())
                    ->save();
                }
            }
        }

        if($status == 'rejected') {
            /**
             * Zmiana statusu
             */
            (new Members())->updateStatus($user_id, $id, 'follower');
        }

        return redirect()->route('events.edit.members', ['id' => $id]);
    }

    /**
     * Edit event
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(\Illuminate\Http\Request $request, $id)
    {
        $this->init($id);

        $activities         = new Activities();
        $budgets            = new Budgets();
        $intensities        = new Intensities();
        $tribes             = new Tribes();
        $travel_ways        = new TravelWays();
        $infrastructure     = new Infrastructure();
        $tourist            = new Tourist();
        $plannings          = new Plannings();
        $places             = new Places();
        $edit               = new EditEvent();
        $routes             = new Routes();
        $events_activities  = new \Flocc\Events\Activities();
        $users              = new User();

        $post               = \Input::get();
        $old_event          = clone $this->event;
        $is_draft           = $this->event->isStatusDraft();
        $user               = $users->getById(Auth::getUserId());
        $post_routes        = [];
        $months             = (new DateHelper())->getMonths();

        if($this->event->isStatusCanceled()) {
          die; // @TODO
        }

        if(!empty($post)) {
            $edit->setData($post);

            $validator  = \Validator::make($post, $edit->getValidationRules($post, $this->event), $edit->getValidationMessages());
            $errors     = $validator->errors();

            $this->event
                ->setLastUpdateTime(time())
                ->setTitle(\Input::get('title'))
                ->setDescription(\Input::get('description'))
                ->setEventFrom(\Input::get('event_from'))
                ->setEventTo(\Input::get('event_to'))
                ->setEventSpan(\Input::get('event_span'))
                ->setUsersLimit(\Input::get('users_limit'))
                ->setBudgetId(\Input::get('budgets'))
                ->setIntensitiesId(\Input::get('intensities'))
                ->setTravelWaysId(\Input::get('travel_ways_id'))
                ->setInfrastructureId(\Input::get('infrastructure_id'))
                ->setTouristId(\Input::get('tourist_id'))
                ->setPlanningId(\Input::get('planning_id'))
            ;

            if(isset($post['fixed'])) {
                if($post['fixed'] == '1') {
                    $this->event->setAsFixed();
                } else {
                    $this->event->setAsNonFixed();
                }
            }

            if($this->event->isStatusDraft()) {
                $this->event->setStatus('open');
            }

            if(\Input::get('place_type') == 'place') {
                $place_name     = \Input::get('place');
                $find_place     = $places->getByName($place_name);

                if($find_place === null) {
                    $places->addNew($place_name);

                    $find_place = $places->getByName($place_name);
                }

                $place_id = $find_place->getId();

                $this->event->setPlaceId($place_id);
            } else {
                $this->event->setPlaceId(null);
            }

            if(isset($post['voluntary']) and $post['voluntary'] == '1') {
                $this->event->setVoluntaryAsTrue();
            } else {
                $this->event->setVoluntaryAsFalse();
            }

            if(isset($post['language_learning']) and $post['language_learning'] == '1') {
                $this->event->setLanguageLearningAsTrue();
            } else {
                $this->event->setLanguageLearningAsFalse();
            }

            if(isset($post['event_month'])) {
                $this->event->setEventMonth($post['event_month']);
            }

            if($errors->count() == 0) {
                if($post['place_type'] == 'place') {
                    unset($post['route']);
                } else {
                    $post['place']      = null;
                    $post['route']      = explode(';', substr($post['route'], 0, -1));
                }

                unset($post['place_type']);

                $is_new_activity = array_search('new', $post['activities']);

                if($is_new_activity !== false) {
                    unset($post['activities'][$is_new_activity]);

                    $new_activity = $post['new_activities'];

                    unset($post['new_activities']);
                }

                /**
                 * Add new activity
                 */
                if(isset($new_activity)) {
                    $find_activity = $activities->getByName($new_activity);

                    if($find_activity === null) {
                        $post['activities'][] = $activities->addNew($new_activity);
                    } else {
                        if(in_array($find_activity->getId(), $post['activities']) === false) {
                            $post['activities'][] = $find_activity->getId();
                        }
                    }
                }

                $post['activities'] = array_unique($post['activities']);

                /**
                 * Avatar
                 */
                if($request->hasFile('photo')) {
                    $image      = new ImageHelper();
                    $file       = $request->file('photo');

                    $this->event->setAvatarUrl($image->uploadFile($file));
                }

                /**
                 * Tribes
                 */
                $events_tribes = new \Flocc\Events\Tribes();

                $events_tribes->clear($this->event->getId());

                foreach(\Input::get('tribes', []) as $tribe_id) {
                    $events_tribes->add($this->event->getId(), $tribe_id);
                }

                /**
                 * Set status as open
                 */
                if((int) $post['users_limit'] > $old_event->getUsersLimit()) {
                    $this->event->setStatusOpen();
                }

                /**
                 * Save event
                 */
                $this->event->save();

                /**
                 * Save route
                 */
                if(isset($post['route'])) {
                    $routes->clear($id);

                    foreach($post['route'] as $place_name) {
                        $find_place = $places->getByName($place_name);

                        if($find_place === null) {
                            $places->addNew($place_name);

                            $find_place = $places->getByName($place_name);
                        }

                        Routes::create(['event_id' => $id, 'place_id' => $find_place->getId()]);
                    }
                }

                /**
                 * Save activities
                 */
                $events_activities->clear($id);

                foreach($post['activities'] as $activity_id) {
                    \Flocc\Events\Activities::create(['event_id' => $id, 'activity_id' => $activity_id]);
                }

                /**
                 * Add new time line
                 */
                if($is_draft === true) {
                    $user_name = $user->getProfile()->getFirstName() . ' ' . $user->getProfile()->getLastName();

                    (new TimeLine\NewLine())
                        ->setEventId($id)
                        ->setTypeAsMessage()
                        ->setMessage(sprintf('[b]%s[/b] utworzył wydarzenie dnia %s o %s', $user_name, date('Y-m-d'), date('H:i')))
                        ->setUserId(Auth::getUserId())
                    ->save();

                    /**
                     * Add owner as member
                     */
                    (new Members())->addNew($id, Auth::getUserId(), 'member');
                } else {
                    /**
                     * Notification if users limits is higher
                     */
                    if((int) $post['users_limit'] > $old_event->getUsersLimit()) {
                        $notification_type_id = 'events.update.users_limit';
                    } else {
                        $notification_type_id = 'events.update';
                    }

                    /**
                     * Update event date
                     */
                    if(
                        $post['event_from'] !== $old_event->getEventFrom()
                        or $post['event_to'] !== $old_event->getEventTo()
                        or (int) $post['event_span'] !== $old_event->getEventSpan()
                    ) {
                        $notification_type_id = 'events.update.date';
                    }

                    /**
                     * Notification
                     *
                     * @var $member \Flocc\Events\Members
                     */
                    foreach($this->event->getMembers() as $member) {
                        (new NewNotification())
                            ->setUserId($member->getUserId())
                            ->setUniqueKey('events.update.' . $id . '.' . date('d-m-Y'))
                            ->setTypeId($notification_type_id)
                            ->setCallback('/events/' . $this->event->getId() . '/' . $this->event->getSlug())
                            ->addVariable('event', $this->event->getTitle())
                            ->addVariable('users_limit', $post['users_limit'])
                            ->addVariable('event_from', $post['event_from'])
                            ->addVariable('event_to', $post['event_to'])
                            ->addVariable('event_span', (int) $post['event_span'])
                        ->save();
                    }
                }

                /**
                 * Update scoring
                 *
                 * @var $scoring \Flocc\Events\Scoring
                 */
                $scoring    = new Scoring();
                $scoring    = $scoring->getByEventId($this->event->getId());

                $scoring = $scoring
                    ->setActivityId(reset($post['activities']))
                    ->setTribes(\Input::get('tribes', []))
                ;

                if(\Input::get('place_type') != 'place') {
                    $scoring = $scoring->setRoute(implode(' > ', $post['route']))->setPlace(null);
                } else {
                    $scoring = $scoring->setPlace(\Input::get('place'))->setRoute(null);
                }

                $scoring->save();

                if($is_draft === true) {
                    /**
                     * Save user log
                     */
                    (new User\Logs())
                        ->setUserId(Auth::getUserId())
                        ->setTypeEventsCreate()
                        ->setEventId($this->event->getId())
                    ->save();

                    return redirect()->route('events.event.share', ['id' => $this->event->getId(), 'slug' => $this->event->getSlug()]);
                }

                return redirect()->route('events.event', ['id' => $this->event->getId(), 'slug' => $this->event->getSlug()]);
            } else {
                if(\Input::get('place_type') != 'place') {
                    foreach(explode(';', $post['route']) as $i => $row) {
                        if(!empty($row)) {;
                            $post_routes[$i] = $row;
                        }
                    }
                }

                if(in_array('new', \Input::get('activities', []))) {
                    $post_new_activity = \Input::get('new_activities');
                }

                $post_activities = [];

                if(isset($post['activities'])) {
                    foreach($post['activities'] as $post_activity) {
                        $post_activities[(int) $post_activity] = (int) $post_activity;
                    }
                }
            }
        }

        return view('events.edit.index', [
            'event'             => $this->event,

            'activities'        => $activities->all(),
            'budgets'           => $budgets->all(),
            'intensities'       => $intensities->all(),
            'tribes'            => $tribes->all(),
            'travel_ways'       => $travel_ways->all(),
            'infrastructure'    => $infrastructure->all(),
            'tourist'           => $tourist->all(),
            'places'            => $places->all(),
            'plannings'         => $plannings->all(),
            'errors'            => isset($errors) ? $errors : [],
            'post_routes'       => $post_routes,
            'post_new_activity' => isset($post_new_activity) ? $post_new_activity : null,
            'post_activities'   => isset($post_activities) ? $post_activities : [],
            'months'            => $months,
            'post'              => $post
        ]);
    }
}