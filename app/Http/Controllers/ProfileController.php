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
    public function updateAvatar(Request $request)
    {
        $rules = array(
          'avatar' => 'required|image',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();
            return redirect('profile')->with('errors', $errors);
        }
        else
        {
            if($request->hasFile('avatar'))
            {
              // Get old avatar
              $old_avatar = json_decode(User::where('id', Auth::user()->id)->get(['avatar_url']), true)[0]['avatar_url'];

              // Upload new avatar
              $pic_url = $request->file('avatar')->store('images/avatars', 'public');
              $pic_url = asset('storage/'.$pic_url);

              // Update new avatar url
              $user = User::find(Auth::user()->id);
              $user->avatar_url = $pic_url;
              $user->save();

              // Delete old avatar file
              $del_avatar = $this->deletePhoto($old_avatar);

              return redirect('profile')->with('success', "New profile picture uploaded!");
            }
            else
            {
              return redirect('profile')->with('errors', ['avatar' => 'No profile picture uploaded']);
            }
        }
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
