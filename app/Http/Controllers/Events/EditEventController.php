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
use Flocc\Http\Controllers\Controller;
use Flocc\Intensities;
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

                (new Members())->updateStatus($user_id, $id, $status);

                /**
                 * Po dodaniu tego jest przekroczny limit
                 */
                if($this->event->getUsersLimit() == $this->event->getMembers()->count()) {
                    (new Events())->closeEvent($id);
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

        if($this->event->isStatusCanceled()) {
          die; // @TODO
        }

        if(!empty($post)) {
            $edit->setData($post);

            $validator  = \Validator::make($post, $edit->getValidationRules(), $edit->getValidationMessages());
            $errors     = $validator->errors();

            $this->event
                ->setTitle(\Input::get('title'))
                ->setDescription(\Input::get('description'))
                ->setEventFrom(\Input::get('event_from'))
                ->setEventTo(\Input::get('event_to'))
                ->setEventSpan(\Input::get('event_span'))
                ->setUsersLimit(\Input::get('users_limit'))
                ->setStatus(\Input::get('status'))
                ->setBudgetId(\Input::get('budgets'))
                ->setIntensitiesId(\Input::get('intensities'))
                ->setPlaceId(\Input::get('place_id'));

            if(isset($post['fixed'])) {
                if($post['fixed'] == '1') {
                    $this->event->setAsFixed();
                } else {
                    $this->event->setAsNonFixed();
                }
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

                    return \Redirect::to('events/' . $this->event->getSlug() . '/share');
                }

                return \Redirect::to('events/' . $this->event->getSlug());
            }
        }

        return view('events.edit.index', [
            'event'             => $this->event,

            'activities'        => $activities->all(),
            'budgets'           => $budgets->all(),
            'intensities'       => $intensities->all(),
            'places'            => $places->all(),
            'errors'            => isset($errors) ? $errors : []
        ]);
    }
}