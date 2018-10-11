<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    //
    public function activity()
    {
    	return $this->hasMany('App\Activity');
    }
}
