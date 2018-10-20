<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\APIController;
use App\Itinerary;
use App\Activity;
use App\Country;

class PublicItineraryController extends Controller
{
    //
    public function view(Request $request)
    {
      // get activities
      $APIobj = new APIController();
      $result = json_decode($APIobj->viewActivitiesByDay($request));

      return json_encode($result);
    }
}
