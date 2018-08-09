<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ----------------- API ROUTES -----------------
// List all countries names
Route::get('/listCountries', 'APIController@listCountries');

// Create new itinerary
Route::post('/newItinerary', 'APIController@newItinerary');

// List all itineraries
Route::get('/listItineraries', 'APIController@listItineraries');

// List itineraries for specific Country
Route::get('/listItinerariesByCountry/{country_id}', 'APIController@listItinerariesByCountry');

// List itineraries for specific User
Route::get('/listItinerariesByUser/{user_id}', 'APIController@listItinerariesByUser');

// Create activity
// To-do: Upload photos
Route::post('/newActivity', 'APIController@newActivity');

// View activities for an itinerary
Route::get('/viewActivities/{itinerary_id}', 'APIController@viewActivities');

// Register new user

// Login user

// List dates and no of day for an itinerary
Route::get('/getDayDates/{itinerary_id}', 'APIController@getDayDates');

// Post comments for an itinerary
Route::post('/newComment', 'APIController@newComment');

// List comments for an itinerary
Route::get('/listComments/{itinerary_id}', 'APIController@listComments');

// List comments for specific users

// Calculate total budget for an Itinerary
Route::get('/getTotalBudget/{itinerary_id}', 'APIController@getTotalBudget');
