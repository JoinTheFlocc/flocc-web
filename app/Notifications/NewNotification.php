<?php

namespace Flocc\Notifications;

use Flocc\User;

/**
 * Class NewNotification
 *
 * @package Flocc\Notifications
 */
class NewNotification
{
    private $user_id, $unique_key, $type_id, $callback;
    private $variables = [];

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
     * Set unique key
     *
     * @param string $key
     *
     * @return $this
     */
    public function setUniqueKey($key)
    {
        $this->unique_key = md5($key);

        return $this;
    }

    /**
     * Get unique key
     *
     * @return string
     */
    public function getUniqueKey()
    {
        return $this->unique_key;
    }

    /**
     * Set type ID
     *
     * @param string $type_id
     *
     * @return $this
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Set type ID
     *
     * @return string
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set callback
     *
     * @param string $callback
     *
     * @return $this
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Get callback
     *
     * @return string
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Add variable
     *
     * @param string $name
     * @param int|string $value
     *
     * @return $this
     */
    public function addVariable($name, $value)
    {
        $this->variables[$name] = $value;

        return $this;
    }

    /**
     * Get variables
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Data validation
     *
     * @return bool
     */
    private function __valid()
    {
        if(empty($this->user_id) === true) {
            return false;
        } else {
            if((new User())->getById($this->user_id) === null) {
                return false;
            }
        }

        if(empty($this->type_id) === true) {
            return false;
        } else {
            if((new Types())->isTypeExists($this->type_id) === false) {
               return false;
            }
        }

        return true;
    }

    /**
     * Save notification
     *
     * @return bool
     */
    public function save()
    {
        if($this->__valid() === true) {
            return (new Notifications())->addNewNotification($this);
        }

        return false;
    }
}