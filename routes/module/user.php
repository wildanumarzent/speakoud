<?php

use App\Http\Controllers\Users\InstrukturController;
use App\Http\Controllers\Users\InternalController;
use App\Http\Controllers\Users\MitraController;
use App\Http\Controllers\Users\PesertaController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    //profile
    Route::prefix('profile')->name('profile')->group(function () {
        
        Route::get('/', [UserController::class, 'profile']);
        Route::get('/edit', [UserController::class, 'profileForm'])
            ->name('.edit');
        Route::put('/edit', [UserController::class, 'updateProfile']);
        //verifikasi email
        Route::get('/email/verification/send', [UserController::class, 'sendVerification'])
            ->name('.email.verification.send');
        Route::get('/email/verification/{email}', [UserController::class, 'verification'])
            ->name('.email.verification');

    });

    //users
    Route::prefix('user')->name('user.')->middleware('role:developer|administrator')
        ->group(function () {
        
        Route::get('/', [UserController::class, 'index'])
            ->name('index');
        Route::get('/trash', [UserController::class, 'trash'])
            ->name('trash');
        Route::get('/create', [UserController::class, 'create'])
            ->name('create');
        Route::post('/', [UserController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])
            ->name('update');
        Route::put('/{id}/activate', [UserController::class, 'activate'])
            ->name('activate');
        Route::delete('/{id}', [UserController::class, 'destroy'])
            ->name('destroy');
        Route::get('/{id}/soft', [UserController::class, 'softDelete'])
            ->name('destroy.soft');
        Route::get('/{id}/restore', [UserController::class, 'restore'])
            ->name('destroy.restore');

    });

    //internal
    Route::prefix('internal')->name('internal.')->middleware('role:developer|administrator')
        ->group(function () {

        Route::get('/', [InternalController::class, 'index'])
            ->name('index');
        Route::get('/create', [InternalController::class, 'create'])
            ->name('create');
        Route::post('/', [InternalController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [InternalController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [InternalController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [InternalController::class, 'destroy'])
            ->name('destroy');
        Route::get('/{id}/soft', [InternalController::class, 'softDelete'])
            ->name('destroy.soft');

    });

    //mitra
    Route::prefix('mitra')->name('mitra.')->middleware('role:developer|administrator|internal')
        ->group(function () {

        Route::get('/', 'Users\MitraController@index')
            ->name('index');
        Route::get('/create', [MitraController::class, 'create'])
            ->name('create');
        Route::post('/', [MitraController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [MitraController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [MitraController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [MitraController::class, 'destroy'])
            ->name('destroy');
        Route::get('/{id}/soft', [MitraController::class, 'softDelete'])
            ->name('destroy.soft');

    });

    //instruktur
    Route::prefix('instruktur')->name('instruktur.')->middleware('role:developer|administrator|internal|mitra')
        ->group(function () {

        Route::get('/', [InstrukturController::class, 'index'])
            ->name('index');
        Route::get('/create', [InstrukturController::class, 'create'])
            ->name('create');
        Route::post('/', [InstrukturController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [InstrukturController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [InstrukturController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [InstrukturController::class, 'destroy'])
            ->name('destroy');
        Route::get('/{id}/soft', [InstrukturController::class, 'softDelete'])
            ->name('destroy.soft');

    });

    //peserta
    Route::prefix('peserta')->name('peserta.')->middleware('role:developer|administrator|internal|mitra')
        ->group(function () {

        Route::get('/', [PesertaController::class, 'index'])
            ->name('index');
        Route::get('/create', [PesertaController::class, 'create'])
            ->name('create');
        Route::post('/', [PesertaController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [PesertaController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [PesertaController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [PesertaController::class, 'destroy'])
            ->name('destroy');
        Route::get('/{id}/soft', [PesertaController::class, 'softDelete'])
            ->name('destroy.soft');
        Route::get('/export', [PesertaController::class, 'export'])
            ->name('export');

    });

});