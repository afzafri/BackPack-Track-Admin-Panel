<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Storage;
use Validator;

use App\Http\Controllers\APIController;
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
        $APIobj = new APIController();
        $itineraries = $APIobj->listItineraries();

        return view('itineraries', ['itineraries' => collect($itineraries)]);
    }

    // Delete an itinerary
    public function destroy(Request $request)
    {
        $APIobj = new APIController();
        $APIobj->deleteItinerary($request);

        return redirect('itineraries')->with('deletestatus', 'Delete itinerary ID: '.$request->itinerary_id.' success!');
    }

    // View activitites of an itinerary
    public function view(Request $request)
    {
        // get activities
        $APIobj = new APIController();
        $result = json_decode($APIobj->viewActivities($request));

        return view('activities', ['data' => $result]);
    }

    // Edit an itinerary
    public function edit(Request $request)
    {
        $APIobj = new APIController();

        $itinerary = $APIobj->viewItinerary($request);
        $countries = $APIobj->listCountries();

        return view('edit_itinerary', ['itinerary' => $itinerary, 'countries' => $countries]);
    }

    // Update itinerary data
    public function update(Request $request)
    {
        $APIobj = new APIController();
        $result = $APIobj->updateItinerary($request);

        $result = json_decode($result, true);
        if($result['code'] == 400)
        {
          $errors = new MessageBag($result['error']);

          return redirect('itineraries/'.$request->itinerary_id.'/edit')->with('errors', $errors);
        }
        else if($result['code'] == 200)
        {
          return redirect('itineraries/'.$request->itinerary_id.'/edit')->with('success', "Itinerary updated!");
        }
    }
}
