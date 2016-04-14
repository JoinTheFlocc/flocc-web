<?php

namespace Flocc\User\Floccs;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class Flocc
 *
 * @package Flocc\User\Floccs
 */
class Flocc
{
    /**
     * @var Floccs
     */
    private $data;

    /**
     * @param Floccs $data
     */
    public function __construct(\Flocc\User\Floccs\Floccs $data)
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
        return $this->data->getId();
    }

    /**
     * Get activity ID
     *
     * @return int|null
     */
    public function getActivityId()
    {
        return $this->data->getActivityId();
    }

    /**
     * Get activity name
     *
     * @return null|string
     */
    public function getActivityName()
    {
        return $this->data->getActivityName();
    }

    /**
     * Get place
     *
     * @return null|string
     */
    public function getPlace()
    {
        return $this->data->getPlace();
    }

    /**
     * Get flocc members
     *
     * @param int $limit
     *
     * @return Collection
     */
    public function getMembers($limit = 5)
    {
        return (new Floccs())->getMembers($this->getActivityId(), $this->getPlace(), $limit);
    }
}