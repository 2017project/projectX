<?php

use App\Common\Constants\RouteConsts;
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

Route::group(['namespace' => 'Api'], function() {
    Route::post('/register', 'AuthController@register')->name(RouteConsts::$REGISTER);
    Route::post('/login', 'AuthController@login')->name(RouteConsts::$LOGIN);
    Route::post('/logout', 'AuthController@logout')->name(RouteConsts::$LOGOUT);

    Route::get('/profiles', 'ProfilesController@index')->name(RouteConsts::$PROFILES_GET_ALL);

    Route::post('/mails/send', 'MailsController@sendMail')->name(RouteConsts::$MAILS_SEND);
});

