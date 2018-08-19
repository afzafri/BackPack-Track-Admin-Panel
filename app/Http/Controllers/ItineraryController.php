<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

use App\Itinerary;
use App\Activity;

class ItineraryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

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
}
