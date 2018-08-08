<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\User;
use App\Country;
use App\Itinerary;
use App\Activity;
use App\Comment;

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
        $rules = array(
          'title' => 'required|string|max:255',
          'country_id' => 'required|numeric',
          'user_id' => 'required|numeric',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();

            $arrres['code'] = 400;
            $arrres['message'] = "Create new itinerary failed!";
            $arrres['error'] = $errors;

            return json_encode($arrres);
        }
        else
        {
            $itinerary = new Itinerary;

            $itinerary->title = $request->title;
            $itinerary->country_id = $request->country_id;
            $itinerary->user_id = $request->user_id;

            $itinerary->save();

            $arrres['code'] = 200;
            $arrres['message'] = "New itinerary created.";
            $arrres['result'] = $itinerary;

            return json_encode($arrres);
        }
    }

    // List all Itinerary
    public function listItineraries()
    {
      $itineraries = Itinerary::with(['country','user'])->get();
      return $itineraries;
    }

    // List activities for an itinerary
    public function viewActivities(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $activities = Activity::where('itinerary_id', $itinerary_id)->get();
      return $activities;
    }
}
