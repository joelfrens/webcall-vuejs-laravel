<?php

use Illuminate\Support\Facades\Route;

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

// Genaral Routes
Route::get('/home', 'HomeController@index')->name('home');

// Twilio Controller Routes
// Request validation middleware: checkTwilioRequests
// The request validation middleware should only be used on routes that are coming from Twilio into the web app
Route::get('/get-token', 'TwilioController@getToken')->name('get-token');
Route::get('/generate-voice-twiml', 'TwilioController@generateVoiceTwiml')->name('generate-voice-twiml')->middleware('checkTwilioRequests');

