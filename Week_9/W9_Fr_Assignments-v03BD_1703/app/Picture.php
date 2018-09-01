<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function profile()
    {
        return $this->belongsTo('App\Profile','profile_id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel','id');
    }
}
