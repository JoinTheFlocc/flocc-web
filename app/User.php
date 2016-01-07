<?php

namespace Flocc;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'activation_code', 'active'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
                                        
    public function profile() 
    {
        return $this->hasOne('Flocc\Profile');
    }
    public function socialProvider()
    {
        return $this->hasOne('Flocc\SocialProvider');
    }

    /**
     * Get user by ID
     *
     * @param int $user_id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getById($user_id)
    {
        return self::where('id', (int) $user_id)->take(1)->first();
    }
}
