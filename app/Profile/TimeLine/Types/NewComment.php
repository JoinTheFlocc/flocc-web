<?php

namespace Flocc\Profile\TimeLine\Types;

/**
 * Class NewComment
 *
 * @package Flocc\Profile\TimeLine\Types
 */
class NewComment extends ParentType
{
    /**
     * Get time line message
     *
     * @return array
     */
    public function getMessage()
    {
        return [
            'user'              => $this->getUserName(),
            'comment'           => $this->getComment(),
            'event'             => $this->getEventTitle(),
            'user_id'           => $this->getTimeLineUserId(),
            'event_slug'        => $this->getEventSlug()
        ];
    }
}