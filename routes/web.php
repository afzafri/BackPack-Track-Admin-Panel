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

// -------------- Public Pages --------------
Route::get('/', function () {
    return view('landing');
});

Auth::routes();

// -------------- Backpacker Pages --------------
Route::get('/home', 'HomeController@index')->name('home');

// View itineraries data
Route::get('/itinerary/{itinerary_id}', 'PublicItineraryController@view');

// View user profile
Route::get('/userprofile/{username}', 'PublicProfileController@view');

// -------------- Administrator Pages --------------
// Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Itineraries
Route::get('/itineraries', 'ItineraryController@index')->name('itineraries');

Route::get('/itineraries/{itinerary_id}/view', 'ItineraryController@view');

Route::get('/itineraries/{itinerary_id}/edit', 'ItineraryController@edit');

Route::post('/itineraries/{itinerary_id}/edit', 'ItineraryController@update');

Route::post('/itineraries/delete', 'ItineraryController@destroy');

// Users
Route::get('/users', 'UserController@index')->name('users');

Route::post('/users/delete', 'UserController@destroy');

// Comments
Route::get('/comments', 'CommentController@index')->name('comments');

Route::post('/comments/delete', 'CommentController@destroy');

// Articles
Route::get('/articles', 'ArticleController@index')->name('articles');

Route::get('/articles/{article_id}/view', 'ArticleController@view');

Route::get('/articles/create', 'ArticleController@create');

Route::post('/articles/create', 'ArticleController@store');

Route::get('/articles/{article_id}/edit', 'ArticleController@edit');

Route::post('/articles/{article_id}/edit', 'ArticleController@update');

Route::post('/articles/delete', 'ArticleController@destroy');

// Admin User Profile
Route::get('/profile', 'ProfileController@index')->name('profile');

Route::post('/profile', 'ProfileController@update');

Route::post('/profile/password', 'ProfileController@updatePassword');

Route::post('/profile/avatar', 'ProfileController@updateAvatar');
