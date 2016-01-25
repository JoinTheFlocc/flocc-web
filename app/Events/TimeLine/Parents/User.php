<?php

namespace Flocc\Events\TimeLine\Parents;

/**
 * Class User
 *
 * @package Flocc\Events\TimeLine\Parents
 */
class User
{
    /**
     * Element object
     *
     * @var \Flocc\Events\TimeLine
     */
    protected $element;

    /**
     * User constructor
     *
     * @param \Flocc\Events\TimeLine $element
     */
    public function __construct(\Flocc\Events\TimeLine $element)
    {
        $this->element = $element;
    }

    /**
     * Get user ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->element->user_id;
    }

    /**
     * Get user name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->element->user_name;
    }

    /**
     * Get user avatar URL
     *
     * @return string|null
     */
    public function getAvatarUrl()
    {
        return $this->element->avatar_url;
    }
}