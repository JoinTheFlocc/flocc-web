<?php

namespace Flocc\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Settings
 *
 * @package Flocc\User
 */
class Settings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'name', 'value'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get settings
     *
     * @param int $user_id
     * @param string $name
     * @param null|string $default_value
     *
     * @return null|string
     */
    public function get($user_id, $name, $default_value = null)
    {
        $get = self::where('user_id', (int) $user_id)->where('name', $name)->take(1)->first();

        if($get === null) {
            return $default_value;
        }

        return $get->getValue();
    }

    /**
     * Remove settings
     *
     * @param int $user_id
     * @param string $name
     *
     * @return bool
     */
    public function remove($user_id, $name)
    {
        return (self::where('user_id', (int) $user_id)->where('name', $name)->delete() == 1);
    }

    /**
     * Set settings
     *
     * @param int $user_id
     * @param string $name
     * @param string $value
     *
     * @return static
     */
    public function set($user_id, $name, $value)
    {
        $this->remove($user_id, $name);

        return self::create([
            'user_id'   => (int) $user_id,
            'name'      => $name,
            'value'     => $value
        ]);
    }
}