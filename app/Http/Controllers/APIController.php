<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\Itinerary;

class APIController extends Controller
{
    // List all country name
    public function listCountries()
    {
      $countries = Country::all();
      return $countries;
    }

    // Create new itinerary
    public function newItinerary(Request $request)
    {
      $itinerary = new Itinerary;

      $itinerary->title = $request->title;
      $itinerary->country_id = $request->country_id;
      $itinerary->backpacker_id = $request->backpacker_id;

      $itinerary->save();
    }
}
