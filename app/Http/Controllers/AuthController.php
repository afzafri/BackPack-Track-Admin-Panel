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

              $result['code'] = 200;
              $result['message'] = "Successfully register user!";
              $result['result'] = $user;

              return json_encode($result);
          }
    }

    // login
    public function login(Request $request)
    {
        $rules = array(
          'login' => 'required|string|max:255',
          'password' => 'required|string|min:6',
          'remember_me' => 'boolean',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();

            $result['code'] = 400;
            $result['message'] = "Login failed!";
            $result['error'] = $errors;

            return json_encode($result);
        }
        else
        {
            $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';

            $request->merge([
                $login_type => $request->input('login')
            ]);

            if(!Auth::attempt($request->only($login_type, 'password')))
            {
                $result['code'] = 400;
                $result['message'] = "Login failed! Wrong email or password.";
                return json_encode($result);
            }

            $user = $request->user();

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
            {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }

            $token->save();

            $result['code'] = 200;
            $result['message'] = "Login success!";
            $result['result'] = $user;
            $result['access_token'] = $tokenResult->accessToken;
            $result['token_type'] = 'Bearer';
            $result['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();

            return json_encode($result);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        $result['message'] = "Successfully logged out.";
        return json_encode($result);
    }

    // Get logged in User details
    public function user()
    {
        $user = User::with(['country'])->find(Auth::user()->id);
        return $user;
    }
}
