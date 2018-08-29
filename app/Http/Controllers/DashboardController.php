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
        // Top 5 popular countries
        $popularCountries = $this->listPopularCountries();

        // Top 5 most commented itineraries
        $popularItineraries = $this->listPopularItineraries();

        // Statistics
        $statistics['daily'] = $this->dailyStats();
        $statistics['monthly'] = $this->monthlyStats();
        $statistics['yearly'] = $this->yearlyStats();

        return view('dashboard', ['popularCountries' => $popularCountries, 'popularItineraries' => $popularItineraries, 'statistics' => $statistics]);
    }

    // list top 5 popular countries
    public function listPopularCountries()
    {
        $APIobj = new APIController();
        $countries = $APIobj->listPopularCountries();

        $popularCountries = [];
        $popularCountries['labels'] = [];
        $popularCountries['data'] = [];
        foreach($countries as $country)
        {
          $popularCountries['labels'][] = $country->country_name;
          $popularCountries['data'][] = $country->total;
        }

        return $popularCountries;
    }

    // List top 5 most commented itineraries
    public function listPopularItineraries()
    {
        $APIobj = new APIController();
        $itineraries = $APIobj->listPopularItineraries();

        return $itineraries;
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

    // Yearly statistics
    public function yearlyStats()
    {
        $yearly = [];

        // Users
        $yearly['users'] = User::whereYear('created_at', Carbon::now()->year)->count();

        // Itineraries
        $yearly['itineraries'] = Itinerary::whereYear('created_at', Carbon::now()->year)->count();

        // Comments
        $yearly['comments'] = Comment::whereYear('created_at', Carbon::now()->year)->count();

        return $yearly;
    }
}
