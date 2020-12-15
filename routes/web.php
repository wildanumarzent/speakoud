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
Route::get('/access/denide', 'HomeController@denide')
    ->name('denide');

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
Route::get('/course/jadwal/list', 'Course\JadwalController@jadwalList')
    ->name('course.jadwal');
Route::get('/course/jadwal/{id}/detail', 'Course\JadwalController@jadwalDetail')
    ->name('course.jadwal.detail');
Route::get('/course/list', 'Course\MataController@courseList')
    ->name('course.list');
Route::get('/course/{id}/register', 'Course\MataController@courseRegister')
    ->name('course.register')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::get('/course/{id}/detail', 'Course\MataController@courseDetail')
    ->name('course.detail')
    ->middleware('auth');
Route::get('course/{id}/bahan/{bahanId}/{tipe}', 'Course\Bahan\BahanController@view')
    ->name('course.bahan')
    ->middleware('auth');
Route::post('/course/{id}/rating', 'Course\MataController@giveRating')
    ->name('course.rating')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::post('/course/{id}/comment', 'Course\MataController@giveComment')
    ->name('course.comment')
    ->middleware('auth');

//forum
#--topik
Route::get('forum/{id}/topik/{topikId}/room', 'Course\Bahan\BahanForumController@room')
    ->name('forum.topik.room')
    ->middleware('auth');
Route::get('forum/{id}/topik/create', 'Course\Bahan\BahanForumController@createTopik')
    ->name('forum.topik.create')
    ->middleware('auth');
Route::post('forum/{id}/topik', 'Course\Bahan\BahanForumController@storeTopik')
    ->name('forum.topik.store')
    ->middleware('auth');
Route::get('forum/{id}/topik/{topikId}/edit', 'Course\Bahan\BahanForumController@editTopik')
    ->name('forum.topik.edit')
    ->middleware('auth');
Route::put('forum/{id}/topik/{topikId}', 'Course\Bahan\BahanForumController@updateTopik')
    ->name('forum.topik.update')
    ->middleware('auth');
Route::put('/forum/{id}/topik/{topikId}/pin', 'Course\Bahan\BahanForumController@pinTopik')
    ->name('forum.topik.pin')
    ->middleware('auth');
Route::put('/forum/{id}/topik/{topikId}/lock', 'Course\Bahan\BahanForumController@lockTopik')
    ->name('forum.topik.lock')
    ->middleware('auth');
Route::get('/forum/{id}/topik/{topikId}/star', 'Course\Bahan\BahanForumController@starTopik')
    ->name('forum.topik.star')
    ->middleware('auth');
Route::delete('forum/{id}/topik/{topikId}', 'Course\Bahan\BahanForumController@destroyTopik')
    ->name('forum.topik.destroy')
    ->middleware('auth');

#--reply
Route::get('forum/{id}/topik/{topikId}/reply/create', 'Course\Bahan\BahanForumController@createReply')
    ->name('forum.topik.reply.create')
    ->middleware('auth');
Route::post('forum/{id}/topik/{topikId}/reply', 'Course\Bahan\BahanForumController@storeReply')
    ->name('forum.topik.reply.store')
    ->middleware('auth');
Route::get('forum/{id}/topik/{topikId}/reply/{replyId}/edit', 'Course\Bahan\BahanForumController@editReply')
    ->name('forum.topik.reply.edit')
    ->middleware('auth');
Route::put('forum/{id}/topik/{topikId}/reply/{replyId}', 'Course\Bahan\BahanForumController@updateReply')
    ->name('forum.topik.reply.update')
    ->middleware('auth');
Route::delete('forum/{id}/topik/{topikId}/reply/{replyId}', 'Course\Bahan\BahanForumController@destroyReply')
    ->name('forum.topik.reply.destroy')
    ->middleware('auth');

//video conference
Route::get('/conference/{id}/room', 'Course\Bahan\BahanConferenceController@room')
    ->name('conference.room')
    ->middleware('auth');
Route::get('/conference/{id}/leave', 'Course\Bahan\BahanConferenceController@leave')
    ->name('conference.leave')
    ->middleware('auth');
Route::put('/conference/{id}/leave', 'Course\Bahan\BahanConferenceController@leaveConfirm')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);;
Route::get('/conference/{id}/platform/start', 'Course\Bahan\BahanConferenceController@startMeet')
    ->name('conference.platform.start')
    ->middleware('auth');
Route::get('/conference/{id}/peserta/list', 'Course\Bahan\BahanConferenceController@peserta')
    ->name('conference.peserta.list')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::post('/conference/{id}/peserta', 'Course\Bahan\BahanConferenceController@pesertaCheck')
    ->name('conference.peserta')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::put('/conference/{id}/join/{trackId}/verification', 'Course\Bahan\BahanConferenceController@checkInVerified')
    ->name('conference.peserta.check')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::put('/conference/{id}/finish', 'Course\Bahan\BahanConferenceController@finishConference')
    ->name('conference.finish')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);

