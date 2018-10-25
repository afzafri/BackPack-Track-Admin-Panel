<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Validator;
use Storage;
use DB;

use App\User;
use App\Country;
use App\Itinerary;
use App\Activity;
use App\Like;
use App\Comment;
use App\Article;
use App\BudgetType;

class APIController extends Controller
{
    // List all country name
    public function listCountries()
    {
      $countries = Country::get(['id','code','name']);
      return $countries;
    }

    // Create new itinerary
    public function newItinerary(Request $request)
    {
        $rules = array(
          'title' => 'required|string|max:255',
          'country_id' => 'required|numeric',
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
            $itinerary->user_id = Auth::user()->id;

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

          $user_id = "";
          if($request->has('user_id'))
          {
            $user_id = $request->user_id;
          }
          else
          {
            $user_id = Auth::user()->id;
          }
          $itinerary->user_id = $user_id;

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
      // Delete all images
      $pic_urls = json_decode(Activity::where('itinerary_id', $itinerary_id)->get(['pic_url']), true);
      foreach ($pic_urls as $pic_url)
      {
        $pic_msg = $this->deletePhoto($pic_url['pic_url']);
      }

      // Delete the data
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
      $itineraries = Itinerary::with(['country','user'])->orderBy('id', 'DESC')->get();

      // Transform collection to include the durations and total budgets for each itinerary
      $itineraries->transform(function ($itinerary){

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['itinerary_id' => $itinerary->id]);

        $duration = json_decode($this->getDayDates($newReq),true)['trip_duration'];
        $totalbudget = json_decode($this->getTotalBudget($newReq),true)['totalbudget'];
        $totallikes = json_decode($this->getTotalLikes($newReq),true);
        $totalcomments = json_decode($this->getTotalComments($newReq),true);
        $isLiked = $this->isLiked(Auth::user()->id, $itinerary->id);

        $itinerary->duration = $duration;
        $itinerary->totalbudget = $totalbudget;
        $itinerary->totallikes = $totallikes;
        $itinerary->totalcomments = $totalcomments;
        $itinerary->isLiked = $isLiked;

        return $itinerary;
      });

      return $itineraries;
    }

    // List all Itinerary in pages
    public function listItinerariesPaginated()
    {
      $numdata = 5; // set total contents to display per page
      $itineraries = Itinerary::with(['country','user'])->orderBy('id', 'DESC')->paginate($numdata);

      // Transform collection to include the durations and total budgets for each itinerary
      $itineraries->getCollection()->transform(function ($itinerary){

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['itinerary_id' => $itinerary->id]);

        $duration = json_decode($this->getDayDates($newReq),true)['trip_duration'];
        $totalbudget = json_decode($this->getTotalBudget($newReq),true)['totalbudget'];
        $totallikes = json_decode($this->getTotalLikes($newReq),true);
        $totalcomments = json_decode($this->getTotalComments($newReq),true);
        $isLiked = $this->isLiked(Auth::user()->id, $itinerary->id);

        $itinerary->duration = $duration;
        $itinerary->totalbudget = $totalbudget;
        $itinerary->totallikes = $totallikes;
        $itinerary->totalcomments = $totalcomments;
        $itinerary->isLiked = $isLiked;

        return $itinerary;
      });

