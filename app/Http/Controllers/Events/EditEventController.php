<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Activities;
use Flocc\Auth;
use Flocc\Budgets;
use Flocc\Events\EditEvent;
use Flocc\Events\Events;
use Flocc\Events\Members;
use Flocc\Events\Routes;
use Flocc\Events\TimeLine;
use Flocc\Helpers\ImageHelper;
use Flocc\Http\Controllers\Controller;
use Flocc\Intensities;
use Flocc\Notifications\NewNotification;
use Flocc\Places;
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

        if(in_array($status, ['member', 'rejected'])) {
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

                foreach(array_merge($this->event->getMembers()->toArray(), $this->event->getFollowers()->toArray()) as $member) {
                    (new NewNotification())
                        ->setUserId($member->getUserId())
                        ->setUniqueKey('events.members.new.' . $id . '.' . $user_id)
                        ->setTypeId('events.members.new')
                        ->setCallback('/events/' . $this->event->getSlug())
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
                    ->setCallback('/events/' . $this->event->getSlug())
                    ->addVariable('event', $this->event->getTitle())
                ->save();

                /**
                 * Powiadomienie na tablicy członkow wydarzenia
                 */
                (new \Flocc\Profile\TimeLine\NewTimeLine())
                    ->setUserId($this->event->getMembersAndFollowersIds())
                    ->setType('new_member')
                    ->setTimeLineUserId($user_id)
                    ->setTimeLineEventId($this->event->getId())
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
                    foreach($this->event->getMembers() as $member) {
                        (new NewNotification())
                            ->setUserId($member->getUserId())
                            ->setUniqueKey('events.limit.' . $this->event->getId())
                            ->setCallback('/events/' . $this->event->getSlug())
                            ->setTypeId('events.limit')
                            ->addVariable('event', $this->event->getTitle())
                        ->save();
                    }
                }
            }
        }

        return \Redirect::to('/events/edit/' . $id . '/members');
    }

    /**
     * Edit event
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $this->init($id);

        $activities         = new Activities();
        $budgets            = new Budgets();
        $intensities        = new Intensities();
        $places             = new Places();
        $edit               = new EditEvent();
        $routes             = new Routes();
        $events_activities  = new \Flocc\Events\Activities();
        $users              = new User();

        $post               = \Input::get();
        $is_draft           = $this->event->isStatusDraft();
        $user               = $users->getById(Auth::getUserId());
        $post_routes        = [];

        if($this->event->isStatusCanceled()) {
          die; // @TODO
        }

        if(!empty($post)) {
            $edit->setData($post);

            $validator  = \Validator::make($post, $edit->getValidationRules($post), $edit->getValidationMessages());
            $errors     = $validator->errors();

            $this->event
                ->setTitle(\Input::get('title'))
                ->setDescription(\Input::get('description'))
                ->setEventFrom(\Input::get('event_from'))
                ->setEventTo(\Input::get('event_to'))
                ->setEventSpan(\Input::get('event_span'))
                ->setUsersLimit(\Input::get('users_limit'))
                ->setBudgetId(\Input::get('budgets'))
                ->setIntensitiesId(\Input::get('intensities'));

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
                $this->event->setPlaceId(\Input::get('place_id'));
            } else {
                $this->event->setPlaceId(null);
            }

            if($errors->count() == 0) {
                if($post['place_type'] == 'place') {
                    unset($post['route']);
                } else {
                    $post['place_id']   = null;
                    $post['route']      = explode(',', substr($post['route'], 0, -1));
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
                 * Save event
                 */
                $this->event->save();

                /**
                 * Save route
                 */
                if(isset($post['route'])) {
                    $routes->clear($id);

                    foreach($post['route'] as $place_id) {
                        Routes::create(['event_id' => $id, 'place_id' => $place_id]);
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
                } else {
                    /**
                     * Notification
                     *
                     * @var $member \Flocc\Events\Members
                     */
                    foreach($this->event->getMembers() as $member) {
                        (new NewNotification())
                            ->setUserId($member->getUserId())
                            ->setUniqueKey('events.update.' . $id . '.' . date('d-m-Y'))
                            ->setTypeId('events.update')
                            ->setCallback('/events/' . $this->event->getSlug())
                            ->addVariable('event', $this->event->getTitle())
                        ->save();
                    }
                }

                /**
                 * Powiadomienie na tablicy członkow wydarzenia o edycji
                 */
                foreach(User::all() as $user) {
                    (new \Flocc\Profile\TimeLine\NewTimeLine())
                        ->setUserId($user->getId())
                        ->setType(($is_draft === true) ? 'new_event' : 'edit_event')
                        ->setTimeLineUserId(Auth::getUserId())
                        ->setTimeLineEventId($id)
                    ->save();
                }

                if($is_draft === true) {
                    return \Redirect::to('events/' . $this->event->getSlug() . '/share');
                }

                return \Redirect::to('events/' . $this->event->getSlug());
            } else {
                if(\Input::get('place_type') == 'place') {
                    $this->event->setPlaceId($post['place_id']);
                } else {
                    foreach(explode(',', $post['route']) as $row) {
                        if(!empty($row)) {;
                            $post_routes[$row] = $places->getById($row)->getName();
                        }
                    }
                }

                if(in_array('new', \Input::get('activities', []))) {
                    $post_new_activity = \Input::get('new_activities');
                }
            }
        }

        return view('events.edit.index', [
            'event'             => $this->event,

            'activities'        => $activities->all(),
            'budgets'           => $budgets->all(),
            'intensities'       => $intensities->all(),
            'places'            => $places->all(),
            'errors'            => isset($errors) ? $errors : [],
            'post_routes'       => $post_routes,
            'post_new_activity' => isset($post_new_activity) ? $post_new_activity : null
        ]);
    }

    public function photo(\Illuminate\Http\Request $request, $id)
    {
        $this->init($id);

        if ($request->hasFile('photo')) {
            $image      = new ImageHelper();
            $file       = $request->file('photo');
            $new_name   = 'Event_' . $id . '_' . $file->getClientOriginalName();

            $file_url   = $image->uploadFile($file);

            echo 'file: ' ;
            var_dump($file_url); die;


            die;

            return \Redirect::to('events/' . $this->event->getSlug());
        }

        return view('events.edit.photo', [
            'event'             => $this->event,
        ]);
    }
}