<?php

namespace Flocc\Events;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comments
 *
 * @package Flocc\Events
 */
class Comments extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'event_id', 'parent_id', 'user_id', 'time', 'comment', 'last_comment_time', 'label'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set comment ID
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Get comment ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

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
     * Set parent ID
     *
     * @param int $parent_id
     *
     * @return $this
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * Get parent ID
     *
     * @return int|null
     */
    public function getParentId()
    {
        return ($this->parent_id === null) ? null : (int) $this->parent_id;
    }

    /**
     * Set user ID
     *
     * @param int $user_id
     *
     * @return int
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
     * Set commented time
     *
     * @param string $time
     *
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get commented time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set comment text
     *
     * @param string $comment
     *
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment text
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set last comment time
     *
     * @param string|null $time
     *
     * @return $this
     */
    public function setLastCommentTime($time)
    {
        $this->last_comment_time = $time;

        return $this;
    }

    /**
     * Set date as now
     * 
     * @return Comments
     */
    public function setLastCommentTimeAsCurrent()
    {
        return $this->setLastCommentTime(date('Y-m-d H:i:s'));
    }

    /**
     * Get last comment time
     *
     * @return string|null
     */
    public function getLastCommentTime()
    {
        return $this->last_comment_time;
    }

    /**
     * Set label as public
     *
     * @return $this
     */
    public function setLabelAsPublic()
    {
        $this->label = 'public';

        return $this;
    }

    /**
     * Is label is public
     *
     * @return bool
     */
    public function isLabelPublic()
    {
        return ($this->label == 'public');
    }

    /**
     * Set label as private
     *
     * @return $this
     */
    public function setLabelAsPrivate()
    {
        $this->label = 'private';

        return $this;
    }

    /**
     * Is label is private
     *
     * @return bool
     */
    public function isLabelPrivate()
    {
        return ($this->label == 'private');
    }

    /**
     * Get user
     *
     * @return \Flocc\User
     */
    public function getUser()
    {
        return $this->hasOne('Flocc\User', 'id', 'user_id')->first();
    }

    /**
     * Get childrens
     *
     * @return null|\Illuminate\Database\Eloquent\Collection
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Get comment by ID
     *
     * @param int $id
     *
     * @return false|\Illuminate\Database\Eloquent\Collection
     */
    public function getById($id)
    {
        return self::where('id', (int) $id)->first();
    }

    /**
     * Add new comment
     *
     * @param int $event_id
     * @param int $user_id
     * @param string $comment
     *
     * @return int|null
     */
    public function addNew($event_id, $user_id, $comment)
    {
        $insert = self::create([
            'event_id'  => (int) $event_id,
            'user_id'   => (int) $user_id,
            'comment'   => $comment
        ]);

        return ($insert === null) ? null : $insert->id;
    }

    /**
     * Get comments tree
     *
     * @param int $event_id
     *
     * @return Collection
     */
    public function getByEventId($event_id)
    {
        $comments = new Collection();

        foreach(self::where('event_id', (int) $event_id)->whereNull('parent_id')->orderBy('last_comment_time', 'desc')->get() as $comment) {
            $comment['childrens']           = new Collection();
            $comments[$comment->getId()]    = $comment;
        }

        foreach(self::where('event_id', (int) $event_id)->whereNotNull('parent_id')->orderBy('id')->get() as $comment) {
            if(isset($comments[$comment->getParentId()])) {
                $comments[$comment->getParentId()]['childrens']->push($comment);
            }
        }

        return $comments;
    }
}