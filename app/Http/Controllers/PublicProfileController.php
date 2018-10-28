<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\APIController;
use App\Http\Controllers\PublicItineraryController;
use App\User;
use App\Country;
use App\Itinerary;

class PublicProfileController extends Controller
{
    //
    public function view(Request $request)
    {
      $user = $this->getUserData($request);
      $itineraries = $this->getUserItineraries($request);

      return view('public_profile', ['user' => $user, 'itineraries' => $itineraries]);
    }

    public function getUserData(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $user_id = $user->id;
        $country = Country::find($user->country_id);
        $totalitineraries = Itinerary::where('user_id', $user_id)->count();
        $user->country_name = $country->name;
        $user->totalitineraries = $totalitineraries;
        $APIobj = new APIController();
        $user->rank = $APIobj->getUserRank($totalitineraries);

        return $user;
    }

    public function getUserItineraries(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $user_id = $user->id;

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['user_id' => $user_id]);

        $APIobj = new APIController();
        $itineraries = $APIobj->listItinerariesByUser($newReq);

        return $itineraries;
    }
}