      return $itineraries;
    }

    // View specific itinerary
    public function viewItinerary(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $itinerary = Itinerary::with(['country','user'])->find($itinerary_id);
      return $itinerary;
    }

    // View specific itinerary data, with full details
    public function viewItineraryDetails(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $itinerary = Itinerary::with(['country','user'])->find($itinerary_id);

      $duration = json_decode($this->getDayDates($request),true)['trip_duration'];
      $totalbudget = json_decode($this->getTotalBudget($request),true)['totalbudget'];
      $totallikes = json_decode($this->getTotalLikes($request),true);
      $totalcomments = json_decode($this->getTotalComments($request),true);
      $isLiked = $this->isLiked(Auth::user()->id, $itinerary->id);

      $itinerary->duration = $duration;
      $itinerary->totalbudget = $totalbudget;
      $itinerary->totallikes = $totallikes;
      $itinerary->totalcomments = $totalcomments;
      $itinerary->isLiked = $isLiked;

      return $itinerary;
    }

    // List itineraries for specific country
    public function listItinerariesByCountry(Request $request)
    {
      $country_id = $request->country_id;
      $numdata = 5; // set total contents to display per page
      $itineraries = Itinerary::with(['country','user'])->where('country_id', $country_id)->orderBy('id', 'DESC')->paginate($numdata);

      // Transform collection to include the durations and total budgets for each itinerary
      $itineraries->getCollection()->transform(function ($itinerary){

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['itinerary_id' => $itinerary->id]);

        $duration = json_decode($this->getDayDates($newReq),true)['trip_duration'];
        $totalbudget = json_decode($this->getTotalBudget($newReq),true)['totalbudget'];
        $totallikes = json_decode($this->getTotalLikes($newReq),true);
        $totalcomments = json_decode($this->getTotalComments($newReq),true);
        $isLiked = $this->isLiked(Auth::user()->id, $itinerary->id);

        $itinerary->duration = $duration;
        $itinerary->totalbudget = $totalbudget;
        $itinerary->totallikes = $totallikes;
        $itinerary->totalcomments = $totalcomments;
        $itinerary->isLiked = $isLiked;

        return $itinerary;
      });

      return $itineraries;
    }

    // List itineraries for auth user
    public function listItinerariesByAuthUser()
    {
      $user_id = Auth::user()->id;
      $numdata = 5; // set total contents to display per page
      $itineraries = Itinerary::with(['country','user'])->where('user_id', $user_id)->orderBy('id', 'DESC')->paginate($numdata);

      // Transform collection to include the durations and total budgets for each itinerary
      $itineraries->getCollection()->transform(function ($itinerary){

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['itinerary_id' => $itinerary->id]);

        $duration = json_decode($this->getDayDates($newReq),true)['trip_duration'];
        $totalbudget = json_decode($this->getTotalBudget($newReq),true)['totalbudget'];
        $totallikes = json_decode($this->getTotalLikes($newReq),true);
        $totalcomments = json_decode($this->getTotalComments($newReq),true);
        $isLiked = $this->isLiked(Auth::user()->id, $itinerary->id);

        $itinerary->duration = $duration;
        $itinerary->totalbudget = $totalbudget;
        $itinerary->totallikes = $totallikes;
        $itinerary->totalcomments = $totalcomments;
        $itinerary->isLiked = $isLiked;

        return $itinerary;
      });

      return $itineraries;
    }

    // List itineraries for specific user, by ID
    public function listItinerariesByUser(Request $request)
    {
      $user_id = $request->user_id;
      $itineraries = Itinerary::with(['country','user'])->where('user_id', $user_id)->orderBy('id', 'DESC')->get();

      // Transform collection to include the durations and total budgets for each itinerary
      $itineraries->transform(function ($itinerary){

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['itinerary_id' => $itinerary->id]);

        $duration = json_decode($this->getDayDates($newReq),true)['trip_duration'];
        $totalbudget = json_decode($this->getTotalBudget($newReq),true)['totalbudget'];
        $totallikes = json_decode($this->getTotalLikes($newReq),true);
        $totalcomments = json_decode($this->getTotalComments($newReq),true);

        $itinerary->duration = $duration;
        $itinerary->totalbudget = $totalbudget;
        $itinerary->totallikes = $totallikes;
        $itinerary->totalcomments = $totalcomments;

        return $itinerary;
      });

      return $itineraries;
    }

    // List itineraries for specific user, by ID
    public function listItinerariesByUserPaginated(Request $request)
    {
      $user_id = $request->user_id;
      $numdata = 5; // set total contents to display per page
      $itineraries = Itinerary::with(['country','user'])->where('user_id', $user_id)->orderBy('id', 'DESC')->paginate($numdata);

      // Transform collection to include the durations and total budgets for each itinerary
      $itineraries->getCollection()->transform(function ($itinerary){

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['itinerary_id' => $itinerary->id]);

        $duration = json_decode($this->getDayDates($newReq),true)['trip_duration'];
        $totalbudget = json_decode($this->getTotalBudget($newReq),true)['totalbudget'];
        $totallikes = json_decode($this->getTotalLikes($newReq),true);
        $totalcomments = json_decode($this->getTotalComments($newReq),true);
        $isLiked = $this->isLiked(Auth::user()->id, $itinerary->id);

        $itinerary->duration = $duration;
        $itinerary->totalbudget = $totalbudget;
        $itinerary->totallikes = $totallikes;
        $itinerary->totalcomments = $totalcomments;
        $itinerary->isLiked = $isLiked;

        return $itinerary;
      });

      return $itineraries;
    }

    // Search itineraries by title
    public function searchItineraries(Request $request)
    {
      $searchTitle = $request->title;
      $numdata = 5; // set total contents to display per page
      $itineraries = Itinerary::with(['country','user'])->where('title', 'like', '%' . $searchTitle . '%')->orderBy('id', 'DESC')->paginate($numdata);

      // Transform collection to include the durations and total budgets for each itinerary
      $itineraries->getCollection()->transform(function ($itinerary){

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['itinerary_id' => $itinerary->id]);

        $duration = json_decode($this->getDayDates($newReq),true)['trip_duration'];
        $totalbudget = json_decode($this->getTotalBudget($newReq),true)['totalbudget'];
        $totallikes = json_decode($this->getTotalLikes($newReq),true);
        $totalcomments = json_decode($this->getTotalComments($newReq),true);
        $isLiked = $this->isLiked(Auth::user()->id, $itinerary->id);

        $itinerary->duration = $duration;
        $itinerary->totalbudget = $totalbudget;
        $itinerary->totallikes = $totallikes;
        $itinerary->totalcomments = $totalcomments;
        $itinerary->isLiked = $isLiked;

        return $itinerary;
      });

      return $itineraries;
    }

    // List Countries that have been visited only
    public function listVisitedCountries()
    {
      $numdata = 6;
      $countries = Country::has('itinerary')->paginate($numdata);
      return $countries;
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
              $pic_url = asset('storage/'.$pic_url);
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
            $activity->budgettype_id = $request->budgettype_id;
            $activity->pic_url = $pic_url;
            $activity->itinerary_id = $request->itinerary_id;

            $activity->save();

            $result['code'] = 200;
            $result['message'] = "New activity created.";
            $result['result'] = $activity;

            return json_encode($result);
        }
    }

    // View an Activity
    public function viewActivity(Request $request)
    {
        $activity_id = $request->activity_id;
        $activity = Activity::with(['budgettype'])->find($activity_id);

        return $activity;
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

            $pic_url = $activity->pic_url;

            if($request->hasFile('image'))
            {
              // Get old pic
              $old_image = $pic_url;

              // Upload new pic
              $pic_url = $request->file('image')->store('images/activities', 'public');
              $pic_url = asset('storage/'.$pic_url);

              // Delete old pic file
              $del_pic = $this->deletePhoto($old_image);
            }

            $activity->date = $request->date;
            $activity->time = $request->time;
            $activity->activity = $request->activity;
            $activity->description = $request->description;
            $activity->place_name = $request->place_name;
            $activity->lat = $request->lat;
            $activity->lng = $request->lng;
            $activity->budget = $request->budget;
            $activity->budgettype_id = $request->budgettype_id;
            $activity->pic_url = $pic_url;
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

      // delete image
      $pic_url = $activity->pic_url;
      $pic_msg = $this->deletePhoto($pic_url);

      // delete data
      $activity->delete();

      $result['code'] = 200;
      $result['message'] = "Activity deleted. ".$pic_msg;
      $result['result'] = $activity;

      return json_encode($result);
    }

    // delete photo
    public function deletePhoto($url)
    {
      $baseurl = asset('/').'storage/';
      $result = Storage::disk('public')->delete(str_replace($baseurl,'',$url));

      if($result)
        return "File deleted";
      else
        return "File delete failed.";
    }

    // List activities for an itinerary
    public function viewActivities(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      // get itinerary info and all the activities
      $itinerary = Itinerary::with(['user','country'])->find($itinerary_id);
      $activities = Activity::with(['budgettype'])->where('itinerary_id', $itinerary_id)->get();

      // get total budget
      $totalbudget = json_decode($this->getTotalBudget($request), true)['totalbudget'];

      $result = $itinerary;
      $result['activities'] = $activities;
      $result['totalbudget'] = $totalbudget;

      return json_encode($result);
    }

    // List activities for an itinerary by day
    public function viewActivitiesByDay(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      // get itinerary info and all the activities
      $itinerary = Itinerary::with(['user','country'])->find($itinerary_id);
      $activities = Activity::with(['budgettype'])->where('itinerary_id', $itinerary_id)->get()->groupBy("date");

      // get total budget
      $totalbudget = json_decode($this->getTotalBudget($request), true)['totalbudget'];

      $result = $itinerary;
      $result['activities'] = $activities;
      $result['totalbudget'] = $totalbudget;

      return json_encode($result);
    }

    // List activites for an itinerary paginated
    public function viewActivitiesPaginated(Request $request)
    {
      $itinerary_id = $request->itinerary_id;
      $numdata = 5;

      // get Itineraries
      $itinerary = Itinerary::with(['user','country'])->find($itinerary_id);
      $country = collect(['country' => $itinerary->country]);

      // get all the activities
      $activities = Activity::with(['budgettype'])->orderBy('id', 'DESC')->where('itinerary_id', $itinerary_id)->paginate($numdata);
      // include country info into the activities
      $newActivities = $country->merge($activities);

      return $newActivities;
    }

    // List all activities photos for an itinerary
    public function listItineraryImages(Request $request)
    {
      $itinerary_id = $request->itinerary_id;
      $activities_photos = Activity::where([['itinerary_id', $itinerary_id], ['pic_url','<>','']])->get(['id','activity','pic_url']);

      return $activities_photos;
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

    // Get list of all latitudes and longitudes corrdinate of activities
    public function getLatLng(Request $request)
    {
      $itinerary_id = $request->itinerary_id;
      $coordinates = Activity::where('itinerary_id', $itinerary_id)->get(['place_name','activity','lat','lng']);

      return $coordinates;
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
      $grandTotal = 0;
      foreach ($dates as $date)
      {
        $parseDate = $date['date'];

        $totalbudget = Activity::where([['itinerary_id', $itinerary_id],['date', $parseDate]])->sum('budget');

        $result['detail'][$i]['day'] = "Day ".($i+1);
        $result['detail'][$i]['date'] = $parseDate;
        $result['detail'][$i]['totalBudget'] = $totalbudget;
        $grandTotal += $totalbudget;
        $i++;
      }

      // grand total of all budget spend
      $result['grandTotal'] = $grandTotal;

      // currency of the country
      $currency = (Itinerary::with('country')->find($itinerary_id))->country->currency;
      $result['currency'] = $currency;

      return json_encode($result);
    }

    // List all budget types
    public function listBudgetTypes()
    {
      $budgets = BudgetType::get(['id','type']);
      return $budgets;
    }

    // List total budget for each budget types for an itinerary
    public function getTotalBudgetPerType(Request $request)
    {
      $itinerary_id = $request->itinerary_id;
      $result['itinerary_id'] = $itinerary_id;

      $budgets = DB::table('activities')
                 ->select('budgettype_id', DB::raw('sum(budget) as totalBudget'))
                 ->where('itinerary_id', $itinerary_id)
                 ->groupBy('budgettype_id')
                 ->get();

      $i = 0;
      $grandtotal = 0;
      foreach ($budgets as $budget)
      {
        $budget->budget_type = (BudgetType::find($budget->budgettype_id))->type;
        $result['detail'][$i] = $budget;
        $grandtotal += $budget->totalBudget;

        $i++;
      }

      // grand total of all budget spend
      $result['grandTotal'] = $grandtotal;

      // currency of the country
      $currency = (Itinerary::with('country')->find($itinerary_id))->country->currency;
      $result['currency'] = $currency;

      return json_encode($result);
    }

    // Post new comment to an itinerary
    public function newComment(Request $request)
    {
      $rules = array(
        'message' => 'required|string|max:255',
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
          $comment->user_id = Auth::user()->id;
          $comment->itinerary_id = $request->itinerary_id;

          $comment->save();

          $result['code'] = 200;
          $result['message'] = "Comment posted.";
          $result['result'] = $comment;

          return json_encode($result);
      }
    }

    // Delete a comment
    public function deleteComment(Request $request)
    {
      $comment_id = $request->comment_id;

      $comment = Comment::find($comment_id);

      // delete data
      $comment->delete();

      $result['code'] = 200;
      $result['message'] = "Comment deleted.";

      return json_encode($result);
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

    // List all comments for an itinerary in pages
    public function listCommentsPaginated(Request $request)
    {
      $itinerary_id = $request->itinerary_id;
      $numdata = 10;

      $comments = Comment::with(['user'])->where('itinerary_id', $itinerary_id)->paginate($numdata);

      return json_encode($comments);
    }

    // List all comments by specific user
    public function listCommentsByUser(Request $request)
    {
      $user_id = $request->user_id;

      $comments = Comment::with(['user','itinerary'])->where('user_id', $user_id)->orderBy('id', 'DESC')->get();
      return $comments;
    }

    // Get total comments for an itinerary
    public function getTotalComments(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $totalcomments = Comment::where('itinerary_id', $itinerary_id)->count();
      return $totalcomments;
    }

    // Like an itinerary
    public function likeItinerary(Request $request)
    {
      $user_id = Auth::user()->id;
      $itinerary_id = $request->itinerary_id;

      // only like if user never like the itinerary before
      if (!$this->isLiked($user_id, $itinerary_id))
      {
        $like = new Like;
        $like->user_id = $user_id;
        $like->itinerary_id = $itinerary_id;
        $like->save();

        $result['code'] = 200;
        $result['message'] = "liked.";
        $result['result'] = $like;

        return json_encode($result);
      }
      else
      {
        $result['code'] = 400;
        $result['message'] = "You already liked this itinerary.";

        return json_encode($result);
      }
    }

    // Unlike an itinerary
    public function unlikeItinerary(Request $request)
    {
      $user_id = Auth::user()->id;
      $itinerary_id = $request->itinerary_id;

      $like = Like::where([['user_id', $user_id], ['itinerary_id', $itinerary_id]])->delete();

      $result['code'] = 200;
      $result['message'] = "unliked.";
      $result['result'] = $like;

      return json_encode($result);
    }

    // Get total number of likes for an itinerary
    public function getTotalLikes(Request $request)
    {
      $itinerary_id = $request->itinerary_id;

      $totallikes = Like::where('itinerary_id', $itinerary_id)->count();
      return $totallikes;
    }

    public function getNotifications()
    {
      $user_id = Auth::user()->id;

      // get list of comments on user's itinerary for today
      $comments = Comment::whereHas('itinerary', function ($q) use($user_id){
          $q->where('user_id', $user_id);
      })->with(['user', 'itinerary'])->where('user_id', '!=', $user_id)->whereDate('created_at', Carbon::today())->get();

      $result['comments']['total_comments'] = count($comments); // include total number of comments
      $result['comments']['data'] = $comments;

      // get list of comments on user's itinerary for today
      $likes = Like::whereHas('itinerary', function ($q) use($user_id){
          $q->where('user_id', $user_id);
      })->with(['user', 'itinerary'])->where('user_id', '!=', $user_id)->whereDate('created_at', Carbon::today())->get();

      $result['likes']['total_likes'] = count($likes); // include total number of comments
      $result['likes']['data'] = $likes;

      return json_encode($result);
    }

    // List all articles
    public function listArticles()
    {
      $articles = Article::orderBy('date', 'DESC')->get(['id','title','author','date','summary']);
      return $articles;
    }

    public function isLiked($user_id, $itinerary_id)
    {
      return Like::where([['user_id', $user_id], ['itinerary_id', $itinerary_id]])->exists();
    }

    // List all articles paginated
    public function listArticlesPaginated()
    {
      $numdata = 5;
      $articles = Article::orderBy('date', 'DESC')->paginate($numdata,['id','title','author','date','summary']);
      return $articles;
    }

    // View specific article
    public function viewArticle(Request $request)
    {
      $article_id = $request->article_id;
      $article = Article::find($article_id);

      return $article;
    }

    // Top 5 popular countries
    public function listPopularCountries()
    {
      $countries = DB::table('itineraries')
                 ->select('country_id', DB::raw('count(*) as total'))
                 ->groupBy('country_id')
                 ->orderBy('total', 'desc')
                 ->take(5)
                 ->get();

      $listCountries = [];
      foreach ($countries as $country)
      {
        $country->country_name = (Country::find($country->country_id))->name;
        $listCountries[] = $country;
      }

      return $listCountries;
    }

    // Top 5 popular itineraries (most likes)
    public function listPopularItineraries()
    {
      $likes = DB::table('likes')
                 ->select('itinerary_id', DB::raw('count(*) as total'))
                 ->groupBy('itinerary_id')
                 ->having('total', '>', 0)
                 ->orderBy('total', 'desc')
                 ->take(5)
                 ->get();

       $listItineraries = [];
       foreach ($likes as $like)
       {
         $itinerary = Itinerary::with(['user'])->find($like->itinerary_id);
         $like->itinerary_title = $itinerary->title;
         $like->itinerary_poster = $itinerary->user->name;
         $listItineraries[] = $like;
       }

       return $listItineraries;
    }

    // Top 5 popular itineraries (most likes) for specific user
    public function listUserPopularItineraries(Request $request)
    {
      $user_id = $request->user_id;

      $likes = Itinerary::leftJoin('likes', 'itineraries.id', '=', 'likes.itinerary_id')
                  ->selectRaw('itineraries.id, count(likes.id) as total')
                  ->where('itineraries.user_id', $user_id)
                  ->groupBy('itineraries.id')
                  ->having('total', '>', 0)
                  ->orderBy('total', 'desc')
                  ->take(5)
                  ->get();

      $listItineraries = [];
      foreach ($likes as $like)
      {
        $itinerary = Itinerary::with(['user', 'country'])->find($like->id);
        $like->itinerary_title = $itinerary->title;
        $like->itinerary_country = $itinerary->country->name;
        $like->itinerary_poster_id = $itinerary->user->id;
        $like->itinerary_poster_name = $itinerary->user->name;
        $listItineraries[] = $like;
      }

      return $listItineraries;
    }

    // Get user profile data for a specific user using id
    public function getUserData(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $country = Country::find($user->country_id);
        $totalitineraries = Itinerary::where('user_id', $user_id)->count();
        $user->country_name = $country->name;
        $user->totalitineraries = $totalitineraries;

        return $user;
    }

    // Upload user Avatar
    public function uploadAvatar(Request $request)
    {
      $rules = array(
        'avatar' => 'required|image',
      );

      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
          $errors = $validator->errors();

          $result['code'] = 400;
          $result['message'] = "Upload avatar failed!";
          $result['error'] = $errors;

          return json_encode($result);
      }
      else
      {
          if($request->hasFile('avatar'))
          {
            $user_id = Auth::user()->id;
            // Get old avatar
            $old_avatar = json_decode(User::where('id', $user_id)->get(['avatar_url']), true)[0]['avatar_url'];

            // Upload new avatar
            $pic_url = $request->file('avatar')->store('images/avatars', 'public');
            $pic_url = asset('storage/'.$pic_url);

            // Update new avatar url
            $user = User::find($user_id);
            $user->avatar_url = $pic_url;
            $user->save();

            // Delete old avatar file
            $del_avatar = $this->deletePhoto($old_avatar);

            $result['code'] = 200;
            $result['message'] = "Upload avatar success!";
            $result['result'] = $user;

            return json_encode($result);
          }
          else
          {
            $result['code'] = 400;
            $result['message'] = "No avatar uploaded.";

            return json_encode($result);
          }
      }
    }

    // Update user profile data
    public function updateProfile(Request $request)
    {
      $rules = array(
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'phone' => 'required|string|max:11',
        'address' => 'required|string|max:255',
        'country_id' => 'required|string|max:100',
        'email' => 'required|string|email|max:255',
      );

      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
          $errors = $validator->errors();

          $result['code'] = 400;
          $result['message'] = "Update profile failed!";
          $result['error'] = $errors;

          return json_encode($result);
      }
      else
      {
          $user_id = Auth::user()->id;
          $user = User::find($user_id);

          $user->name = $request->name;
          $user->username = $request->username;
          $user->phone = $request->phone;
          $user->address = $request->address;
          $user->country_id = $request->country_id;
          $user->bio = $request->bio;
          $user->website = $request->website;
          $user->email = $request->email;

          $user->save();

          $result['code'] = 200;
          $result['message'] = "User profile updated.";
          $result['result'] = $user;

          return json_encode($result);
      }
    }

    // Change user account password
    public function updatePassword(Request $request)
    {
      $rules = array(
        'old_password' => 'required|string|min:6',
        'password' => 'required|string|min:6|confirmed',
      );

      $validator = Validator::make($request->all(), $rules);

      if($validator->fails())
      {
          $errors = $validator->errors();

          $result['code'] = 400;
          $result['message'] = "Change password failed!";
          $result['error'] = $errors;

          return json_encode($result);
      }
      else
      {
          $old_password = Auth::user()->password;
          if(Hash::check($request->old_password, $old_password))
          {
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            $result['code'] = 200;
            $result['message'] = "Password changed.";
            $result['result'] = $user;

            return json_encode($result);
          }
          else
          {
            $result['code'] = 400;
            $result['message'] = "Change password failed!";
            $errors['old_password'] = ["Old password incorrect."];
            $result['error'] = $errors;

            return json_encode($result);
          }
      }
    }

}
