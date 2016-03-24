<?php

namespace Flocc\Http\Controllers\Events;

use Flocc\Auth;
use Flocc\Events\Comments;
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
        $parent_id  = \Input::get('parent_id', null);
        $label      = \Input::get('label', 'public');
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

        if($label === 'private') {
            $comments = new Comments();

            $comments
                ->setEventId($event_id)
                ->setParentId($parent_id)
                ->setLabelAsPrivate()
                ->setUserId($user_id)
                ->setComment($comment)
                ->setLastCommentTimeAsCurrent()
            ->save();

            /**
             * Update last comment time for parent
             */
            if($parent_id !== null) {
                $comment = $comments->getById($parent_id);

                $comment->setLastCommentTimeAsCurrent()->save();
            }

            /**
             * Send notifications
             *
             * @var $member \Flocc\Events\Members
             */
            foreach($event->getMembers() as $member) {
                if($member->getUserId() !== Auth::getUserId()) {
                    (new NewNotification())
                        ->setUserId($member->getUserId())
                        ->setUniqueKey('events.comment.' . $event->getId() . '.' . md5($comment))
                        ->setTypeId('events.comment')
                        ->setCallback('/events/' . $event->getSlug())
                        ->addVariable('user', $user->getFirstName() . ' ' . $user->getLastName())
                        ->addVariable('event', $event->getTitle())
                    ->save();
                }
            }
        } else {
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
                    if($member->getUserId() !== Auth::getUserId()) {
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
        }

        return \Redirect::to('events/' . $event->getSlug());
    }
}