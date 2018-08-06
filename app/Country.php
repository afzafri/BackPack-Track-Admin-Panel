<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    public function itinerary()
    {
    	return $this->hasMany('App\Itinerary');
    }

    public function backpacker()
    {
      return $this->hasMany('App\Backpacker');
    }
}
