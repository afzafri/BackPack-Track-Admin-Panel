<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// ----------------- API ROUTES -----------------
// List all countries names
Route::get('/api/listCountries', 'APIController@listCountries');

// Create new itinerary
Route::post('/api/newItinerary', 'APIController@newItinerary');

// List all itineraries
Route::get('/api/listItineraries', 'APIController@listItineraries');

// List itineraries for specific Country
Route::get('/api/listItinerariesByCountry/{country_id}', 'APIController@listItinerariesByCountry');

// List itineraries for specific User
Route::get('/api/listItinerariesByUser/{user_id}', 'APIController@listItinerariesByUser');

// Create activity
Route::post('/api/newActivity', 'APIController@newActivity');

// View activities for an itinerary
Route::get('/api/viewActivities/{itinerary_id}', 'APIController@viewActivities');
