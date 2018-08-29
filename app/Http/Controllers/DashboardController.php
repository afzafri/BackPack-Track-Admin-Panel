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
        $popularCountries = [];
        foreach($countries as $country)
        {
          $countrylabels[] = $country->country_name;
          $totalitinerary[] = $country->total;

          $popularCountries['labels'][] = $country->country_name;
          $popularCountries['data'][] = $country->total;
        }


        return view('dashboard', ['popularCountries' => $popularCountries]);
    }

    public function listPopularCountries()
    {
        $APIobj = new APIController();
        $popular = $APIobj->listPopularCountries();

        return collect($popular);
    }
}
