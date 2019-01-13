<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\APIController;
use App\User;
use App\Itinerary;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    // List all itineraries
    public function index()
    {
        $users = User::with(['country'])->get();

        return view('users', ['users' => $users]);
    }

    // Delete user data
    public function destroy(Request $request)
    {
        $user_id = $request->user_id;

        // delete all user's itineraries
        $this->deleteUserItineraries($user_id);

        $user = User::find($user_id);

        // delete image
        $APIobj = new APIController();
        $avatar_url = $user->avatar_url;
        $avatar_url = $APIobj->deletePhoto($avatar_url);

        // delete data
        $user->delete();

        return redirect('users')->with('deletestatus', 'Delete user ID: '.$request->user_id.' success!');
    }

    // Delete all user's itineraries
    public function deleteUserItineraries($user_id)
    {
      $APIobj = new APIController();

      $itineraries = Itinerary::where('user_id', $user_id)->get();

      foreach ($itineraries as $itinerary) {
        // delete itinerary
        $newReq = new Request();
        $newReq->setMethod('POST');
        $newReq->request->add(['itinerary_id' => $itinerary->id]);
        $APIobj->deleteItinerary($newReq);
      }
    }
}
