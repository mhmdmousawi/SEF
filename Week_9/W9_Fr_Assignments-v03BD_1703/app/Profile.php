<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','id');
    }

    public function channel()
    {
        return $this->hasMany('App\Channel','creator_id');
    }

    public function participant()
    {
        return $this->hasMany('App\Participant','profile_id');
    }

    public function picture()
    {
        return $this->hasOne('App\Picture','id');
    }
}
