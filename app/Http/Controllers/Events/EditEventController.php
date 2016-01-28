<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Activities;
use Flocc\Budgets;
use Flocc\Events\Events;
use Flocc\Events\Members;
use Flocc\Http\Controllers\Controller;
use Flocc\Intensities;
use Flocc\Places;

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
        $user_id    = (int) \Auth::user()->id;
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
     * @param string $status
     *
     * @return mixed
     */
    public function status($id, $user_id, $status)
    {
        $this->init($id);

        if(in_array($status, ['member', 'rejected'])) {
            (new Members())->updateStatus($user_id, $id, $status);
        }

        return \Redirect::to('/events/edit/' . $id . '/members');
    }

    public function index($id)
    {
        $this->init($id);

        $activities     = new Activities();
        $budgets        = new Budgets();
        $intensities    = new Intensities();
        $places         = new Places();

        return view('events.edit.index', [
            'activities'        => $activities->all(),
            'bbudgets'          => $budgets->all(),
            'iintensities'      => $intensities->all()
        ]);
    }
}