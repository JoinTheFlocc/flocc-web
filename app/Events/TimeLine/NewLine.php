<?php

namespace Flocc\Events\TimeLine;
use Flocc\Events\Comments;
use Flocc\Events\Messages;
use Flocc\Events\TimeLine;

/**
 * Class NewLine
 *
 * @package Flocc\Events\TimeLine
 */
class NewLine
{
    private $event_id, $type;
    private $message;
    private $comment, $user_id;
    private $data;

    /**
     * Set event ID
     *
     * @param int $event_id
     *
     * @return $this
     */
    public function setEventId($event_id)
    {
        $this->event_id = (int) $event_id;

        return $this;
    }

    /**
     * Get event ID
     *
     * @return int
     */
    public function getEventId()
    {
        return (int) $this->event_id;
    }

    /**
     * Set type as message
     *
     * @return $this
     */
    public function setTypeAsMessage()
    {
        $this->type = 'message';

        return $this;
    }

    /**
     * Set type as comment
     *
     * @return $this
     */
    public function setTypeAsComment()
    {
        $this->type = 'comment';

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set comment text
     *
     * @param string $comment
     *
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment text
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set user ID
     *
     * @param int $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = (int) $user_id;

        return $this;
    }

    /**
     * Get user ID
     *
     * @return int
     */
    public function getUserId()
    {
        return (int) $this->user_id;
    }

    /**
     * Save data
     *
     * @return bool
     */
    public function save()
    {
        $data = [
            'event_id'  => $this->getEventId(),
            'type'      => $this->getType()
        ];

        switch($this->getType()) {
            case 'message':
                $data['message_id'] = (new Messages())->addNew($this->getEventId(), $this->getMessage());
                break;
            case 'comment':
                $data['comment_id'] = (new Comments())->addNew($this->getEventId(), $this->getUserId(), $this->getComment());
                break;
        }

        $this->data = $data;

        return ((new TimeLine())->addNew($data) === null) ? false : true;
    }

    /**
     * Get comment ID after insert
     *
     * @return null|int
     */
    public function getLastInsertCommentId()
    {
        return isset($this->data['comment_id']) ? (int) $this->data['comment_id'] : null;
    }
}