<?php

namespace Flocc;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Places
 *
 * @package Flocc
 */
class Places extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'places';

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
     * Set parent ID
     *
     * @param int|null $parent_id
     *
     * @return $this
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * Get parent ID
     *
     * @return int|null
     */
    public function getParentId()
    {
        return $this->parent_id;
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
     * Get by ID
     *
     * @param int $id
     *
     * @return \Flocc\Places
     */
    public function getById($id)
    {
        return self::where('id', $id)->take(1)->first();
    }

    /**
     * Get place by name
     *
     * @param string $name
     *
     * @return false|\Flocc\Places
     */
    public function getByName($name)
    {
        return self::where('name', $name)->take(1)->first();
    }

    /**
     * Add new place
     *
     * @param string $name
     * @param null|int $parent_id
     *
     * @return static
     */
    public function addNew($name, $parent_id = null)
    {
        return self::create([
            'name'          => $name,
            'parent_id'     => $parent_id
        ]);
    }
}
