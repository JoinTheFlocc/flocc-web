<?php

namespace Flocc;

use Flocc\Searches\Top;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Searches
 *
 * @package Flocc
 */
class Searches extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'searches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'time', 'user_id', 'activity_id', 'place', 'tribes', 'post'];

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
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set user ID
     *
     * @param int|null $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get user ID
     *
     * @return int|null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set activity ID
     *
     * @param int|null $activity_id
     *
     * @return $this
     */
    public function setActivityId($activity_id)
    {
        $this->activity_id = $activity_id;

        return $this;
    }

    /**
     * Get activity ID
     *
     * @return int|null
     */
    public function getActivityId()
    {
        return $this->activity_id;
    }

    /**
     * Set place
     *
     * @param string|null $place
     *
     * @return $this
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string|null
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set tribes
     *
     * @param array|null $tribes
     *
     * @return $this
     */
    public function setTribes($tribes)
    {
        if($tribes !== null) {
            $this->tribes = json_encode($tribes);
        }

        return $this;
    }

    /**
     * Get tribes
     *
     * @return array|null
     */
    public function getTribes()
    {
        return ($this->tribes === null) ? null : json_decode($this->tribes);
    }

    /**
     * Set post data
     *
     * @param array $post
     *
     * @return $this
     */
    public function setPost(array $post)
    {
        $this->post = json_encode($post);

        return $this;
    }

    /**
     * Get post data
     *
     * @return array|null
     */
    public function getPost()
    {
        return ($this->post === null) ? null : json_decode($this->post);
    }

    /**
     * Get results count
     *
     * @return null|int
     */
    public function getCount()
    {
        return ($this->count === null) ? null : (int) $this->count;
    }

    /**
     * Get top
     *
     * @param int $limit
     *
     * @return Top
     */
    public function getTop($limit = 3)
    {
        $activities     = self::select('activity_id', \DB::raw('count(*) as count'))->whereNotNull('activity_id')->groupBy('activity_id')->orderBy(\DB::raw('count(*)'), 'desc')->take($limit)->get();
        $places         = self::select('place', \DB::raw('count(*) as count'))->whereNotNull('place')->groupBy('place')->orderBy(\DB::raw('count(*)'), 'desc')->take($limit)->get();
        $tribes         = self::whereNotNull('tribes')->get();

        return new Top($activities, $places, $tribes, $limit);
    }

    /**
     * Get top floccs
     *
     * @param int $limit
     *
     * @return array
     */
    public function getTopFloccs($limit = 3)
    {
        $find = self::select('activity_id', 'place', \DB::raw('count(*) as count'), \DB::raw('concat(activity_id, "_", place) as uniq_id'))
            ->whereNotNull('activity_id')
            ->whereNotNull('place')
            ->groupBy('uniq_id')
            ->orderBy('count', 'desc')
            ->take($limit)
        ->get();
        $floccs = [];

        foreach($find as $row) {
            $floccs[] = [
                'activity_id'   => $row->getActivityId(),
                'place'         => $row->getPlace(),
                'count'         => $row->getCount()
            ];
        }

        return $floccs;
    }
}
