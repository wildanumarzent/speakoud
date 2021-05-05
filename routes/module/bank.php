<?php

use App\Http\Controllers\BankDataController;
use App\Http\Controllers\Soal\SoalController;
use App\Http\Controllers\Soal\SoalKategoriController;
use Illuminate\Support\Facades\Route;


Route::middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra')
    ->group(function () {
    
    /**bank data */
    Route::get('/bank/data/{type}', [BankDataController::class, 'index'])
        ->name('bank.data');
    Route::get('/bank/data/filemanager/view', [BankDataController::class, 'filemanager'])
        ->name('bank.data.filemanager');
    
    //directory
    Route::post('/directory', [BankDataController::class, 'storeDirectory'])
        ->name('bank.data.directory.store');
    Route::delete('/directory', [BankDataController::class, 'destroyDirectory'])
        ->name('bank.data.directory.destroy');
    
    //file
    Route::post('/files', [BankDataController::class, 'storeFile'])
        ->name('bank.data.files.store');
    Route::put('/files/{id}', [BankDataController::class, 'updateFile'])
        ->name('bank.data.files.update');
    Route::delete('/files/{id}', [BankDataController::class, 'destroyFile'])
        ->name('bank.data.files.destroy');

    /**bank soal */
    //kategori
    Route::get('bank/soal', [SoalKategoriController::class, 'mata'])
        ->name('soal.mata');
    Route::prefix('mata/{id}/soal/kategori')->name('soal.')->group(function () {   

        Route::get('/', [SoalKategoriController::class, 'index'])
            ->name('kategori');
        Route::get('/create', [SoalKategoriController::class, 'create'])
            ->name('kategori.create');
        Route::post('/', [SoalKategoriController::class, 'store'])
            ->name('kategori.store');
        Route::get('/{kategoriId}/edit', [SoalKategoriController::class, 'edit'])
            ->name('kategori.edit');
        Route::put('/{kategoriId}', [SoalKategoriController::class, 'update'])
            ->name('kategori.update');
        Route::delete('/{kategoriId}', [SoalKategoriController::class, 'destroy'])
            ->name('kategori.destroy');

        //soal
        Route::get('/{kategoriId}', [SoalController::class, 'index'])
            ->name('index');
        Route::get('/{kategoriId}/create', [SoalController::class, 'create'])
            ->name('create');
        Route::post('/{kategoriId}', [SoalController::class, 'store'])
            ->name('store');
        Route::post('/{kategoriId}/import', [SoalController::class, 'import'])
            ->name('import');
        Route::get('/{kategoriId}/edit/{soalId}', [SoalController::class, 'edit'])
            ->name('edit');
        Route::put('/{kategoriId}/{soalId}', [SoalController::class, 'update'])
            ->name('update');
        Route::delete('/{kategoriId}/{soalId}', [SoalController::class, 'destroy'])
            ->name('destroy');
    });

    Route::get('soal/kategori/json/{quizId}', [SoalController::class, 'soalByKategori'])
            ->name('soal.json');

});

//stream
Route::get('/bank/data/view/{path}', [BankDataController::class, 'streamFile'])
    ->where('path', '^.*\.(jpg|JPG|jpeg|JPEG|png|PNG|pdf|PDF|ppt|PPT|pptx|PPTX|mp3|MP3|wav|WAV|mp4|MP4|webm|WEBM|doc|DOC|docx|DOCX|xls|XLS|xlsx|XLSX|html)$')
    ->name('bank.data.stream');