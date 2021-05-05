<?php

use App\Http\Controllers\Instansi\InstansiInternalController;
use App\Http\Controllers\Instansi\InstansiMitraController;
use Illuminate\Support\Facades\Route;

Route::prefix('instansi')->name('instansi.')->middleware('auth')->group(function () {

    //internal
    Route::prefix('internal')->name('internal.')->middleware('role:developer|administrator')
        ->group(function () {
        
            Route::get('/', [InstansiInternalController::class, 'index'])
                ->name('index');
            Route::get('/create', [InstansiInternalController::class, 'create'])
                ->name('create');
            Route::post('/', [InstansiInternalController::class, 'store'])
                ->name('store');
            Route::get('/{id}/edit', [InstansiInternalController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [InstansiInternalController::class, 'update'])
                ->name('update');
            Route::delete('/{id}', [InstansiInternalController::class, 'destroy'])
                ->name('destroy');

    });

    //mitra
    Route::prefix('mitra')->name('mitra.')->middleware('role:developer|administrator|internal')
        ->group(function () {
        
            Route::get('/', [InstansiMitraController::class, 'index'])
                ->name('index');
            Route::get('/create', [InstansiMitraController::class, 'create'])
                ->name('create');
            Route::post('/', [InstansiMitraController::class, 'store'])
                ->name('store');
            Route::get('/{id}/edit', [InstansiMitraController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [InstansiMitraController::class, 'update'])
                ->name('update');
            Route::delete('/{id}', [InstansiMitraController::class, 'destroy'])
                ->name('destroy');

    });

});



    