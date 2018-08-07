<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;

class APIController extends Controller
{
    // List all country name
    public function listCountries()
    {
      $countries = Country::all();
      return $countries;
    }
}
