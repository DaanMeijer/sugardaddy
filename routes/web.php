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


if(app()->environment() == 'local'){
    Route::get('backdoor/{id}', function($id){
        Auth::login(App\User::find($id));
    });
}

Route::group(['middleware' => 'auth'], function(){
    Route::get('/graph', 'GraphController@graph');

    Route::get('/', 'GraphController@form');
    Route::get('/uploads/{id}', 'GraphController@show');
    Route::post('/', 'GraphController@upload');
});


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/redirect', 'Auth\\SocialAuthGoogleController@redirect');
Route::get('/callback', 'Auth\\SocialAuthGoogleController@callback');