//quiz
Route::get('/quiz/{id}/test', 'Course\Bahan\BahanQuizItemController@room')
    ->name('quiz.room')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::post('/quiz/{id}/track/jawaban', 'Course\Bahan\BahanQuizItemController@trackJawaban')
    ->name('quiz.track.jawaban')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::post('/quiz/{id}/finish', 'Course\Bahan\BahanQuizItemController@finishQuiz')
    ->name('quiz.finish')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::get('/quiz/{id}/peserta', 'Course\Bahan\BahanQuizItemController@peserta')
    ->name('quiz.peserta')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::get('/quiz/{id}/peserta/{pesertaId}/jawaban', 'Course\Bahan\BahanQuizItemController@jawabanPeserta')
    ->name('quiz.peserta.jawaban')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::put('/item/{id}/essay/{status}', 'Course\Bahan\BahanQuizItemController@checkEssay')
    ->name('quiz.item.essay')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::put('/peserta/{id}/cek', 'Course\Bahan\BahanQuizItemController@checkPeserta')
    ->name('quiz.peserta.cek')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);

//tugas
Route::post('/tugas/{id}/kirim', 'Course\Bahan\BahanTugasController@sendTugas')
    ->name('tugas.send')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::get('/tugas/{id}/peserta', 'Course\Bahan\BahanTugasController@peserta')
    ->name('tugas.peserta')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);

//--evaluasi
#--penyelenggara
Route::get('/course/{id}/evaluasi/penyelenggara', 'Course\EvaluasiController@penyelenggara')
    ->name('evaluasi.penyelenggara')
    ->middleware('auth');
Route::get('/course/{id}/evaluasi/penyelenggara/form', 'Course\EvaluasiController@formPenyelenggara')
    ->name('evaluasi.penyelenggara.form')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::get('/course/{id}/evaluasi/penyelenggara/rekap', 'Course\EvaluasiController@rekapPenyelenggara')
    ->name('evaluasi.penyelenggara.rekap')
    ->middleware(['auth', 'role:administrator|internal|mitra']);
Route::post('/course/{id}/evaluasi/penyelenggara', 'Course\EvaluasiController@submitPenyelenggara')
    ->name('evaluasi.penyelenggara.submit')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
#--pengajar
Route::get('/course/{id}/bahan/{bahanId}/evaluasi/pengajar/form', 'Course\EvaluasiController@formPengajar')
    ->name('evaluasi.pengajar.form')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::get('/course/{id}/bahan/{bahanId}/evaluasi/pengajar/rekap', 'Course\EvaluasiController@rekapPengajar')
    ->name('evaluasi.pengajar.rekap')
    ->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::post('/course/{id}/bahan/{bahanId}/evaluasi/pengajar', 'Course\EvaluasiController@submitPengajar')
    ->name('evaluasi.pengajar.submit')
    ->middleware(['auth', 'role:peserta_internal|peserta_mitra']);

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

//forgot password
Route::get('/forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm')
    ->name('password.email')->middleware('guest');
Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')
    ->middleware('guest');
Route::get('/reset-password/{token}', 'Auth\ResetPasswordController@showResetForm')
    ->name('password.reset')->middleware('guest');
