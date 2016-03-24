<?php

namespace Flocc\Google\Places;

use Flocc\Google\Places\Autocomplete\Result;

/**
 * Class Autocomplete
 *
 * @package Flocc\Google\Places
 */
class Autocomplete
{
    private $output     = 'json';
    private $url        = 'https://maps.googleapis.com/maps/api/place/autocomplete/%s?%s';
    private $offset     = null;
    private $location   = null;
    private $radius     = null;
    private $language   = 'PL';
    private $types      = '(cities)';
    private $components = null;
    private $key;
    private $input;

    public function __construct()
    {
        $this->key = config('google.places.autocomplete.key');
    }

    /**
     * Get API key
     *
     * @return string
     */
    private function getApiKey()
    {
        return $this->key;
    }

    /**
     * Set input
     *
     * @param string $input
     *
     * @return $this
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get input
     *
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set offset
     *
     * @param null|int $offset
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = ($offset === null) ? null : (int) $offset;

        return $this;
    }

    /**
     * Get offset
     *
     * @return null|int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set location
     *
     * @param float $latitude
     * @param float $longitude
     *
     * @return $this
     */
    public function setLocation($latitude, $longitude)
    {
        $this->location = [$latitude, $longitude];

        return $this;
    }

    /**
     * Get location
     *
     * @return null|string
     */
    public function getLocation()
    {
        return ($this->location === null) ? null : implode(',', $this->location);
    }

    /**
     * Set radius
     *
     * @param int $radius
     *
     * @return $this
     */
    public function setRadius($radius)
    {
        $this->radius = (int) $radius;

        return $this;
    }

    /**
     * Get radius
     *
     * @return null|int
     */
    public function getRadius()
    {
        return $this->radius;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set types
     *
     * @param string $types
     *
     * @return $this
     */
    public function setTypes($types)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types
     *
     * @return string
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set components
     *
     * @param null|string $components
     *
     * @return $this
     */
    public function setComponents($components)
    {
        $this->components = $components;

        return $this;
    }

    /**
     * Get components
     *
     * @return null|string
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Get API url
     *
     * @return string
     */
    private function getUrl()
    {
        $parameters = [
            'input' => $this->getInput(),
            'key'   => $this->getApiKey()
        ];

        if($this->getOffset() !== null) {
            $parameters['offset'] = $this->getOffset();
        }

        if($this->getLocation() !== null) {
            $parameters['location'] = $this->getLocation();
        }

        if($this->getRadius() !== null) {
            $parameters['radius'] = $this->getRadius();
        }

        if($this->getLanguage() !== null) {
            $parameters['language'] = $this->getLanguage();
        }

        if($this->getTypes() !== null) {
            $parameters['types'] = $this->getTypes();
        }

        if($this->getComponents() !== null) {
            $parameters['components'] = $this->getComponents();
        }

        return sprintf($this->url, $this->output, http_build_query($parameters));
    }

    /**
     * Get results
     * 
     * @return Result
     *
     * @throws \Exception
     */
    public function get()
    {
        if(empty($this->getInput())) {
            throw new \Exception('Pusty input');
        }

        $output = json_decode(file_get_contents($this->getUrl()), true);

        return new Result($output);
    }
}