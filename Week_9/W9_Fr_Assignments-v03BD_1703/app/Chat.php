<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function participant()
    {
        return $this->belongsTo('App\Participant','id');
    }
}
