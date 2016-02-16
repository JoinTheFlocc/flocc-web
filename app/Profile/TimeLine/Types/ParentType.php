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
        return (int) $this->data->getId();
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->data->getType();
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->data->getTime();
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->data->getUserName();
    }

    /**
     * Get event title
     *
     * @return string
     */
    public function getEventTitle()
    {
        return $this->data->getEventTitle();
    }

    /**
     * Get comment text
     *
     * @return string
     */
    public function getComment()
    {
        return $this->data->getComment();
    }
}