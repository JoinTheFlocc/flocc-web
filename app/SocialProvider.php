<?php

namespace Flocc;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    protected $table = 'social_providers';
    protected $fillable = ['provider', 'provider_id', 'user_id'];
    
    // FIXME: user_id should be protected, but Eloquent won't let constrained INSERT
    //protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo('Flocc\User', 'user_id');
    }
}
