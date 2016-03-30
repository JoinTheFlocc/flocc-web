<?php

namespace Flocc\Google\Places\Autocomplete\Predictions;

/**
 * Class Term
 *
 * @package Flocc\Google\Places\Autocomplete\Predictions
 */
class Term
{
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get offset
     *
     * @return string
     */
    public function getOffset()
    {
        return $this->data['offset'];
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->data['value'];
    }
}