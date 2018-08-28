<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\APIController;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $countries = $this->listPopularCountries();

        $countrylabels = [];
        $totalitinerary = [];
        foreach($countries as $country)
        {
          $countrylabels[] = $country->country_name;
          $totalitinerary[] = $country->total;
        }


        return view('dashboard', ['countrylabels' => json_encode($countrylabels), 'totalitinerary' => json_encode($totalitinerary)]);
    }

    public function listPopularCountries()
    {
        $APIobj = new APIController();
        $popular = $APIobj->listPopularCountries();

        return collect($popular);
    }
}
