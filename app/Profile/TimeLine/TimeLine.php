<?php

namespace Flocc\Profile\TimeLine;

use Flocc\Profile\TimeLine\Types\EditEvent;
use Flocc\Profile\TimeLine\Types\NewComment;
use Flocc\Profile\TimeLine\Types\NewEvent;
use Flocc\Profile\TimeLine\Types\NewMember;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeLine
 *
 * @package Flocc\Profile\TimeLine
 */
class TimeLine extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profile_time_line';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'time', 'type', 'time_line_user_id', 'time_line_event_comment_id', 'time_line_event_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
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
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Get user ID
     *
     * @return int
     */
    public function getUserId()
    {
        return (int) $this->time_line_user_id;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        return (string) $this->firstname . ' ' . (string) $this->lastname;
    }

    /**
     * Get event title
     *
     * @return string
     */
    public function getEventTitle()
    {
        return (string) $this->title;
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
     * Get by user ID
     *
     * @param int $user_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserId($user_id)
    {
        $time_line  = new \Illuminate\Database\Eloquent\Collection();
        $get        = self::where('profile_time_line.user_id', (int) $user_id)
            ->select('profile_time_line.id', 'profile_time_line.type', 'profile_time_line.time', 'profiles.firstname', 'profiles.lastname', 'events.title', 'events_comments.comment')
            ->leftjoin('profiles', 'profiles.user_id', '=', 'profile_time_line.time_line_user_id')
            ->leftjoin('events_comments', 'events_comments.id', '=', 'profile_time_line.time_line_event_comment_id')
            ->leftjoin('events', 'events.id', '=', 'profile_time_line.time_line_event_id')
            ->groupBy('profile_time_line.id')
            ->orderBy('profile_time_line.id', 'desc')
        ->get();

        foreach($get as $row) {
            switch($row->type) {
                case 'new_member':
                case 'new_follower':
                    $time_line->push(new NewMember($row));
                    break;
                case 'new_comment':
                    $time_line->push(new NewComment($row));
                    break;
                case 'edit_event':
                    $time_line->push(new EditEvent($row));
                    break;
                case 'new_event':
                    $time_line->push(new NewEvent($row));
                    break;
            }
        }

        return $time_line;
    }
}