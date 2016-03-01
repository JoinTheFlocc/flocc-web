<?php

namespace Flocc\Profile\TimeLine;

/**
 * Class NewTimeLine
 *
 * @package Flocc\Profile\TimeLine
 */
class NewTimeLine
{
    private $users = [];
    private $type;
    private $event_type = null;
    private $time_line_user_id = null;
    private $time_line_event_comment_id = null;
    private $time_line_event_id = null;

    /**
     * Set user or users id
     *
     * @param int|array $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        if(is_array($user_id)) {
            foreach($user_id as $id) {
                $this->users[] = (int) $id;
            }
        } else {
            $this->users[] = (int) $user_id;
        }

        return $this;
    }

    /**
     * Return users
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * Set event type
     *
     * @param string $type
     *
     * @return $this
     */
    public function setEventType($type)
    {
        $this->event_type = $type;

        return $this;
    }

    /**
     * Get event type
     *
     * @return string
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    /**
     * Set time line user id
     *
     * @param int|null $id
     *
     * @return $this
     */
    public function setTimeLineUserId($id)
    {
        $this->time_line_user_id = $id;

        return $this;
    }

    /**
     * Get time line user id
     *
     * @return null|int
     */
    public function getTimeLineUserId()
    {
        return $this->time_line_user_id;
    }

    /**
     * Set time line event comment
     *
     * @param int|null $id
     *
     * @return $this
     */
    public function setTimeLineEventCommentId($id)
    {
        $this->time_line_event_comment_id = $id;

        return $this;
    }

    /**
     * Get time line event comment id
     *
     * @return null|int
     */
    public function getTimeLineEventCommentId()
    {
        return $this->time_line_event_comment_id;
    }

    /**
     * Set time line event id
     *
     * @param int|null $id
     *
     * @return $this
     */
    public function setTimeLineEventId($id)
    {
        $this->time_line_event_id = (int) $id;

        return $this;
    }

    /**
     * Get time line event id
     *
     * @return null|int
     */
    public function getTimeLineEventId()
    {
        return $this->time_line_event_id;
    }

    /**
     * Is valid?
     *
     * @return bool
     */
    private function __valid()
    {
        if(count($this->users) == 0) {
            return false;
        }

        if(empty($this->type)) {
            return false;
        }

        if(empty($this->event_type)) {
            return false;
        }

        return true;
    }

    /**
     * Sava time line
     *
     * @return bool
     */
    public function save()
    {
        if($this->__valid() === true) {
            return (new TimeLine())->addNew($this);
        }

        return false;
    }
}