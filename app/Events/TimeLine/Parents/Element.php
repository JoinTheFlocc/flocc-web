<?php

namespace Flocc\Events\TimeLine\Parents;

/**
 * Class Element
 *
 * @package Flocc\Events\TimeLine\Parents
 */
class Element
{
    /**
     * Element object
     *
     * @var \Flocc\Events\TimeLine
     */
    protected $element;

    /**
     * Element constructor
     *
     * @param \Flocc\Events\TimeLine $element
     */
    public function __construct(\Flocc\Events\TimeLine $element)
    {
        $this->element = $element;
    }

    /**
     * Is type message
     *
     * @return bool
     */
    public function isMessage()
    {
        return ($this->getType() == 'message');
    }

    /**
     * Is type comment
     *
     * @return bool
     */
    public function isComment()
    {
        return ($this->getType() == 'comment');
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->element->type;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->element->time;
    }

    /**
     * Get user object
     *
     * @return \Flocc\Events\TimeLine\Parents\User
     */
    public function getUser()
    {
        return new User($this->element);
    }
}