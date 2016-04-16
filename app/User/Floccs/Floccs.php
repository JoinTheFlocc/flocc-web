<?php

namespace Flocc\User\Floccs;

use Flocc\Auth;
use Flocc\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Floccs
 *
 * @package Flocc\User\Floccs
 */
class Floccs extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_floccs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'email', 'time', 'activity_id', 'place', 'tribes'];

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
        return $this->id;
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
        $this->user_id = (int) $user_id;

        return $this;
    }

    /**
     * Set user email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
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
        $activity_id = (int) $activity_id;

        $this->activity_id = ($activity_id === 0) ? null : $activity_id;

        return $this;
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
        $this->place = empty($place) ? null : $place;

        return $this;
    }

    /**
     * Set tribes
     *
     * @param array $tribes
     * 
     * @return $this
     */
    public function setTribes(array $tribes)
    {
        $this->tribes = empty($tribes) ? null : implode(',', $tribes);

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
     * Get activity ID
     *
     * @return int|null
     */
    public function getActivityId()
    {
        return $this->activity_id;
    }

    /**
     * Get activity name
     *
     * @return string|null
     */
    public function getActivityName()
    {
        return $this->name;
    }

    /**
     * Get tribes
     * 
     * @return array
     */
    public function getTribes()
    {
        return ($this->tribes === null) ? [] : explode(',', $this->tribes);
    }

    /**
     * Get floccs members
     *
     * @param int|null $activity_id
     * @param string|null $place
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMembers($activity_id, $place, $limit = 5)
    {
        $users = self::select('user_id')->where('user_id', '<>', Auth::getUserId());

        if($activity_id !== null) {
            $users->where('activity_id', $activity_id);
        }

        if($place !== null) {
            $users->where('place', $place);
        }

        $users->take($limit);
        $users->groupBy('user_id');

        return User::whereIn('id', $users->get())->get();
    }

    /**
     * Get most popular floccs
     *
     * @param int $limit
     *
     * @return \Flocc\User\Floccs\Floccs
     */
    public function getPopular($limit = 1)
    {
        $user_id    = Auth::getUserId();
        $find       = self::select('users_floccs.id', 'activity_id', 'activities.name', 'place')
            ->leftjoin('activities', 'activities.id', '=', 'activity_id')
            ->leftjoin('users_floccs_settings', function($join) use($user_id) {
                $join->on('users_floccs_settings.flocc_id', '=', 'users_floccs.id');
                $join->on('users_floccs_settings.user_id', '=', \DB::raw($user_id));
                $join->on('users_floccs_settings.name', '=', \DB::raw('"hide_flocc"'));
            })
            ->whereNotNull('activity_id')
            ->whereNotNull('place')
            ->whereNull('users_floccs_settings.value')
            ->groupBy(\DB::raw('CONCAT(activity_id, place)'))
            ->orderBy(\DB::raw('count(*)'), 'desc')
            ->take($limit)
        ->get();

        return $find;
    }

    /**
     * Get by user ID
     *
     * @param int $user_id
     *
     * @return \Flocc\User\Floccs\Floccs|null
     */
    public function getByUserIdOrEmail($user_id, $email)
    {
        return self::where('user_id', (int) $user_id)->orWhere('email', $email)->take(1)->first();
    }
}