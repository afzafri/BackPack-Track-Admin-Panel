<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Country;

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
        return view('home', ['user' => $user]);
    }

    public function getUserData()
    {
        $user = Auth::user();
        $country = Country::find($user->country_id);
        $user->country_name = $country->name;

        return $user;
    }
}
