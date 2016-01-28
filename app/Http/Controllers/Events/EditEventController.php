<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Activities;
use Flocc\Budgets;
use Flocc\Events\Events;
use Flocc\Http\Controllers\Controller;
use Flocc\Intensities;
use Flocc\Places;

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