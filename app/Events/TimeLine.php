<?php

namespace Flocc\Events;

use Flocc\Events\TimeLine\Comment;
use Flocc\Events\TimeLine\Message;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeLine
 *
 * @package Flocc\Events
 */
class TimeLine extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events_time_line';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'event_id', 'time', 'type', 'comment_id', 'message_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get time line by event ID
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByEventId($id)
    {
        $time_line  = new \Illuminate\Database\Eloquent\Collection();
        $get        = self::where('events_time_line.event_id', (int) $id)
            ->select('events_messages.message', 'events_comments.comment', 'events_comments.user_id', \DB::raw('concat(profiles.firstname, " ", profiles.lastname) as user_name'), 'profiles.avatar_url', 'events_time_line.id as time_line_id', 'events_time_line.time as time', 'events_time_line.type as type')
            ->leftjoin('events_messages', 'events_messages.id', '=', 'events_time_line.message_id')
            ->leftjoin('events_comments', 'events_comments.id', '=', 'events_time_line.comment_id')
            ->leftjoin('profiles', 'profiles.user_id', '=', 'events_comments.user_id')
            ->orderBy('events_time_line.id', 'desc')
        ->get();

        foreach($get as $row) {
            switch($row->type) {
                case 'message':
                    $time_line->push(new Message($row));
                    break;
                case 'comment':
                    $time_line->push(new Comment($row));
                    break;
            }
        }

        return $time_line;
    }

    /**
     * Add new
     *
     * @param array $data
     *
     * @return \Flocc\Events\TimeLine
     */
    public function addNew(array $data)
    {
        return self::create($data);
    }
}