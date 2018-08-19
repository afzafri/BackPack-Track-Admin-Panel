<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Validator;

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
            return redirect('profile')->with('errors', $errors);
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
            $user->email = $request->email;

            $user->save();

            return redirect('profile')->with('success', "User account updated!");
        }
    }

    // Update profile picture
    
}
