<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        // get the durations for each itinerary
        $durations = [];
        foreach ($itineraries as $itinerary)
        {
          $duration = $this->getDuration($itinerary->id);
          $durations[$itinerary->id] = $duration;
        }

        // insert the durations into the itineraries
        //$itineraries->put('durations', $durations);

        //return $itineraries;
        return view('itineraries', ['itineraries' => $itineraries, 'durations' => collect($durations)]);
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
}
