<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function itinerary()
    {
      return $this->belongsTo('App\Itinerary');
    }

    public function backpacker()
    {
      return $this->belongsTo('App\Backpacker');
    }
}
