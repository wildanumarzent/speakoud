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

    /**data master */
    //--- user management
    //instansi internal
    Route::get('/instansi/internal', 'Instansi\InstansiInternalController@index')
        ->name('instansi.internal.index')
        ->middleware('role:developer|administrator');
    Route::get('/instansi/internal/create', 'Instansi\InstansiInternalController@create')
        ->name('instansi.internal.create')
        ->middleware('role:developer|administrator');
    Route::post('/instansi/internal', 'Instansi\InstansiInternalController@store')
        ->name('instansi.internal.store')
        ->middleware('role:developer|administrator');
    Route::get('/instansi/internal/{id}/edit', 'Instansi\InstansiInternalController@edit')
        ->name('instansi.internal.edit')
        ->middleware('role:developer|administrator');
    Route::put('/instansi/internal/{id}', 'Instansi\InstansiInternalController@update')
        ->name('instansi.internal.update')
        ->middleware('role:developer|administrator');
    Route::delete('/instansi/internal/{id}', 'Instansi\InstansiInternalController@destroy')
        ->name('instansi.internal.destroy')
        ->middleware('role:developer|administrator');

    //instansi mitra
    Route::get('/instansi/mitra', 'Instansi\InstansiMitraController@index')
        ->name('instansi.mitra.index')
        ->middleware('role:developer|administrator');
    Route::get('/instansi/mitra/create', 'Instansi\InstansiMitraController@create')
        ->name('instansi.mitra.create')
        ->middleware('role:developer|administrator');
    Route::post('/instansi/mitra', 'Instansi\InstansiMitraController@store')
        ->name('instansi.mitra.store')
        ->middleware('role:developer|administrator');
    Route::get('/instansi/mitra/{id}/edit', 'Instansi\InstansiMitraController@edit')
        ->name('instansi.mitra.edit')
        ->middleware('role:developer|administrator');
    Route::put('/instansi/mitra/{id}', 'Instansi\InstansiMitraController@update')
        ->name('instansi.mitra.update')
        ->middleware('role:developer|administrator');
    Route::delete('/instansi/mitra/{id}', 'Instansi\InstansiMitraController@destroy')
        ->name('instansi.mitra.destroy')
        ->middleware('role:developer|administrator');

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

    /**bank data */
    Route::get('/bank/data/{type}', 'BankDataController@index')
        ->name('bank.data')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/bank/data/filemanager/view', 'BankDataController@filemanager')
        ->name('bank.data.filemanager')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');

    //directory
    Route::post('/directory', 'BankDataController@storeDirectory')
        ->name('bank.data.directory.store')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::delete('/directory', 'BankDataController@destroyDirectory')
        ->name('bank.data.directory.destroy')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');

    //file
    Route::post('/files', 'BankDataController@storeFile')
        ->name('bank.data.files.store')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::put('/files/{id}', 'BankDataController@updateFile')
        ->name('bank.data.files.update')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::delete('/files/{id}', 'BankDataController@destroyFile')
        ->name('bank.data.files.destroy')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');

    /**manage course */
    //program pelatihan
    Route::get('/program', 'Course\ProgramController@index')
        ->name('program.index')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/program/create', 'Course\ProgramController@create')
        ->name('program.create')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/program', 'Course\ProgramController@store')
        ->name('program.store')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/program/{id}/edit', 'Course\ProgramController@edit')
        ->name('program.edit')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/program/{id}', 'Course\ProgramController@update')
        ->name('program.update')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/program/{id}/position/{position}', 'Course\ProgramController@position')
        ->name('program.position')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/program/sort', 'Course\ProgramController@sort')
        ->name('program.sort')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::delete('/program/{id}', 'Course\ProgramController@destroy')
        ->name('program.destroy')
        ->middleware('role:developer|administrator|internal|mitra');

    //mata pelatihan
    Route::get('/program/{id}/mata', 'Course\MataController@index')
        ->name('mata.index')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/program/{id}/mata/create', 'Course\MataController@create')
        ->name('mata.create')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/program/{id}/mata', 'Course\MataController@store')
        ->name('mata.store')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/program/{id}/mata/{mataId}/edit', 'Course\MataController@edit')
        ->name('mata.edit')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/program/{id}/mata/{mataId}', 'Course\MataController@update')
        ->name('mata.update')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/program/{id}/mata/{mataId}/publish', 'Course\MataController@publish')
        ->name('mata.publish')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/program/{id}/mata/{mataId}/position/{position}', 'Course\MataController@position')
        ->name('mata.position')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/program/{id}/mata/sort', 'Course\MataController@sort')
        ->name('mata.sort')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::delete('/program/{id}/mata/{mataId}', 'Course\MataController@destroy')
        ->name('mata.destroy')
        ->middleware('role:developer|administrator|internal|mitra');

    //logout
    Route::post('/logout', 'Auth\LoginController@logout')
        ->name('logout');
});


//stream file
Route::get('/bank/data/view/{path}', 'BankDataController@streamFile')
        ->where('path', '^.*\.(jpg|JPG|jpeg|JPEG|png|PNG|pdf|PDF|ppt|PPT|pptx|PPTX|mp3|MP3|mp4|MP4|webm|WEBM|doc|DOC|docx|DOCX|xls|XLS|xlsx|XLSX)$')
        ->name('bank.data.stream');
