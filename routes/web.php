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


app()->setLocale('hu');


Route::get('/', 'StartpageController@render');


//Route::get('/reset', 'Auth\ResetPasswordController@showResetForm')->middleware('guest');
// Authentication Routes...
Route::get('bejelentkezes', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('bejelentkezes', 'Auth\LoginController@login');
Route::post('kijelentkezes', 'Auth\LoginController@logout')->name('logout');

if ($options['register'] ?? true) {
    Route::get('regisztracio', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('regisztracio', 'Auth\RegisterController@register');
    //Route::post('regisztracio', 'Auth\RegisterController@store')->name('reg');
}

// Password Reset Routes...
if ($options['reset'] ?? true) {
    Route::get('jelszo/uj', 'Auth\ForgotPasswordController@showLinkRequestForm')
        ->middleware('guest')
        ->name('password.request');
    Route::post('jelszo/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')
        ->middleware('guest')
        ->name('password.email');
    Route::get('jelszo/uj/{token}', 'Auth\ResetPasswordController@showResetForm')
        ->middleware('guest')
        ->name('password.reset');
    Route::post('jelszo/uj', 'Auth\ResetPasswordController@reset')
        ->middleware('guest')
        ->name('password.update');
}
// Email Verification Routes...
if ($options['verify'] ?? true) {
    Route::emailVerification();
}

Route::get('/utvonal/{id}', 'TrackController@render');
Route::get('/utvonalak', 'TrackController@all');
Route::group(['middleware' => 'auth'], function() {
    Route::get('/profil', 'ProfileController@index')->middleware('verified');
    Route::get('/profil/hozzaadas', 'ProfileController@add')->middleware('verified');
    Route::get('/utvonal/szerkesztes/{id}', 'ProfileController@edit')->middleware('verified');
    Route::post('/track/add', 'TrackPostController@add');
    Route::post('/track/update', 'TrackPostController@update');
    Route::delete('/track/{id}', 'TrackPostController@delete');
    Route::post('/like/{id}', 'TrackPostController@like');
});

