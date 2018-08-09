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

// Edit and update itinerary

// Delete itinerary

// List all itineraries
Route::get('/listItineraries', 'APIController@listItineraries');

// List itineraries for specific Country
Route::get('/listItinerariesByCountry/{country_id}', 'APIController@listItinerariesByCountry');

// List itineraries for specific User
Route::get('/listItinerariesByUser/{user_id}', 'APIController@listItinerariesByUser');

// Create activity
// To-do: Upload photos
Route::post('/newActivity', 'APIController@newActivity');

// Edit and Update activity

// Delete activity

// View activities for an itinerary
// To-do: Return photos urls
Route::get('/viewActivities/{itinerary_id}', 'APIController@viewActivities');

// List all photos from activities

// Register new user

// Login user

// List dates and no of day for an itinerary
Route::get('/getDayDates/{itinerary_id}', 'APIController@getDayDates');

// Post comments for an itinerary
Route::post('/newComment', 'APIController@newComment');

// List comments for an itinerary
Route::get('/listComments/{itinerary_id}', 'APIController@listComments');

// List comments for specific users
Route::get('/listCommentsByUser/{user_id}', 'APIController@listCommentsByUser');

// Calculate total budget for an Itinerary
Route::get('/getTotalBudget/{itinerary_id}', 'APIController@getTotalBudget');

// Calculate total budget for each day of a trip
Route::get('/getTotalBudgetPerDay/{itinerary_id}', 'APIController@getTotalBudgetPerDay');
