<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Events\Events;
use Flocc\Events\TimeLine\NewLine;
use Flocc\Http\Controllers\Controller;
use Flocc\Notifications\NewNotification;
use Flocc\User;

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
        $event_id   = (int) \Input::get('event_id');
        $user_id    = (int) \Auth::user()->id;

        $events     = new Events();
        $line       = new NewLine();

        $event      = $events->getById($event_id);

        /**
         * @var $user \Flocc\Profile
         */
        $user       = (new User())->getById($user_id)->getProfile();

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

            $comment_id = $line->getLastInsertCommentId();

            /**
             * Send notifications
             *
             * @var $member \Flocc\Events\Members
             */
            foreach($event->getMembersAndFollowers() as $member) {
                (new NewNotification())
                    ->setUserId($member->getUserId())
                    ->setUniqueKey('events.comment.' . $event->getId() . '.' . md5($comment))
                    ->setTypeId('events.comment')
                    ->setCallback('/events/' . $event->getSlug())
                    ->addVariable('user', $user->getFirstName() . ' ' . $user->getLastName())
                    ->addVariable('event', $event->getTitle())
                ->save();

                /**
                 * Powiadomienie na tablicy członkow wydarzenia
                 */
                $event_type = $member->isStatusMember() ? 'member' : 'follower';

                (new \Flocc\Profile\TimeLine\NewTimeLine())
                    ->setUserId($member->getUserId())
                    ->setType('new_comment')
                    ->setTimeLineUserId($user_id)
                    ->setTimeLineEventId($event->getId())
                    ->setTimeLineEventCommentId($comment_id)
                    ->setEventType($event_type)
                ->save();
            }

            /**
             * Powiadomienie na tablicy do organizatora wydarzenia
             */
            (new \Flocc\Profile\TimeLine\NewTimeLine())
                ->setUserId($event->getUserId())
                ->setType('new_comment')
                ->setTimeLineUserId($user_id)
                ->setTimeLineEventId($event->getId())
                ->setTimeLineEventCommentId($comment_id)
                ->setEventType('owner')
            ->save();
        }

        return \Redirect::to('events/' . $event->getSlug());
    }
}