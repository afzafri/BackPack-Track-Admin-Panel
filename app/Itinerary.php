<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    //
    public function country()
    {
      return $this->belongsTo('App\Country');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function activity()
    {
      return $this->hasMany('App\Activity');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }
}
