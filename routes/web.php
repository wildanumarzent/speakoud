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
 * frontend
 */
//home
Route::get('/', 'HomeController@index')
    ->name('home');

//pages
Route::get('/content/page/{id}/{slug}', 'PageController@read')
    ->name('page.read');

//artikel
Route::get('/content/artikel/list', 'ArtikelController@list')
    ->name('artikel.list');
Route::get('/content/artikel/{id}/{slug}', 'ArtikelController@read')
    ->name('artikel.read');

//inquiry
Route::get('inquiry/{slug}', 'InquiryController@read')
    ->name('inquiry.read');
Route::post('inquiry/{id}/send', 'InquiryController@send')
    ->name('inquiry.send');

//course
Route::get('/course/list', 'Course\MataController@courseList')
    ->name('course.list');
Route::get('/course/{id}/detail', 'Course\MataController@courseDetail')
    ->name('course.detail')
    ->middleware('auth');
Route::post('/course/{id}/rating', 'Course\MataController@giveRating')
    ->name('course.rating')
    ->middleware('role:peserta_internal|peserta_mitra');
Route::get('course/{id}/bahan/{bahanId}/{tipe}', 'Course\Bahan\BahanController@view')
    ->name('course.bahan')
    ->middleware('auth');

//forum
Route::get('forum/{id}/topik/create', 'Course\Bahan\BahanForumController@createTopik')
    ->name('forum.topik.create')
    ->middleware('auth');
Route::get('forum/{id}/topik/{topikId}/room', 'Course\Bahan\BahanForumController@room')
    ->name('forum.topik.room')
    ->middleware('auth');
Route::post('forum/{id}/topik', 'Course\Bahan\BahanForumController@storeTopik')
    ->name('forum.topik.store')
    ->middleware('auth');
Route::put('/forum/{id}/topik/{topikId}/pin', 'Course\Bahan\BahanForumController@pinTopik')
    ->name('forum.topik.pin')
    ->middleware('auth');
Route::put('/forum/{id}/topik/{topikId}/lock', 'Course\Bahan\BahanForumController@lockTopik')
    ->name('forum.topik.lock')
    ->middleware('auth');
Route::get('/forum/{id}/topik/{topikId}/star', 'Course\Bahan\BahanForumController@starTopik')
    ->name('forum.topik.star')
    ->middleware('role:peserta_internal|peserta_mitra');

/**
 * authentication
 */
//login
Route::get('/login', 'Auth\LoginController@showLoginForm')
    ->name('login')
    ->middleware('guest');
Route::post('/login', 'Auth\LoginController@login')
    ->middleware('guest');

//register
Route::get('/register', 'Auth\RegisterController@showRegisterForm')
    ->name('register')
    ->middleware('guest');
Route::post('/register', 'Auth\RegisterController@register')
    ->middleware('guest');
Route::get('/register/activate/{email}', 'Auth\RegisterController@activate')
    ->name('register.activate')
    ->middleware('guest');
/**
 * panel
 */
