<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\APIController;
use App\User;
use App\Itinerary;
use App\Comment;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        // top 5 popular countries
        $countries = $this->listPopularCountries();

        $countrylabels = [];
        $totalitinerary = [];
        $popularCountries = [];
        foreach($countries as $country)
        {
          $countrylabels[] = $country->country_name;
          $totalitinerary[] = $country->total;

          $popularCountries['labels'][] = $country->country_name;
          $popularCountries['data'][] = $country->total;
        }

        // Statistics
        $statistics['daily'] = $this->dailyStats();
        $statistics['monthly'] = $this->monthlyStats();

        return view('dashboard', ['popularCountries' => $popularCountries, 'statistics' => $statistics]);
    }

    // list top 5 popular countries
    public function listPopularCountries()
    {
        $APIobj = new APIController();
        $popular = $APIobj->listPopularCountries();

        return collect($popular);
    }

    // Daily statistics
    public function dailyStats()
    {
        $daily = [];

        // Users
        $daily['users'] = User::whereDate('created_at', Carbon::today())->count();

        // Itineraries
        $daily['itineraries'] = Itinerary::whereDate('created_at', Carbon::today())->count();

        // Comments
        $daily['comments'] = Comment::whereDate('created_at', Carbon::today())->count();

        return $daily;
    }

    // Monthly statistics
    public function monthlyStats()
    {
        $monthly = [];

        // Users
        $monthly['users'] = User::whereMonth('created_at', Carbon::now()->month)->count();

        // Itineraries
        $monthly['itineraries'] = Itinerary::whereMonth('created_at', Carbon::now()->month)->count();

        // Comments
        $monthly['comments'] = Comment::whereMonth('created_at', Carbon::now()->month)->count();

        return $monthly;
    }
}
