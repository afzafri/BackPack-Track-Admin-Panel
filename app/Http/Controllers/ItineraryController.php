<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Validator;

use App\Itinerary;
use App\Activity;
use App\Country;

class ItineraryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    // List all itineraries
    public function index()
    {
        // get all the itineraries
        $itineraries = Itinerary::with(['country','user'])->get();

        // get the durations and total budgets for each itinerary
        $durations = [];
        $totalbudgets = [];
        foreach ($itineraries as $itinerary)
        {
          $duration = $this->getDuration($itinerary->id);
          $durations[$itinerary->id] = $duration;

          $totalbudget = $this->getTotalBudget($itinerary->id);
          $totalbudgets[$itinerary->id] = $totalbudget;
        }

        return view('itineraries', ['itineraries' => $itineraries, 'durations' => collect($durations), 'totalbudgets' => collect($totalbudgets)]);
    }

    // Get duration of the trip
    public function getDuration($itinerary_id)
    {
        $dates = Activity::distinct()->where('itinerary_id', $itinerary_id)->get(['date']);
        $nodays = count($dates);
        $nonight = $nodays > 0 ? ($nodays-1) : 0;
        $duration = $nodays."D".$nonight."N";

        return $duration;
    }

    // Get total budgets of each trip
    public function getTotalBudget($itinerary_id)
    {
        $totalbudget = Activity::where('itinerary_id', $itinerary_id)->sum('budget');

        return $totalbudget;
    }

    // Delete an itinerary
    public function destroy(Request $request)
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

        // Delete the activities data
        $activities = Activity::where('itinerary_id', $itinerary_id)->delete();


        return redirect('itineraries')->with('deletestatus', 'Delete itinerary ID: '.$itinerary_id.' success!');
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

    // View activitites of an itinerary
    public function view(Request $request)
    {
        $itinerary_id = $request->itinerary_id;

        $itinerary = Itinerary::with(['user','country'])->find($itinerary_id);
        $activities = Activity::where('itinerary_id', $itinerary_id)->get();

        $result['itinerary'] = $itinerary;
        $result['activities'] = $activities;

        // get total budget
        $totalbudget = $this->getTotalBudget($itinerary_id);

        return view('activities', ['data' => $result, 'totalbudget' => $totalbudget]);
    }

    // Edit an itinerary
    public function edit(Request $request)
    {
        $itinerary_id = $request->itinerary_id;

        $itinerary = Itinerary::with(['user','country'])->find($itinerary_id);
        $countries = Country::get(['id','name']);

        return view('edit_itinerary', ['itinerary' => $itinerary, 'countries' => $countries]);
    }

    // Update itinerary data
    public function update(Request $request)
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
            return redirect('itineraries/'.$request->itinerary_id.'/edit')->with('errors', $errors);
        }
        else
        {
            $itinerary_id = $request->itinerary_id;
            $itinerary = Itinerary::find($itinerary_id);

            $itinerary->title = $request->title;
            $itinerary->country_id = $request->country_id;
            $itinerary->user_id = $request->user_id;

            $itinerary->save();

            return redirect('itineraries/'.$request->itinerary_id.'/edit')->with('success', "Itinerary updated!");
        }
    }
}
