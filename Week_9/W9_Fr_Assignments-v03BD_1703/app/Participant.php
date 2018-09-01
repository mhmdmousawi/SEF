<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public function chat()
    {
        return $this->hasMany('App\Chat','id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel','id');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile','profile_id');
    }
}
