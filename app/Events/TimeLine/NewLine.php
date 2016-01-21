<?php

namespace Flocc\Events\TimeLine;
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
        }

        return ((new TimeLine())->addNew($data) === null) ? false : true;
    }
}