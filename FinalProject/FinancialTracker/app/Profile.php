<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','id');
    }

    public function defaultCurrency()
    {
        return $this->belongsTo('App\Currency','default_currency_id');
    }

    public function categories()
    {
        return $this->hasMany('App\Category','profile_id','id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Category','profile_id','id');
    }
}
