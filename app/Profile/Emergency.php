<?php

namespace Flocc\Profile;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Emergency
 *
 * @package Flocc\Profile
 */
class Emergency extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profiles_emergency';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Set ID
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
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get by name
     *
     * @param string $name
     *
     * @return self
     */
    public function getByName($name)
    {
        return self::where('name', $name)->take(1)->first();
    }

    /**
     * Add new activity
     *
     * @param string $name
     *
     * @return int
     */
    public function addNew($name)
    {
        self::create(['name' => $name]);

        return (int) \DB::getPdo()->lastInsertId();
    }
}
