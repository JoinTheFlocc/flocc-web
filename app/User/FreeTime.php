<?php

namespace Flocc\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FreeTime
 *
 * @package Flocc\User
 */
class FreeTime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_free_time';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'free_time_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Clear all features
     *
     * @param int $user_id
     *
     * @return mixed
     */
    public function clear($user_id)
    {
        return self::where('user_id', (int) $user_id)->delete();
    }

    /**
     * Add new features
     *
     * @param int $user_id
     * @param int $free_time_id
     *
     * @return static
     */
    public function addNew($user_id, $free_time_id)
    {
        return self::create(['user_id' => (int) $user_id, 'free_time_id' => (int) $free_time_id]);
    }

    /**
     * Get free time ID
     *
     * @return int
     */
    public function getFreeTimeId()
    {
        return (int) $this->free_time_id;
    }

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get ID's by user ID
     *
     * @param int $user_id
     *
     * @return array
     */
    public function getIdsByUserId($user_id)
    {
        $get    = self::where('user_id', (int) $user_id)->get();
        $data   = [];

        foreach($get as $row) {
            $data[$row->getFreeTimeId()] = $row->getFreeTimeId();
        }

        return $data;
    }
}