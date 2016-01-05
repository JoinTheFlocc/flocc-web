<?php

namespace Flocc;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = ['firstname', 'lastname', 'description', 'avatar_url', 'status', 'user_id'];
    
    // FIXME: user_id should be protected, but Eloquent won't let constrained INSERT
    //protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo('Flocc\User', 'user_id');
    }
}
