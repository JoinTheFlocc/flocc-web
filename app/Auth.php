<?php

namespace Flocc;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Auth
 *
 * @package Flocc
 */
class Auth extends Model
{
    /**
     * Get user ID
     *
     * @return int|null
     */
    public static function getUserId()
    {
        if(\Auth::user() !== null) {
            return (int) \Auth::user()->id;
        }

        return null;
    }
}