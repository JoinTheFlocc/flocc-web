<?php

namespace Flocc\Mail;

use Flocc\Notifications\NewNotification;
use Flocc\User;

/**
 * Class NewMessage
 *
 * @package Flocc\Mail
 */
class NewMessage
{
    private $user_id            = null;
    private $conversation_id    = null;
    private $message            = '';
    private $users              = [];

    /**
     * Set owner user ID
     *
     * @param int $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        if((new User())->getById($user_id) !== null) {
            $this->user_id = (int) $user_id;
        }

        return $this;
    }

    /**
     * Get user ID
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set conversation ID
     *
     * @param int $conversation_id
     *
     * @return $this
     */
    public function setConversationId($conversation_id)
    {
        if($conversation_id !== null) {
            if((new Conversations())->getById($conversation_id) !== null) {
                $this->conversation_id = (int) $conversation_id;
            } else {
                $this->conversation_id = false;
            }
        }

        return $this;
    }

    /**
     * Get conversation ID
     *
     * @return null|int
     */
    public function getConversationId()
    {
        return $this->conversation_id;
    }

    /**
     * Set text
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
     * Add new recipient
     *
     * @param int $user_id
     *
     * @return $this
     */
    public function addUser($user_id)
    {
        if((new User())->getById($user_id) !== null) {
            $this->users[] = (int) $user_id;
        }

        return $this;
    }

    /**
     * Set recipients
     *
     * @param array $users
     *
     * @return $this
     */
    public function setUsers(array $users)
    {
        $model = new User();

        foreach($users as $user_id) {
            if($model->getById($user_id) !== null) {
                $this->users[] = (int) $user_id;
            }
        }

        return $this;
    }

    /**
     * Clear recipients
     *
     * @return $this
     */
    public function clearUsers()
    {
        $this->users = [];

        return $this;
    }

    /**
     * Get users array
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Valid data
     *
     * @return bool
     */
    private function __valid()
    {
        if($this->user_id === null) {
            return false;
        }

        if(empty($this->message) or strlen($this->message) == 0) {
            return false;
        }

        if($this->conversation_id === false) {
            return false;
        }

        if($this->conversation_id === null) {
            if(count($this->users) == 0) {
                return false;
            }
        } else {
            if((new Users())->isUserInConversation($this->user_id, $this->conversation_id) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * New message or new conversation
     *
     * @return bool
     */
    public function save()
    {
        if($this->__valid() === true) {
            /**
             * Get users in conversation
             */
            if($this->conversation_id !== null) {
                foreach((new Users())->getUsersInConversation($this->conversation_id) as $user) {
                    $this->users[] = $user->id;
                }

            }

            /**
             * Save
             */
            if($this->conversation_id === null) {
                $conversation_id = (new Conversations())->addNewConversation($this);
            } else {
                $conversation_id = (new Messages())->addNewMessage($this);
            }

            /**
             * Add notification
             */
            foreach($this->getUsers() as $user_id) {
                if($user_id != $this->getUserId()) {
                    /**
                     * @var $user \Flocc\Profile
                     */
                    $user = (new User())->getById($this->getUserId())->getProfile();

                    (new NewNotification())
                        ->setUserId($user_id)
                        ->setUniqueKey('mail.conversation.' . $conversation_id)
                        ->setCallback('/mail/' . $conversation_id)
                        ->setTypeId('mail.new')
                        ->addVariable('name', $user->getFirstName() . ' ' . $user->getLastName())
                    ->save();
                }
            }

            return $conversation_id;
        }

        return false;
    }
}
