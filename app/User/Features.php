<?php

namespace Flocc\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Features
 *
 * @package Flocc\User
 */
class Features extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_features';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'feature_id'];

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
     * @param int $feature_id
     *
     * @return static
     */
    public function addNew($user_id, $feature_id)
    {
        return self::create(['user_id' => (int) $user_id, 'feature_id' => (int) $feature_id]);
    }

    /**
     * Get feature ID
     *
     * @return int
     */
    public function getFeatureId()
    {
        return (int) $this->feature_id;
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
            $data[$row->getFeatureId()] = $row->getFeatureId();
        }

        return $data;
    }
}