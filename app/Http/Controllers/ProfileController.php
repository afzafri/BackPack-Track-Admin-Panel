<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Storage;
use Validator;

use App\Http\Controllers\APIController;
use App\Country;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    // Display profile data
    public function index()
    {
        $user = Auth::user();
        $countries = Country::get(['id','name']);

        return view('profile', ['user' => $user, 'countries' => $countries]);
    }

    // Update profile data
    public function update(Request $request)
    {
        $APIobj = new APIController();
        $result = $APIobj->updateProfile($request);

        $result = json_decode($result, true);
        if($result['code'] == 400)
        {
          $errors = new MessageBag($result['error']);

          return redirect('profile')->with('errors', $errors);
        }
        else if($result['code'] == 200)
        {
          return redirect('profile')->with('success', "User account updated!");
        }
    }

    // Update profile picture
    public function updateAvatar(Request $request)
    {
        $APIobj = new APIController();
        $result = $APIobj->uploadAvatar($request);

        $result = json_decode($result, true);
        if($result['code'] == 400)
        {
          $errors = new MessageBag($result['error']);

          return redirect('profile')->with('errors', $errors);
        }
        else if($result['code'] == 200)
        {
          return redirect('profile')->with('success', "New profile picture uploaded!");
        }
    }
}
