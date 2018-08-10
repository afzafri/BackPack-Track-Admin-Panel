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

    // Update itinerary
    public function updateItinerary(Request $request)
    {
      $rules = array(
        'title' => 'required|string|max:255',
        'country_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'itinerary_id' => 'required|numeric',
      );

      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
          $errors = $validator->errors();

          $result['code'] = 400;
          $result['message'] = "Update itinerary failed!";
          $result['error'] = $errors;

          return json_encode($result);
      }
      else
      {
          $itinerary_id = $request->itinerary_id;
          $itinerary = Itinerary::find($itinerary_id);

          $itinerary->title = $request->title;
          $itinerary->country_id = $request->country_id;
          $itinerary->user_id = $request->user_id;

          $itinerary->save();

          $result['code'] = 200;
          $result['message'] = "Itinerary updated.";
          $result['result'] = $itinerary;

          return json_encode($result);
      }
    }

    // Delete an Itinerary
    public function deleteItinerary(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      // Delete the itinerary
      $itinerary = Itinerary::find($itinerary_id);
      $itinerary->delete();

      // Delete the activities
      $activities = Activity::where('itinerary_id', $itinerary_id)->delete();

      $result['code'] = 200;
      $result['message'] = "Itinerary deleted.";
      $result['result']['itinerary'] = $itinerary;
      $result['result']['activities'] = $activities;

      return json_encode($result);
    }

    // List all Itinerary
    public function listItineraries()
    {
      $itineraries = Itinerary::with(['country','user'])->get();
      return $itineraries;
    }

    // View specific itinerary
    public function viewItinerary(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $itinerary = Itinerary::with(['country','user'])->find($itinerary_id);
      return $itinerary;
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
          'image' => 'image',
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
            $pic_url = "";

            if($request->hasFile('image'))
            {
              $pic_url = $request->file('image')->store('images/activities', 'public');
            }

            $activity = new Activity;

            $activity->date = $request->date;
            $activity->time = $request->time;
            $activity->activity = $request->activity;
            $activity->description = $request->description;
            $activity->place_name = $request->place_name;
            $activity->lat = $request->lat;
            $activity->lng = $request->lng;
            $activity->budget = $request->budget;
            $activity->pic_url = asset('storage/'.$pic_url);
            $activity->itinerary_id = $request->itinerary_id;

            $activity->save();

            $result['code'] = 200;
            $result['message'] = "New activity created.";
            $result['result'] = $activity;

            return json_encode($result);
        }
    }

    // Update an Activity
    public function updateActivity(Request $request)
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
          'activity_id' => 'required|numeric',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();

            $result['code'] = 400;
            $result['message'] = "Update activity failed!";
            $result['error'] = $errors;

            return json_encode($result);
        }
        else
        {
            $activity_id = $request->activity_id;
            $activity = Activity::find($activity_id);

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
            $result['message'] = "Activity updated.";
            $result['result'] = $activity;

            return json_encode($result);
        }
    }

    // Delete an Activity
    public function deleteActivity(Request $request)
    {
      $activity_id = $request->activity_id;

      $activity = Activity::find($activity_id);
      $activity->delete();

      $result['code'] = 200;
      $result['message'] = "Activity deleted.";
      $result['result'] = $activity;

      return json_encode($result);
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

    // Get total budget for each day of Itinerary
    public function getTotalBudgetPerDay(Request $request)
    {
      $itinerary_id = $request->itinerary_id;
      $dates = json_decode($this->getDayDates($request), true)['dates'];
      $result['itinerary_id'] = $itinerary_id;

      $i = 0;
      foreach ($dates as $date)
      {
        $parseDate = $date['date'];

        $totalbudget = Activity::where([['itinerary_id', $itinerary_id],['date', $parseDate]])->sum('budget');

        $result['detail'][$i]['day'] = "Day ".($i+1);
        $result['detail'][$i]['date'] = $parseDate;
        $result['detail'][$i]['totalBudget'] = $totalbudget;
        $i++;
      }

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

    // List all comments for an itinerary
    public function listComments(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $itinerary = Itinerary::with(['user','country'])->find($itinerary_id);
      $comments = Comment::with(['user'])->where('itinerary_id', $itinerary_id)->get();

      $result['itinerary'] = $itinerary;
      $result['comments'] = $comments;

      return json_encode($result);
    }

    // List all comments by specific user
    public function listCommentsByUser(Request $request)
    {
      $user_id = $request->user_id;

      $comments = Comment::with(['user','itinerary'])->where('user_id', $user_id)->get();
      return $comments;
    }
}
