<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Validator;

use App\User;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
          $rules = array(
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string',
          );

          $validator = Validator::make($request->all(), $rules);

          if($validator->fails())
          {
              $errors = $validator->errors();

              $result['code'] = 400;
              $result['message'] = "Registration failed!";
              $result['error'] = $errors;

              return json_encode($result);
          }
          else
          {
              $user = new User;

              $user->name = $request->name;
              $user->username = $request->username;
              $user->phone = $request->phone;
              $user->address = $request->address;
              $user->country_id = $request->country;
              $user->email = $request->email;
              $user->password = Hash::make($request->password);
              $user->avatar_url = "";
              $user->role = $request->role;

              $user->save();

              $token = $user->createToken('BackPackTrack')->accessToken;

              $result['code'] = 200;
              $result['message'] = "Successfully register user!";
              $result['result'] = $user;
              $result['token'] = $token;

              return json_encode($result);
          }
    }
}
