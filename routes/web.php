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
/**
 * home
 */
Route::get('/', 'HomeController@index')
    ->name('home');

/**
 * authentication
 */
Route::get('/login', 'Auth\LoginController@showLoginForm')
    ->name('login')
    ->middleware('guest');
Route::post('/login', 'Auth\LoginController@login')
    ->middleware('guest');

/**
 * panel
 */
Route::group(['middleware' => ['auth']], function () {

    // dashboard
    Route::get('/dashboard', 'HomeController@dashboard')
        ->name('dashboard');

    //profile
    Route::get('/profile/edit', 'users\UserController@profileForm')
        ->name('profile.edit');
    Route::put('/profile/edit', 'users\UserController@updateProfile');

    //users
    Route::get('/user', 'Users\UserController@index')
        ->name('user.index')
        ->middleware('role:developer|administrator');
    Route::get('/user/create', 'Users\UserController@create')
        ->name('user.create')
        ->middleware('role:developer|administrator');
    Route::post('/user', 'Users\UserController@store')
        ->name('user.store')
        ->middleware('role:developer|administrator');
    Route::get('/user/{id}/edit', 'Users\UserController@edit')
        ->name('user.edit')
        ->middleware('role:developer|administrator');
    Route::put('/user/{id}', 'Users\UserController@update')
        ->name('user.update')
        ->middleware('role:developer|administrator');
    Route::put('/user/{id}/activate', 'Users\UserController@activate')
        ->name('user.activate')
        ->middleware('role:developer|administrator');
    Route::delete('/user/{id}', 'Users\UserController@destroy')
        ->name('user.destroy')
        ->middleware('role:developer|administrator');

    //internal
    Route::get('/internal', 'Users\InternalController@index')
        ->name('internal.index')
        ->middleware('role:developer|administrator');
    Route::get('/internal/create', 'Users\InternalController@create')
        ->name('internal.create')
        ->middleware('role:developer|administrator');
    Route::post('/internal', 'Users\InternalController@store')
        ->name('internal.store')
        ->middleware('role:developer|administrator');
    Route::get('/internal/{id}/edit', 'Users\InternalController@edit')
        ->name('internal.edit')
        ->middleware('role:developer|administrator');
    Route::put('/internal/{id}', 'Users\InternalController@update')
        ->name('internal.update')
        ->middleware('role:developer|administrator');
    Route::delete('/internal/{id}', 'Users\InternalController@destroy')
        ->name('internal.destroy')
        ->middleware('role:developer|administrator');

    //mitra
    Route::get('/mitra', 'Users\MitraController@index')
        ->name('mitra.index')
        ->middleware('role:developer|administrator|internal');
    Route::get('/mitra/create', 'Users\MitraController@create')
        ->name('mitra.create')
        ->middleware('role:developer|administrator|internal');
    Route::post('/mitra', 'Users\MitraController@store')
        ->name('mitra.store')
        ->middleware('role:developer|administrator|internal');
    Route::get('/mitra/{id}/edit', 'Users\MitraController@edit')
        ->name('mitra.edit')
        ->middleware('role:developer|administrator|internal');
    Route::put('/mitra/{id}', 'Users\MitraController@update')
        ->name('mitra.update')
        ->middleware('role:developer|administrator|internal');
    Route::delete('/mitra/{id}', 'Users\MitraController@destroy')
        ->name('mitra.destroy')
        ->middleware('role:developer|administrator');

    //instruktur
    Route::get('/instruktur', 'Users\InstrukturController@index')
        ->name('instruktur.index')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/instruktur/create', 'Users\InstrukturController@create')
        ->name('instruktur.create')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/instruktur', 'Users\InstrukturController@store')
        ->name('instruktur.store')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/instruktur/{id}/edit', 'Users\InstrukturController@edit')
        ->name('instruktur.edit')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/instruktur/{id}', 'Users\InstrukturController@update')
        ->name('instruktur.update')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::delete('/instruktur/{id}', 'Users\InstrukturController@destroy')
        ->name('instruktur.destroy')
        ->middleware('role:developer|administrator');

    //peserta
    Route::get('/peserta', 'Users\PesertaController@index')
        ->name('peserta.index')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/peserta/create', 'Users\PesertaController@create')
        ->name('peserta.create')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/peserta', 'Users\PesertaController@store')
        ->name('peserta.store')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/peserta/{id}/edit', 'Users\PesertaController@edit')
        ->name('peserta.edit')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/peserta/{id}', 'Users\PesertaController@update')
        ->name('peserta.update')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::delete('/peserta/{id}', 'Users\PesertaController@destroy')
        ->name('peserta.destroy')
        ->middleware('role:developer|administrator');

    //logout
    Route::post('/logout', 'Auth\LoginController@logout')
        ->name('logout');

});
