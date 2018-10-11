<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    public function itinerary()
    {
      return $this->belongsTo('App\Itinerary');
    }

    public function budgettype()
    {
      return $this->belongsTo('App\BudgetType');
    }
}
