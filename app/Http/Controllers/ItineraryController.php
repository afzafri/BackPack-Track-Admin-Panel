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
}
