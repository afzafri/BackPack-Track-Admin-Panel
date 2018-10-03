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

// ----------------- CRUD API ROUTES -----------------
// List all countries names
Route::get('/listCountries', 'APIController@listCountries');

// Login User
Route::post('login', 'AuthController@login');

// Register User
Route::post('register', 'AuthController@register');

Route::middleware('auth:api')->group(function () {

  // Create new itinerary
  Route::post('/newItinerary', 'APIController@newItinerary');

  // Edit and update itinerary
  Route::post('/updateItinerary', 'APIController@updateItinerary');

  // Delete itinerary
  Route::post('/deleteItinerary', 'APIController@deleteItinerary');

  // List all itineraries
  Route::get('/listItineraries', 'APIController@listItineraries');

  // List all itineraries in pages
  Route::get('/listItinerariesPaginated', 'APIController@listItinerariesPaginated');

  // View specific itinerary
  Route::get('/viewItinerary/{itinerary_id}', 'APIController@viewItinerary');

  // List itineraries for specific Country
  Route::get('/listItinerariesByCountry/{country_id}', 'APIController@listItinerariesByCountry');

  // List itineraries for auth User
  Route::get('/listItinerariesByAuthUser', 'APIController@listItinerariesByAuthUser');

  // List itineraries for specific User
  Route::get('/listItinerariesByUser/{user_id}', 'APIController@listItinerariesByUser');

  // Search itineraries by title
  Route::get('/searchItineraries/{title}', 'APIController@searchItineraries');

  // List all itineraries that have been at least 1 itinerary (have been visited)
  Route::get('/listVisitedCountries', 'APIController@listVisitedCountries');

  // Create activity
  Route::post('/newActivity', 'APIController@newActivity');

  // Edit and Update activity
  Route::post('/updateActivity', 'APIController@updateActivity');

  // Delete an activity
  Route::post('/deleteActivity', 'APIController@deleteActivity');

  // View activities for an itinerary
  Route::get('/viewActivities/{itinerary_id}', 'APIController@viewActivities');

  // View activities for an itinerary, separated by Day/Date
  Route::get('/viewActivitiesByDay/{itinerary_id}', 'APIController@viewActivitiesByDay');

  // View activities for an itinerary in pages
  Route::get('/viewActivitiesPaginated/{itinerary_id}', 'APIController@viewActivitiesPaginated');

  // List all photos from activities
  Route::get('/listItineraryImages/{itinerary_id}', 'APIController@listItineraryImages');

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

  // List all articles in database
  Route::get('/listArticles', 'APIController@listArticles');

  // List all articles in pages
  Route::get('/listArticlesPaginated', 'APIController@listArticlesPaginated');

  // View specific article
  Route::get('/viewArticle/{article_id}', 'APIController@viewArticle');

  // Top 5 popular countries
  Route::get('/listPopularCountries', 'APIController@listPopularCountries');

  // Top 5 most commented Itineraries
  Route::get('/listPopularItineraries', 'APIController@listPopularItineraries');

  // Logout user
  Route::get('logout', 'AuthController@logout');

  // Get logged in User details
  Route::get('user', 'AuthController@user');

  // Upload user avatar
  Route::post('uploadAvatar', 'APIController@uploadAvatar');

  // Update user profile
  Route::post('updateProfile', 'APIController@updateProfile');

  // Change user password
  Route::post('updatePassword', 'APIController@updatePassword');
});
