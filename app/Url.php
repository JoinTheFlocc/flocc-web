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
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if(empty($text)) {
            return '';
        }

        return $text;
    }
}