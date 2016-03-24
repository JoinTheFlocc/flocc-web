<?php

namespace Flocc\Google\Places\Autocomplete;

use Flocc\Google\Places\Autocomplete\Predictions\Term;

/**
 * Class Prediction
 *
 * @package Flocc\Google\Places\Autocomplete
 */
class Prediction
{
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->data['id'];
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->data['description'];
    }

    /**
     * Get place ID
     *
     * @return string
     */
    public function getPlaceId()
    {
        return $this->data['place_id'];
    }

    /**
     * Get types
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->data['types'];
    }

    /**
     * Get array
     * 
     * @return array
     */
    public function getTerms()
    {
        $terms = [];

        foreach($this->data['terms'] as $type) {
            $terms[] = new Term($type);
        }

        return $terms;
    }
}