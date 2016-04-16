<?php

namespace Flocc\User\Floccs;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Settings
 *
 * @package Flocc\User\Floccs
 */
class Settings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_floccs_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'flocc_id', 'name', 'value'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set user ID
     *
     * @param int $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = (int) $user_id;

        return $this;
    }

    /**
     * Set flocc ID
     *
     * @param int $flocc_id
     *
     * @return $this
     */
    public function setFloccId($flocc_id)
    {
        $this->flocc_id = (int) $flocc_id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set value
     *
     * @param string $value
     * 
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}