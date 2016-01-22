<?php

namespace Flocc\Social\Facebook;

/**
 * Class MetaData
 *
 * @package Flocc\Social\Facebook
 */
class MetaData
{
    /**
     * @var string Current URL
     */
    private $url;

    /**
     * @var string Page type
     */
    private $type = 'website';

    /**
     * @var string Page title
     */
    private $title;

    /**
     * @var string Page description
     */
    private $description;

    /**
     * @var string Photo URL
     */
    private $image;

    /**
     * MetaData constructor
     */
    public function __construct()
    {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';

        /**
         * Current URL
         */
        $this->setUrl($protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    }

    /**
     * Set URL
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image URL
     *
     * @param string $image
     *
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image URL
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}