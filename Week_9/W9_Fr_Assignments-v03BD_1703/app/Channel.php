<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function profile()
    {
        return $this->belongsTo('App\Profile','profile_id');
    }

    public function participant()
    {
        return $this->hasMany('App\Participant','id');
    }

    public function picture()
    {
        return $this->hasOne('App\Picture','id');
    }
}
