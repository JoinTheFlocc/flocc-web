<?php

namespace Flocc\Google\Places\Autocomplete;

/**
 * Class Result
 *
 * @package Flocc\Google\Places\Autocomplete
 */
class Result
{
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return isset($this->data['status']) ? $this->data['status'] : 'FAIL';
    }

    /**
     * Get predictions
     *
     * @return array
     */
    public function getPredictions()
    {
        $predictions = [];

        if(isset($this->data['predictions'])) {
            foreach($this->data['predictions'] as $prediction) {
                $predictions[] = new Prediction($prediction);
            }
        }

        return $predictions;
    }
}