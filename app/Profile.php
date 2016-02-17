<?php

namespace Flocc;

use Flocc\Profile\TimeLine\TimeLine;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = ['firstname', 'lastname', 'description', 'avatar_url', 'status', 'user_id'];
    
    // FIXME: user_id should be protected, but Eloquent won't let constrained INSERT
    //protected $hidden = ['user_id'];

    /**
     * Get profile ID
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
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
     * Get user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUser()
    {
        return $this->belongsTo('Flocc\User', 'user_id');
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastname;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get avatar URL
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return 'http://a.deviantart.net/avatars/a/v/avatar239.jpg?2'; //$this->avatar_url;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get user time line
     *
     * @param string $type
     * @param int $start
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTimeLine($type = 'all', $start = 0, $limit = 10)
    {
        return (new TimeLine())->getByUserId($this->getUserId(), $type, $start, $limit);
    }
}
