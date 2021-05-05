<?php

use App\Http\Controllers\Grades\GradesKategoriController;
use App\Http\Controllers\Grades\GradesNilaiController;
use App\Http\Controllers\JabatanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    //jabatan
    Route::prefix('jabatan')->name('jabatan.')->middleware('role:developer|administrator')
        ->group(function () {
        
        Route::get('/', [JabatanController::class, 'index'])
            ->name('index');
        Route::get('/create', [JabatanController::class, 'create'])
            ->name('create');
        Route::post('/', [JabatanController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [JabatanController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [JabatanController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [JabatanController::class, 'destroy'])
            ->name('destroy');

    });

    //--- grades management
    Route::prefix('grades')->name('grades.')->middleware('role:developer|administrator')
        ->group(function () {
        
        //kategori
        Route::get('/', [GradesKategoriController::class, 'index'])
            ->name('index');
        Route::get('/create', [GradesKategoriController::class, 'create'])
            ->name('create');
        Route::post('/', [GradesKategoriController::class, 'store'])
            ->name('store');
        Route::get('/{id}/edit', [GradesKategoriController::class, 'edit'])
            ->name('edit');
        Route::put('/{id}', [GradesKategoriController::class, 'update'])
            ->name('update');
        Route::delete('/{id}', [GradesKategoriController::class, 'destroy'])
            ->name('destroy');

        //nilai
        Route::get('/{id}/nilai', [GradesNilaiController::class, 'index'])
            ->name('nilai');
        Route::get('/{id}/nilai/create', [GradesNilaiController::class, 'create'])
            ->name('nilai.create');
        Route::post('/{id}/nilai', [GradesNilaiController::class, 'store'])
            ->name('nilai.store');
        Route::get('/{id}/nilai/{nilaiId}/edit', [GradesNilaiController::class, 'edit'])
            ->name('nilai.edit');
        Route::put('/{id}/nilai/{nilaiId}', [GradesNilaiController::class, 'update'])
            ->name('nilai.update');
        Route::delete('/{id}/nilai/{nilaiId}', [GradesNilaiController::class, 'destroy'])
            ->name('nilai.destroy');

    });

});