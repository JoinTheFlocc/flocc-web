<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Events\Events;
use Flocc\Events\TimeLine\NewLine;
use Flocc\Http\Controllers\Controller;

/**
 * Class CommentController
 *
 * @package Flocc\Http\Controllers\Events
 */
class CommentController extends Controller
{
    /**
     * New comment
     */
    public function save()
    {
        $comment    = \Input::get('comment', '');
        $event_id   = (int) \Input::get('event_id', null);
        $user_id    = (int) \Auth::user()->id;

        $events     = new Events();
        $line       = new NewLine();

        $event      = $events->getById($event_id);

        if($event === null) {
            die; // @TODO:
        }

        if(empty($comment) === false) {
            $line
                ->setTypeAsComment()
                ->setEventId($event_id)
                ->setUserId($user_id)
                ->setComment($comment)
            ->save();
        }

        return \Redirect::to('events/' . $event->getSlug());
    }
}