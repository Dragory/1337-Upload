<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::get('/', ['as' => 'index', 'uses' => 'front@index']);

Route::get('legacy_password', ['as' => 'legacy_password', 'uses' => 'legacy_password@index']);
Route::post('legacy_password_post', ['as' => 'legacy_password_post', 'uses' => 'legacy_password@post', 'before' => 'csrf']);

Route::get('upload', ['as' => 'upload', 'uses' => 'front@upload']);
Route::get('blog', ['as' => 'blog', 'uses' => 'front@blog']);
Route::get('filelist', ['as' => 'filelist', 'uses' => 'front@filelist']);
Route::get('filelist/(:num)', ['as' => 'filelist_user', 'uses' => 'front@filelist']);
Route::get('support', ['as' => 'support', 'uses' => 'front@support']);
Route::get('admin', ['as' => 'admin', 'uses' => 'front@admin']);

Route::get('profile/(:num)', ['as' => 'profile', 'uses' => 'front@profile']);

Route::get('misc', ['as' => 'misc', 'uses' => 'front@misc']);
Route::get('misc/(:any)', ['as' => 'misc_sub', 'uses' => 'front@misc']);

// Uploading
Route::post('upload_post', ['as' => 'upload_post', 'uses' => 'uploader@upload']);

// Searching
Route::get('search/(:any)', ['as' => 'search', 'uses' => 'front@search']);

// Logging in
Route::post('login_post', ['as' => 'login_post', 'uses' => 'front@login_post', 'before' => 'csrf']);

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});