Route::post('/reset-password/send', 'Auth\ResetPasswordController@reset')
    ->name('password.update')->middleware('guest');

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
    //verifikasi email
    Route::get('/profile/email/verification/send', 'Users\UserController@sendVerification')
        ->name('profile.email.verification.send');
    Route::get('/profile/email/verification/{email}', 'Users\UserController@verification')
        ->name('profile.email.verification');

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
    //kategori
    Route::get('/grades', 'Grades\GradesKategoriController@index')
        ->name('grades.index')
        ->middleware('role:developer|administrator');
    Route::get('/grades/create', 'Grades\GradesKategoriController@create')
        ->name('grades.create')
        ->middleware('role:developer|administrator');
    Route::post('/grades', 'Grades\GradesKategoriController@store')
        ->name('grades.store')
        ->middleware('role:developer|administrator');
    Route::get('/grades/{id}/edit', 'Grades\GradesKategoriController@edit')
        ->name('grades.edit')
        ->middleware('role:developer|administrator');
    Route::put('/grades/{id}', 'Grades\GradesKategoriController@update')
        ->name('grades.update')
        ->middleware('role:developer|administrator');
    Route::delete('/grades/{id}', 'Grades\GradesKategoriController@destroy')
        ->name('grades.destroy')
        ->middleware('role:developer|administrator');

    //nilai
    Route::get('/grades/{id}/nilai', 'Grades\GradesNilaiController@index')
        ->name('grades.nilai')
        ->middleware('role:developer|administrator');
    Route::get('/grades/{id}/nilai/create', 'Grades\GradesNilaiController@create')
        ->name('grades.nilai.create')
        ->middleware('role:developer|administrator');
    Route::post('/grades/{id}/nilai', 'Grades\GradesNilaiController@store')
        ->name('grades.nilai.store')
        ->middleware('role:developer|administrator');
    Route::get('/grades/{id}/nilai/{nilaiId}/edit', 'Grades\GradesNilaiController@edit')
        ->name('grades.nilai.edit')
        ->middleware('role:developer|administrator');
    Route::put('/grades/{id}/nilai/{nilaiId}', 'Grades\GradesNilaiController@update')
        ->name('grades.nilai.update')
        ->middleware('role:developer|administrator');
    Route::delete('/grades/{id}/nilai/{nilaiId}', 'Grades\GradesNilaiController@destroy')
        ->name('grades.nilai.destroy')
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

    /**bank soal */
    //kategori
    Route::get('/soal/kategori', 'Soal\SoalKategoriController@index')
        ->name('soal.kategori')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/soal/kategori/create', 'Soal\SoalKategoriController@create')
        ->name('soal.kategori.create')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/soal/kategori', 'Soal\SoalKategoriController@store')
        ->name('soal.kategori.store')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/soal/kategori/{id}/edit', 'Soal\SoalKategoriController@edit')
        ->name('soal.kategori.edit')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/soal/kategori/{id}', 'Soal\SoalKategoriController@update')
        ->name('soal.kategori.update')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::delete('/soal/kategori/{id}', 'Soal\SoalKategoriController@destroy')
        ->name('soal.kategori.destroy')
        ->middleware('role:developer|administrator|internal|mitra');
    //soal
    Route::get('/soal/kategori/{id}', 'Soal\SoalController@index')
        ->name('soal.index')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/soal/kategori/{id}/create', 'Soal\SoalController@create')
        ->name('soal.create')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/soal/kategori/{id}', 'Soal\SoalController@store')
        ->name('soal.store')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/soal/kategori/{id}/edit/{soalId}', 'Soal\SoalController@edit')
        ->name('soal.edit')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/soal/kategori/{id}/{soalId}', 'Soal\SoalController@update')
        ->name('soal.update')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::delete('/soal/kategori/{id}/{soalId}', 'Soal\SoalController@destroy')
        ->name('soal.destroy')
        ->middleware('role:developer|administrator|internal|mitra');

    /**manage course */
    //program pelatihan
    Route::get('/program', 'Course\ProgramController@index')
        ->name('program.index')
        ->middleware('role:developer|administrator|internal|mitra');
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
        ->middleware('role:developer|administrator|internal|mitra');
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

    //mata user
    #--instruktur
    Route::get('mata/{id}/instruktur', 'Course\MataController@instruktur')
        ->name('mata.instruktur')
        ->middleware('role:administrator|internal|mitra');
    Route::post('mata/{id}/instruktur', 'Course\MataController@storeInstruktur')
        ->name('mata.instruktur.store')
        ->middleware('role:administrator|internal|mitra');
    Route::put('mata/{id}/instruktur/{instrukturId}', 'Course\MataController@kodeEvaluasiInstruktur')
        ->name('mata.instruktur.evaluasi')
        ->middleware('role:administrator|internal|mitra');
    Route::delete('mata/{id}/instruktur/{mataInstrukturId}', 'Course\MataController@destroyInstruktur')
        ->name('mata.instruktur.destroy')
        ->middleware('role:administrator|internal|mitra');
    #peserta
    Route::get('mata/{id}/peserta', 'Course\MataController@peserta')
        ->name('mata.peserta')
        ->middleware('role:administrator|internal|mitra');
    Route::post('mata/{id}/peserta', 'Course\MataController@storePeserta')
        ->name('mata.peserta.store')
        ->middleware('role:administrator|internal|mitra');
    Route::put('peserta/{id}/approval/{status}', 'Course\MataController@approvalPeserta')
        ->name('mata.peserta.approval')
        ->middleware('role:administrator|internal|mitra');
    Route::delete('mata/{id}/peserta/{mataPesertaId}', 'Course\MataController@destroyPeserta')
        ->name('mata.peserta.destroy')
        ->middleware('role:administrator|internal|mitra');

    //materi pelatihan
    Route::get('/mata/{id}/materi', 'Course\MateriController@index')
        ->name('materi.index')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/mata/{id}/materi/create', 'Course\MateriController@create')
        ->name('materi.create')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/mata/{id}/materi', 'Course\MateriController@store')
        ->name('materi.store')
        ->middleware('role:developer|administrator|internal|mitra');
     Route::get('/mata/{id}/materi/{materiId}/edit', 'Course\MateriController@edit')
        ->name('materi.edit')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/mata/{id}/materi/{materiId}', 'Course\MateriController@update')
        ->name('materi.update')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/mata/{id}/materi/{materiId}/publish', 'Course\MateriController@publish')
        ->name('materi.publish')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/mata/{id}/materi/{materiId}/position/{position}', 'Course\MateriController@position')
        ->name('materi.position')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/mata/{id}/materi/sort', 'Course\MateriController@sort')
        ->name('materi.sort')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::delete('/mata/{id}/materi/{materiId}', 'Course\MateriController@destroy')
        ->name('materi.destroy')
        ->middleware('role:developer|administrator|internal|mitra');

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
    Route::post('scorm/checkpoint/store', 'Course\Bahan\BahanScormController@store');

    //jadwal pelatihan
    Route::get('/jadwal', 'Course\JadwalController@index')
        ->name('jadwal.index')
        ->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
    Route::get('/jadwal/create', 'Course\JadwalController@create')
        ->name('jadwal.create')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::post('/jadwal', 'Course\JadwalController@store')
        ->name('jadwal.store')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::get('/jadwal/{id}/edit', 'Course\JadwalController@edit')
        ->name('jadwal.edit')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/jadwal/{id}', 'Course\JadwalController@update')
        ->name('jadwal.update')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::put('/jadwal/{id}/publish', 'Course\JadwalController@publish')
        ->name('jadwal.publish')
        ->middleware('role:developer|administrator|internal|mitra');
    Route::delete('/jadwal/{id}', 'Course\JadwalController@destroy')
        ->name('jadwal.destroy')
        ->middleware('role:developer|administrator|internal|mitra');

    //evaluasi
    Route::get('/evaluasi', 'Course\EvaluasiController@index')
        ->name('evaluasi.index');

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
    Route::post('/komentar','Component\KomentarController@store')->name('komentar.store');
    Route::delete('/komentar/delete/{id}','Component\KomentarController@destroy')->name('komentar.destroy');

     // Tags
     Route::get('/tags','Component\TagsController@index')->name('tags.index');
     Route::get('/tags/{tags}','Component\TagsController@edit')->name('tags.edit');
     Route::post('/tags','Component\TagsController@store')->name('tags.store');
     Route::put('/tags','Component\TagsController@update')->name('tags.update');
     Route::delete('/tags/{id}','Component\TagsController@destroy')->name('tags.destroy');

     // Announcement
     Route::get('/announcement','Component\AnnouncementController@index')->name('announcement.index');
     Route::get('/announcement/create','Component\AnnouncementController@create')->name('announcement.create');
     Route::get('/announcement/{announcement}','Component\AnnouncementController@edit')->name('announcement.edit');
     Route::get('/announcement/{announcement}/show','Component\AnnouncementController@show')->name('announcement.show');
     Route::post('/announcement','Component\AnnouncementController@store')->name('announcement.store');
     Route::put('/announcement','Component\AnnouncementController@update')->name('announcement.update');
     Route::put('/announcement/{id}','Component\AnnouncementController@publish')->name('announcement.publish');
     Route::delete('/announcement/delete/{id}','Component\AnnouncementController@destroy')->name('announcement.destroy');



      // Statistic
    Route::get('/statistic','Component\StatisticController@index')->name('statistic.index');

    /** Frontend Component */
    // Inquiry
    // Route::get('/inquiry','InquiryController@index')->name('inquiry.index');
    // Route::get('/inquiry/create','InquiryController@create')->name('inquiry.create');
    // Route::get('/inquiry/{id}','InquiryController@detail')->name('inquiry.detail');
    // Route::post('/inquiry','InquiryController@store')->name('inquiry.store');
    // Route::delete('/inquiry/{id}','InquiryController@destroy')->name('inquiry.destroy');

    //fullcalender
    Route::get('kalender','EventController@index')->name('kalender.index');
    Route::post('event/store','EventController@store');
    Route::post('event/update','EventController@update');
    Route::post('event/delete','EventController@destroy');


    //logout
    Route::post('/logout', 'Auth\LoginController@logout')
        ->name('logout');
});

//stream file
Route::get('/bank/data/view/{path}', 'BankDataController@streamFile')
        ->where('path', '^.*\.(jpg|JPG|jpeg|JPEG|png|PNG|pdf|PDF|ppt|PPT|pptx|PPTX|mp3|MP3|mp4|MP4|webm|WEBM|doc|DOC|docx|DOCX|xls|XLS|xlsx|XLSX|html)$')
        ->name('bank.data.stream');
