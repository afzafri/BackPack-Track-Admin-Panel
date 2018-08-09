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

            $result['code'] = 400;
            $result['message'] = "Create new itinerary failed!";
            $result['error'] = $errors;

            return json_encode($result);
        }
        else
        {
            $itinerary = new Itinerary;

            $itinerary->title = $request->title;
            $itinerary->country_id = $request->country_id;
            $itinerary->user_id = $request->user_id;

            $itinerary->save();

            $result['code'] = 200;
            $result['message'] = "New itinerary created.";
            $result['result'] = $itinerary;

            return json_encode($result);
        }
    }

    // List all Itinerary
    public function listItineraries()
    {
      $itineraries = Itinerary::with(['country','user'])->get();
      return $itineraries;
    }

    // List itineraries for specific country
    public function listItinerariesByCountry(Request $request)
    {
      $country_id = $request->country_id;

      $itineraries = Itinerary::with(['country','user'])->where('country_id', $country_id)->get();
      return $itineraries;
    }

    // List itineraries for specific user
    public function listItinerariesByUser(Request $request)
    {
      $user_id = $request->user_id;

      $itineraries = Itinerary::with(['country','user'])->where('user_id', $user_id)->get();
      return $itineraries;
    }

    // Create new activity
    public function newActivity(Request $request)
    {
        $rules = array(
          'date' => 'required|date',
          'time' => 'required|date_format:"H:i"',
          'activity' => 'required|string|max:255',
          'description' => 'required|string|max:255',
          'place_name' => 'required|string|max:255',
          'lat' => 'required|string|max:255',
          'lng' => 'required|string|max:255',
          'itinerary_id' => 'required|numeric',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();

            $result['code'] = 400;
            $result['message'] = "Create new activity failed!";
            $result['error'] = $errors;

            return json_encode($result);
        }
        else
        {
            $activity = new Activity;

            $activity->date = $request->date;
            $activity->time = $request->time;
            $activity->activity = $request->activity;
            $activity->description = $request->description;
            $activity->place_name = $request->place_name;
            $activity->lat = $request->lat;
            $activity->lng = $request->lng;
            $activity->budget = $request->budget;
            $activity->pic_url = $request->pic_url;
            $activity->itinerary_id = $request->itinerary_id;

            $activity->save();

            $result['code'] = 200;
            $result['message'] = "New activity created.";
            $result['result'] = $activity;

            return json_encode($result);
        }
    }

    // List activities for an itinerary
    public function viewActivities(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $itinerary = Itinerary::with(['user','country'])->find($itinerary_id);
      $activities = Activity::where('itinerary_id', $itinerary_id)->get();

      $result['itinerary'] = $itinerary;
      $result['activities'] = $activities;

      return json_encode($result);
    }

    // Get list of dates and no of day trip
    public function getDayDates(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $dates = Activity::distinct()->where('itinerary_id', $itinerary_id)->get(['date']);
      $nodays = count($dates);
      $nonight = $nodays > 0 ? ($nodays-1) : 0;
      $duration = $nodays."D".$nonight."N";

      $result['itinerary_id'] = $itinerary_id;
      $result['dates'] = $dates;
      $result['no_days'] = $nodays;
      $result['no_night'] = $nonight;
      $result['trip_duration'] = $duration;

      return json_encode($result);
    }

    // Get total budget for an Itinerary
    public function getTotalBudget(Request $request)
    {
      $itinerary_id = $request->itinerary_id;
      $budgets = Activity::where('itinerary_id', $itinerary_id)->get(['activity','budget']);
      $totalbudget = Activity::where('itinerary_id', $itinerary_id)->sum('budget');

      $result['itinerary_id'] = $itinerary_id;
      $result['budgets'] = $budgets;
      $result['totalbudget'] = $totalbudget;

      return json_encode($result);
    }

    // Post new comment to an itinerary
    public function newComment(Request $request)
    {
      $rules = array(
        'message' => 'required|string|max:255',
        'user_id' => 'required|numeric',
        'itinerary_id' => 'required|numeric',
      );

      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
          $errors = $validator->errors();

          $result['code'] = 400;
          $result['message'] = "Comment not posted!";
          $result['error'] = $errors;

          return json_encode($result);
      }
      else
      {
          $comment = new Comment;

          $comment->message = $request->message;
          $comment->user_id = $request->user_id;
          $comment->itinerary_id = $request->itinerary_id;

          $comment->save();

          $result['code'] = 200;
          $result['message'] = "Comment posted.";
          $result['result'] = $comment;

          return json_encode($result);
      }
    }
}