Route::group(['middleware' => ['auth']], function () {

    // dashboard
    Route::get('/dashboard', 'HomeController@dashboard')
        ->name('dashboard');

    //profile
    Route::get('/profile', 'Users\UserController@profile')
        ->name('profile');
    Route::get('/profile/edit', 'Users\UserController@profileForm')
        ->name('profile.edit');
    Route::put('/profile/edit', 'Users\UserController@updateProfile');

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
    Route::put('/instansi/internal/{id}/soft', 'Instansi\InstansiInternalController@destroySoft')
        ->name('instansi.internal.destroy.soft')
        ->middleware('role:developer|administrator');
    Route::delete('/instansi/internal/{id}', 'Instansi\InstansiInternalController@destroy')
        ->name('instansi.internal.destroy')
        ->middleware('role:developer|administrator');

    //instansi mitra
    Route::get('/instansi/mitra', 'Instansi\InstansiMitraController@index')
        ->name('instansi.mitra.index')
        ->middleware('role:developer|administrator|internal');
    Route::get('/instansi/mitra/create', 'Instansi\InstansiMitraController@create')
        ->name('instansi.mitra.create')
        ->middleware('role:developer|administrator|internal');
    Route::post('/instansi/mitra', 'Instansi\InstansiMitraController@store')
        ->name('instansi.mitra.store')
        ->middleware('role:developer|administrator|internal');
    Route::get('/instansi/mitra/{id}/edit', 'Instansi\InstansiMitraController@edit')
        ->name('instansi.mitra.edit')
        ->middleware('role:developer|administrator|internal');
    Route::put('/instansi/mitra/{id}', 'Instansi\InstansiMitraController@update')
        ->name('instansi.mitra.update')
        ->middleware('role:developer|administrator|internal');
    Route::delete('/instansi/mitra/{id}', 'Instansi\InstansiMitraController@destroy')
        ->name('instansi.mitra.destroy')
        ->middleware('role:developer|administrator|internal');

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
        ->middleware('role:developer|administrator|internal');

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

    //--- grades management
    Route::get('/grades/letter', 'Grades\GradesLetterController@index')
        ->name('grades.letter')
        ->middleware('role:developer|administrator');
    Route::get('/grades/letter/create', 'Grades\GradesLetterController@create')
        ->name('grades.letter.create')
        ->middleware('role:developer|administrator');
    Route::post('/grades/letter', 'Grades\GradesLetterController@store')
        ->name('grades.letter.store')
        ->middleware('role:developer|administrator');
    Route::get('/grades/letter/{id}/edit', 'Grades\GradesLetterController@edit')
        ->name('grades.letter.edit')
        ->middleware('role:developer|administrator');
    Route::put('/grades/letter/{id}', 'Grades\GradesLetterController@update')
        ->name('grades.letter.update')
        ->middleware('role:developer|administrator');
    Route::delete('/grades/letter/{id}', 'Grades\GradesLetterController@destroy')
        ->name('grades.letter.destroy')
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
    Route::put('/program/{id}/publish', 'Course\ProgramController@publish')
        ->name('program.publish')
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

    //materi pelatihan
    Route::get('/mata/{id}/materi', 'Course\MateriController@index')
        ->name('materi.index')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/mata/{id}/materi/create', 'Course\MateriController@create')
        ->name('materi.create')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::post('/mata/{id}/materi', 'Course\MateriController@store')
        ->name('materi.store')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
     Route::get('/mata/{id}/materi/{materiId}/edit', 'Course\MateriController@edit')
        ->name('materi.edit')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::put('/mata/{id}/materi/{materiId}', 'Course\MateriController@update')
        ->name('materi.update')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::put('/mata/{id}/materi/{materiId}/publish', 'Course\MateriController@publish')
        ->name('materi.publish')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::put('/mata/{id}/materi/{materiId}/position/{position}', 'Course\MateriController@position')
        ->name('materi.position')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::post('/mata/{id}/materi/sort', 'Course\MateriController@sort')
        ->name('materi.sort')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::delete('/mata/{id}/materi/{materiId}', 'Course\MateriController@destroy')
        ->name('materi.destroy')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');

    //bahan pelatihan
    Route::get('/materi/{id}/bahan', 'Course\Bahan\BahanController@index')
        ->name('bahan.index')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/materi/{id}/bahan/create', 'Course\Bahan\BahanController@create')
        ->name('bahan.create')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::post('/materi/{id}/bahan', 'Course\Bahan\BahanController@store')
        ->name('bahan.store')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/materi/{id}/bahan/{bahanId}/edit', 'Course\Bahan\BahanController@edit')
        ->name('bahan.edit')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::put('/materi/{id}/bahan/{bahanId}', 'Course\Bahan\BahanController@update')
        ->name('bahan.update')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::put('/materi/{id}/bahan/{bahanId}/publish', 'Course\Bahan\BahanController@publish')
        ->name('bahan.publish')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::put('/materi/{id}/bahan/{bahanId}/position/{position}', 'Course\Bahan\BahanController@position')
        ->name('bahan.position')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::post('/materi/{id}/bahan/sort', 'Course\Bahan\BahanController@sort')
        ->name('bahan.sort')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::delete('/materi/{id}/bahan/{bahanId}', 'Course\Bahan\BahanController@destroy')
        ->name('bahan.destroy')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');

    //bahan quiz item
    Route::get('/quiz/{id}/item', 'Course\Bahan\BahanQuizItemController@index')
        ->name('quiz.item')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/quiz/{id}/item/create', 'Course\Bahan\BahanQuizItemController@create')
        ->name('quiz.item.create')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::post('/quiz/{id}/item/store', 'Course\Bahan\BahanQuizItemController@store')
        ->name('quiz.item.store')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/quiz/{id}/item/{itemId}/edit', 'Course\Bahan\BahanQuizItemController@edit')
        ->name('quiz.item.edit')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::put('/quiz/{id}/item/{itemId}', 'Course\Bahan\BahanQuizItemController@update')
        ->name('quiz.item.update')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::delete('/quiz/{id}/item/{itemId}', 'Course\Bahan\BahanQuizItemController@destroy')
        ->name('quiz.item.destroy')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');

    // Bahan Scorm
    Route::get('/scorm/{id}','Course\Bahan\BahanScormController@show')->name('scorm.detail');

    /**Website module */
    //page
    Route::get('/page', 'PageController@index')
        ->name('page.index')
        ->middleware('role:developer|administrator');
    Route::get('/page/create', 'PageController@create')
        ->name('page.create')
        ->middleware('role:developer|administrator');
    Route::post('/page', 'PageController@store')
        ->name('page.store')
        ->middleware('role:developer|administrator');
    Route::get('/page/{id}/edit', 'PageController@edit')
        ->name('page.edit')
        ->middleware('role:developer|administrator');
    Route::put('/page/{id}', 'PageController@update')
        ->name('page.update')
        ->middleware('role:developer|administrator');
    Route::put('/page/{id}/publish', 'PageController@publish')
        ->name('page.publish')
        ->middleware('role:developer|administrator');
    Route::put('/page/{id}/position/{position}/{parent}', 'PageController@position')
        ->name('page.position')
        ->middleware('role:developer|administrator');
    Route::delete('/page/{id}', 'PageController@destroy')
        ->name('page.destroy')
        ->middleware('role:developer|administrator');

    //banner kategori
    Route::get('/banner', 'Banner\BannerKategoriController@index')
        ->name('banner.index')
        ->middleware('role:developer|administrator');
    Route::get('/banner/create', 'Banner\BannerKategoriController@create')
        ->name('banner.create')
        ->middleware('role:developer');
    Route::post('/banner', 'Banner\BannerKategoriController@store')
        ->name('banner.store')
        ->middleware('role:developer');
    Route::get('/banner/{id}/edit', 'Banner\BannerKategoriController@edit')
        ->name('banner.edit')
        ->middleware('role:developer|administrator');
    Route::put('/banner/{id}', 'Banner\BannerKategoriController@update')
        ->name('banner.update')
        ->middleware('role:developer|administrator');
    Route::delete('/banner/{id}', 'Banner\BannerKategoriController@destroy')
        ->name('banner.destroy')
        ->middleware('role:developer');

    //banner media
    Route::get('/banner/{id}/media', 'Banner\BannerController@index')
        ->name('banner.media')
        ->middleware('role:developer|administrator');
    Route::get('/banner/{id}/media/create', 'Banner\BannerController@create')
        ->name('banner.media.create')
        ->middleware('role:developer|administrator');
    Route::post('/banner/{id}/media', 'Banner\BannerController@store')
        ->name('banner.media.store')
        ->middleware('role:developer|administrator');
    Route::get('/banner/{id}/media/{bannerId}/edit', 'Banner\BannerController@edit')
        ->name('banner.media.edit')
        ->middleware('role:developer|administrator');
    Route::put('/banner/{id}/media/{bannerId}', 'Banner\BannerController@update')
        ->name('banner.media.update')
        ->middleware('role:developer|administrator');
    Route::put('/banner/{id}/media/{bannerId}/publish', 'Banner\BannerController@publish')
        ->name('banner.media.publish')
        ->middleware('role:developer|administrator');
    Route::post('/banner/{id}/media/sort', 'Banner\BannerController@sort')
        ->name('banner.media.sort')
        ->middleware('role:developer|administrator');
    Route::delete('/banner/{id}/media/{bannerId}', 'Banner\BannerController@destroy')
        ->name('banner.media.destroy')
        ->middleware('role:developer|administrator');

    //inquiry
    Route::get('/inquiry', 'InquiryController@index')
        ->name('inquiry.index')
        ->middleware('role:developer|administrator');
    Route::get('/inquiry/{id}/edit', 'InquiryController@edit')
        ->name('inquiry.edit')
        ->middleware('role:developer|administrator');
    Route::put('/inquiry/{id}', 'InquiryController@update')
        ->name('inquiry.update')
        ->middleware('role:developer|administrator');
    Route::put('/inquiry/contact/{id}/read', 'InquiryController@readContact')
        ->name('inquiry.contact.read')
        ->middleware('role:developer|administrator');
    Route::delete('/inquiry/contact/{id}', 'InquiryController@destroy')
        ->name('inquiry.contact.destroy')
        ->middleware('role:developer|administrator');

    //konfigurasi
    Route::get('/konfigurasi/konten', 'KonfigurasiController@index')
        ->name('config.index')
        ->middleware('role:developer|administrator');
    Route::put('/konfigurasi/update', 'KonfigurasiController@update')
        ->name('config.update')
        ->middleware('role:developer|administrator');
    Route::put('/konfigurasi/upload/{name}', 'KonfigurasiController@upload')
        ->name('config.upload')
        ->middleware('role:developer|administrator');
    Route::get('/konfigurasi/strip', 'KonfigurasiController@strip')
        ->name('config.strip')
        ->middleware('role:developer|administrator');

    /** Artikel dan Component nya */
    // Artikel
    Route::get('/artikel', 'ArtikelController@index')
        ->name('artikel.index')
        ->middleware('role:developer|administrator');
    Route::get('/artikel/create', 'ArtikelController@create')
        ->name('artikel.create')
        ->middleware('role:developer|administrator');
    Route::post('/artikel', 'ArtikelController@store')
        ->name('artikel.store')
        ->middleware('role:developer|administrator');
    Route::get('/artikel/{id}/edit', 'ArtikelController@edit')
        ->name('artikel.edit')
        ->middleware('role:developer|administrator');
    Route::put('/artikel/{id}', 'ArtikelController@update')
        ->name('artikel.update')
        ->middleware('role:developer|administrator');
    Route::put('/artikel/{id}/publish', 'ArtikelController@publish')
        ->name('artikel.publish')
        ->middleware('role:developer|administrator');
    Route::delete('/artikel/{id}', 'ArtikelController@destroy')
        ->name('artikel.destroy')
        ->middleware('role:developer|administrator');
    // Route::get('/artikel','ArtikelController@list')->name('artikel.list');
    // Route::get('/artikel/manage','ArtikelController@index')->name('artikel.index');
    // Route::get('/artikel/create','ArtikelController@create')->name('artikel.create');
    // Route::get('/artikel/{id}/{slug}','ArtikelController@show')->name('artikel.show');
    // Route::get('/artikel/{id}','ArtikelController@edit')->name('artikel.edit');
    // Route::post('/artikel','ArtikelController@store')->name('artikel.store');
    // Route::delete('/artikel/{id}','ArtikelController@destroy')->name('artikel.destroy');

    // Komentar
    Route::get('/komentar','Component\KomentarController@index')->name('komentar.index');
    Route::get('/komentar/create','Component\KomentarController@create')->name('komentar.create');
    Route::post('/komentar','Component\KomentarController@store')->name('komentar.store');
    Route::delete('/komentar/{id}','Component\KomentarController@destroy')->name('komentar.destroy');

     // Tags
     Route::get('/tags','Component\TagsController@index')->name('tags.index');
     Route::get('/tags/{tags}','Component\TagsController@edit')->name('tags.edit');
     Route::post('/tags','Component\TagsController@store')->name('tags.store');
     Route::put('/tags','Component\TagsController@update')->name('tags.update');
     Route::delete('/tags/{id}','Component\TagsController@destroy')->name('tags.destroy');

    /** Frontend Component */
    // Inquiry
    // Route::get('/inquiry','InquiryController@index')->name('inquiry.index');
    // Route::get('/inquiry/create','InquiryController@create')->name('inquiry.create');
    // Route::get('/inquiry/{id}','InquiryController@detail')->name('inquiry.detail');
    // Route::post('/inquiry','InquiryController@store')->name('inquiry.store');
    // Route::delete('/inquiry/{id}','InquiryController@destroy')->name('inquiry.destroy');
    // Kalender Diklat
    Route::get('/kalender','KalenderController@index')->name('kalender.index');
    Route::get('/kalender/create','KalenderController@create')->name('kalender.create');
    Route::get('/kalender/{id}','KalenderController@detail')->name('kalender.detail');
    Route::post('/kalender','KalenderController@store')->name('kalender.store');
    Route::delete('/kalender/{id}','KalenderController@destroy')->name('kalender.destroy');


    //logout
    Route::post('/logout', 'Auth\LoginController@logout')
        ->name('logout');
});


//stream file
Route::get('/bank/data/view/{path}', 'BankDataController@streamFile')
        ->where('path', '^.*\.(jpg|JPG|jpeg|JPEG|png|PNG|pdf|PDF|ppt|PPT|pptx|PPTX|mp3|MP3|mp4|MP4|webm|WEBM|doc|DOC|docx|DOCX|xls|XLS|xlsx|XLSX|html)$')
        ->name('bank.data.stream');
