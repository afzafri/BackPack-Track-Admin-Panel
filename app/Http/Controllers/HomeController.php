<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\APIController;
use App\Country;
use App\Itinerary;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'admin')
        {
          return redirect('dashboard');
        }

        $user = $this->getUserData();
        $itineraries = $this->getUserItineraries();
        $comments = $this->getUserComments();

        return view('home', ['user' => $user, 'itineraries' => $itineraries, 'comments' => $comments]);
    }

    public function getUserData()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $country = Country::find($user->country_id);
        $totalitineraries = Itinerary::where('user_id', $user_id)->count();
        $user->country_name = $country->name;
        $user->totalitineraries = $totalitineraries;

        return $user;
    }

    public function getUserItineraries()
    {
        $user_id = Auth::user()->id;

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['user_id' => $user_id]);

        $APIobj = new APIController();
        $itineraries = $APIobj->listItinerariesByUser($newReq);

        return $itineraries;
    }

    public function getUserComments()
    {
        $user_id = Auth::user()->id;

        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['user_id' => $user_id]);

        $APIobj = new APIController();
        $comments = $APIobj->listCommentsByUser($newReq);

        return $comments;
    }
}
