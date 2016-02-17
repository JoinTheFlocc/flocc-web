<?php

namespace Flocc\Profile\TimeLine\Types;

/**
 * Class ParentType
 *
 * @package Flocc\Profile\TimeLine\Types
 */
class ParentType
{
    protected $data;

    /**
     * ParentType constructor.
     *
     * @param \Flocc\Profile\TimeLine\TimeLine $data
     */
    public function __construct(\Flocc\Profile\TimeLine\TimeLine $data)
    {
        $this->data = $data;
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->data->id;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->data->type;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->data->time;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        return (string) $this->data->firstname . ' ' . (string) $this->data->lastname;
    }

    /**
     * Get event title
     *
     * @return string
     */
    public function getEventTitle()
    {
        return (string) $this->data->title;
    }

    /**
     * Get comment text
     *
     * @return string
     */
    public function getComment()
    {
        return $this->data->comment;
    }

    /**
     * Get time line user ID
     *
     * @return string|null
     */
    public function getTimeLineUserId()
    {
        return $this->data->time_line_user_id;
    }

    /**
     * Get event ID
     *
     * @return string|null
     */
    public function getEventId()
    {
        return $this->data->event_id;
    }

    /**
     * Get event slug
     *
     * @return string|null
     */
    public function getEventSlug()
    {
        return $this->data->slug;
    }

    /**
     * Get event description
     *
     * @return string|null
     */
    public function getEventDescription()
    {
        return $this->data->description;
    }
}