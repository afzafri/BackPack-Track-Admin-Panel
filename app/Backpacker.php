<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Backpacker extends Model
{
    //
    public function itinerary()
    {
    	return $this->hasMany('App\Itinerary');
    }

    public function comment()
    {
    	return $this->hasMany('App\Comment');
    }

    public function country()
    {
    	return $this->belongsTo('App\Country');
    }
}
