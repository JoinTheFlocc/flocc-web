<?php

namespace Flocc;

/**
 * Class Url
 *
 * @package Flocc
 */
class Url
{
    /**
     * Create slug from string
     *
     * @param string $text
     *
     * @return string
     */
    public function slug($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);

        if(empty($text)) {
            return '';
        }

        return $text;
    }
}