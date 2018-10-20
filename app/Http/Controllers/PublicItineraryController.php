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
      $coordinates = json_decode($APIobj->getLatLng($request));
      $comments = json_decode($APIobj->listComments($request));

      return view('public_itinerary', ['data' => $result, 'coordinates' => $coordinates, 'comments' => $comments]);
    }
}
