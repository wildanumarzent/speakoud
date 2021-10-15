<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\Pelatihan\PelatihanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Component\NotificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Users\PesertaController;
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
Route::get('/', [HomeController::class, 'index'])
->name('home');

Route::get('/agenda/kegiatan', [HomeController::class, 'events'])
	->name('agenda.kegiatan');
Route::get('/detail/{id}/agenda', [HomeController::class, 'detailAgenda'])
	->name('detail.agenda');
	Route::get('agenda/list','EventController@list')->name('agenda.list');

	Route::get('/access/denide', [HomeController::class, 'denide'])
	->name('denide');
	
	//pages
	Route::get('/content/page/{id}/{slug}', [PageController::class, 'read'])
	->name('page.read');
	
	//artikel
	Route::get('/content/artikel/list', [ArtikelController::class, 'list'])
	->name('artikel.list');
	Route::get('/content/artikel/{id}/{slug}', [ArtikelController::class, 'read'])
	->name('artikel.read');
	
	
	//inquiry
	Route::get('inquiry/{slug}', [InquiryController::class, 'read'])
	->name('inquiry.read');
	Route::post('inquiry/{id}/send', [InquiryController::class, 'send'])
	->name('inquiry.send');
	
	// TENTANG KAMI
	Route::get('/page/{slug}', [AboutController::class, 'aboutUs'])
		->name('about.index');

	// Event front End
	// Route::get('/jadwal', [JadwalController::class, 'index'])
	//     ->name('events.agenda');
	
	
//login
Route::get('/login', [LoginController::class, 'showLoginForm'])
	->name('login')
	->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])
	->middleware('guest');

//register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])
	->name('register');
Route::get('/register/{mataId}/free', [RegisterController::class, 'showRegisterFormFree'])
	->name('register.free');
Route::get('/register/{mataId}/Khusus', [RegisterController::class, 'showRegisterPelatihan'])
	->name('register.platihanKhusus')
	->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])
	->middleware('guest');
Route::get('/register/activate/{email}', [RegisterController::class, 'activate'])
	->name('register.activate')
	->middleware('guest');

//forgot password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
	->name('password.email')->middleware('guest');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
	->middleware('guest');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
	->name('password.reset')->middleware('guest');
Route::post('/reset-password/send', [ResetPasswordController::class, 'reset'])
	->name('password.update')->middleware('guest');

/**
 * panel
 */
Route::group(['middleware' => ['auth']], function () {

	// dashboard
	Route::get('/dashboard', [HomeController::class, 'dashboard'])
		->name('dashboard');

	/**manage course */
	//program pelatihan
	Route::get('/program', 'Course\ProgramController@index')
		->name('program.index')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::get('/program/create', 'Course\ProgramController@create')
		->name('program.create')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::post('/program', 'Course\ProgramController@store')
		->name('program.store')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::get('/program/{id}/edit', 'Course\ProgramController@edit')
		->name('program.edit')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::put('/program/{id}', 'Course\ProgramController@update')
		->name('program.update')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::put('/program/{id}/publish', 'Course\ProgramController@publish')
		->name('program.publish')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::put('/program/{id}/position/{position}', 'Course\ProgramController@position')
		->name('program.position')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::delete('/program/{id}', 'Course\ProgramController@destroy')
		->name('program.destroy')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::post('/program/sort', 'Course\ProgramController@sort')
		->name('program.sort')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');

	//mata pelatihan
	Route::get('/program/{id}/mata', 'Course\MataController@index')
		->name('mata.index')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::get('/program/history', 'Course\MataController@history')
		->name('mata.history');
	Route::get('/program/{id}/mata/create', 'Course\MataController@create')
		->name('mata.create')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::post('/program/{id}/mata', 'Course\MataController@store')
		->name('mata.store')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::get('/program/{id}/mata/{mataId}/edit', 'Course\MataController@edit')
		->name('mata.edit')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::put('/program/{id}/mata/{mataId}', 'Course\MataController@update')
		->name('mata.update')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::put('/program/{id}/mata/{mataId}/publish', 'Course\MataController@publish')
		->name('mata.publish')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::put('/program/{id}/mata/{mataId}/position/{position}', 'Course\MataController@position')
		->name('mata.position')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::post('/program/{id}/mata/sort', 'Course\MataController@sort')
		->name('mata.sort')
		->middleware('role:developer|administrator|internal|mitra');
	Route::delete('/program/{id}/mata/{mataId}', 'Course\MataController@destroy')
		->name('mata.destroy')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal');
	Route::get('/mata/{mataId}/peserta/export', 'Course\MataController@pesertaExport')
		->name('mata.peserta.export');

	//mata user
	#--instruktur
	Route::get('mata/{id}/instruktur', 'Course\MataController@instruktur')
		->name('mata.instruktur')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::post('mata/{id}/instruktur', 'Course\MataController@storeInstruktur')
		->name('mata.instruktur.store')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::post('mata/{id}/instruktur/import', 'Course\MataController@importInstruktur')
		->name('mata.instruktur.import')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::put('mata/{id}/instruktur/{instrukturId}', 'Course\MataController@kodeEvaluasiInstruktur')
		->name('mata.instruktur.evaluasi')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::delete('mata/{id}/instruktur/{mataInstrukturId}', 'Course\MataController@destroyInstruktur')
		->name('mata.instruktur.destroy')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	#peserta
	Route::get('mata/{id}/peserta', 'Course\MataController@peserta')
		->name('mata.peserta')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::post('mata/{id}/peserta', 'Course\MataController@storePeserta')
		->name('mata.peserta.store')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::post('mata/{id}/peserta/import', 'Course\MataController@importPeserta')
		->name('mata.peserta.import')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::put('peserta/{id}/approval/{status}', 'Course\MataController@approvalPeserta')
		->name('mata.peserta.approval')
		->middleware('role:administrator|internal|mitra');
	Route::delete('mata/{id}/peserta/{mataPesertaId}', 'Course\MataController@destroyPeserta')
		->name('mata.peserta.destroy')
		->middleware('role:administrator|internal|mitra|instruktur_internal');

	//mata laporan
	#-- pembobotan nilai
	Route::get('mata/{id}/pembobotan', 'Course\MataActivityController@pembobotan')
		->name('mata.pembobotan')
		->middleware('role:administrator|internal|mitra');
	#-- activity completion
	Route::get('mata/{id}/completion', 'Course\MataActivityController@completion')
		->name('mata.completion')
		->middleware('role:administrator|internal|mitra|instruktur_internal|instruktur_mitra');
	Route::post('completion/submit/{bahanId}/{userId}', 'Course\MataActivityController@submitCompletion')
		->name('mata.completion.submit')
		->middleware('role:administrator|internal|mitra|instruktur_internal|instruktur_mitra');
	Route::put('completion/{id}/status', 'Course\MataActivityController@statusCompletion')
		->name('mata.completion.status')
		->middleware('role:administrator|internal|mitra|instruktur_internal|instruktur_mitra');
	#-- compare test
	Route::get('mata/{id}/compare', 'Course\MataActivityController@compare')
		->name('mata.compare')
		->middleware('role:administrator|internal|mitra');
	// Export
	Route::get('mata/{id}/export/activity','Course\MataActivityController@activityExport')
		->name('mata.export.activity')
		->middleware('role:administrator|internal|mitra');
	#penilaian
	Route::get('/mata/{id}/nilai/peserta', 'Course\MataActivityController@nilaiPeserta')
		->name('mata.nilai.peserta');

	//materi pelatihan
	Route::get('/mata/{id}/materi', 'Course\MateriController@index')
		->name('materi.index')
		->middleware('role:developer|administrator|instruktur_internal');
	Route::get('/mata/{id}/materi/create', 'Course\MateriController@create')
		->name('materi.create')
		->middleware('role:developer|administrator|internal|instruktur_internal');
	Route::post('/mata/{id}/materi', 'Course\MateriController@store')
		->name('materi.store')
		->middleware('role:developer|administrator|internal|instruktur_internal');
	 Route::get('/mata/{id}/materi/{materiId}/edit', 'Course\MateriController@edit')
		->name('materi.edit')
		->middleware('role:developer|administrator|internal|instruktur_internal');
	Route::put('/mata/{id}/materi/{materiId}', 'Course\MateriController@update')
		->name('materi.update')
		->middleware('role:developer|administrator|internal|instruktur_internal');
	Route::put('/mata/{id}/materi/{materiId}/publish', 'Course\MateriController@publish')
		->name('materi.publish')
		->middleware('role:developer|administrator|internal|instruktur_internal');
	Route::put('/mata/{id}/materi/{materiId}/position/{position}', 'Course\MateriController@position')
		->name('materi.position')
		->middleware('role:developer|administrator|internal|instruktur_internal');
	Route::post('/mata/{id}/materi/sort', 'Course\MateriController@sort')
		->name('materi.sort')
		->middleware('role:developer|administrator|internal|instruktur_internal');
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
	Route::get('/quiz/{id}/preview', 'Course\Bahan\BahanQuizItemController@preview')
		->name('quiz.preview')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
	Route::get('/quiz/{id}/item/create', 'Course\Bahan\BahanQuizItemController@create')
		->name('quiz.item.create')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
	Route::post('/quiz/{id}/item/store', 'Course\Bahan\BahanQuizItemController@store')
		->name('quiz.item.store')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');
	Route::post('/quiz/{id}/item/input', 'Course\Bahan\BahanQuizItemController@storeFromBank')
		->name('quiz.item.input')
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
	Route::delete('/quiz/{id}/item/destroy/check', 'Course\Bahan\BahanQuizItemController@destroyCheck')
		->name('quiz.item.destroyCheck')
		->middleware('role:developer|administrator|internal|mitra|instruktur_internal|instruktur_mitra');

	// Bahan Scorm
	Route::get('/scorm/{id}','Course\Bahan\BahanScormController@show')->name('scorm.detail');
	Route::post('scorm/checkpoint/store', 'Course\Bahan\BahanScormController@store');

	//activity
	Route::post('/activity/{bahanId}/complete', 'Course\Bahan\BahanController@activityComplete')
		->name('activity.complete');
	Route::get('/read/{id}/complite', 'Course\Bahan\BahanController@readDocumentComplite')
		->name('read.complete');

	//templating
	Route::post('/template/{id}/mata/copy', 'Course\TemplatingController@copyAsTemplate')
		->name('template.mata.copy')
		->middleware('role:developer|administrator|internal');
	//mata
	Route::get('/program/{id}/mata/template/{templateId}/create', 'Course\TemplatingController@createMata')
		->name('mata.create.template')
		->middleware('role:developer|administrator|internal');
	Route::post('/program/{id}/mata/template/{templateId}', 'Course\TemplatingController@storeMata')
		->name('mata.store.template')
		->middleware('role:developer|administrator|internal');
	//enroll
	Route::get('/mata/{id}/enroll/template/{templateId}/create', 'Course\TemplatingController@createEnroll')
		->name('enroll.create.template')
		->middleware('role:developer|administrator|internal');
	Route::post('/mata/{id}/enroll/template/{templateId}/store', 'Course\TemplatingController@storeEnroll')
		->name('enroll.store.template')
		->middleware('role:developer|administrator|internal');
	//materi
	Route::get('/mata/{id}/materi/template/{templateId}/create', 'Course\TemplatingController@createMateri')
		->name('materi.create.template')
		->middleware('role:developer|administrator|internal');
	Route::post('/mata/{id}/materi/template/{templateId}', 'Course\TemplatingController@storeMateri')
		->name('materi.store.template')
		->middleware('role:developer|administrator|internal');


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

	//--sertifikasi

	//internal
	Route::get('/mata/{id}/sertifikat/peserta', 'Sertifikasi\SertifikatInternalController@peserta')
		->name('sertifikat.internal.peserta')
		->middleware('role:administrator|internal|instruktur_internal');
	Route::get('/mata/{id}/sertifikat/internal/form', 'Sertifikasi\SertifikatInternalController@form')
		->name('sertifikat.internal.form')
		->middleware('role:administrator|internal|mitra');
	Route::post('/mata/{id}/sertifikat/internal', 'Sertifikasi\SertifikatInternalController@store')
		->name('sertifikat.internal.store')
		->middleware('role:administrator|internal|mitra');
	Route::put('/mata/{id}/sertifikat/internal/{sertifikatId}', 'Sertifikasi\SertifikatInternalController@update')
		->name('sertifikat.internal.update')
		->middleware('role:administrator|internal|mitra');
	Route::post('/mata/{id}/sertifikat/internal/{sertifikatId}/cetak', 'Sertifikasi\SertifikatInternalController@cetak')
		->name('sertifikat.internal.cetak')
		->middleware('role:peserta_internal|peserta_mitra');
	Route::get('/mata/{id}/sertifikat/internal/{sertifikatId}/download', 'Sertifikasi\SertifikatInternalController@download')
		->name('sertifikat.internal.download')
		->middleware('role:administrator|internal|mitra|peserta_internal|peserta_mitra');
   
	//external
	Route::get('/mata/{id}/sertifikat/external/peserta', 'Sertifikasi\SertifikatExternalController@peserta')
		->name('sertifikat.external.peserta')
		->middleware('role:administrator|internal|instruktur_internal');
	Route::post('/mata/{id}/sertifikat/external', 'Sertifikasi\SertifikatExternalController@upload')
		->name('sertifikat.external.upload')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::get('/mata/{id}/sertifikat/external/peserta/{pesertaId}/detail', 'Sertifikasi\SertifikatExternalController@detail')
		->name('sertifikat.external.peserta.detail')
		->middleware('role:administrator|internal|mitra|instruktur_internal');
	Route::delete('/mata/{id}/sertifikat/external/peserta/{pesertaId}/detail/{sertifikatId}', 'Sertifikasi\SertifikatExternalController@destroy')
		->name('sertifikat.external.peserta.destroy')
		->middleware('role:administrator|internal|mitra|instruktur_internal');


	/**Website module */
	//page
	Route::get('/page', 'PageController@index')
		->name('page.index')
		->middleware('role:developer|administrator');
	Route::get('/pages/create', 'PageController@create')
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
	Route::get('/konfigurasi/sertifikat', 'KonfigurasiController@sertifikat')
		->name('config.sertifikat')
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
	 Route::get('/announcement','Component\AnnouncementController@index')->name('announcement.index')->middleware('auth');
	 Route::get('/announcement/create','Component\AnnouncementController@create')->name('announcement.create')->middleware('role:developer|administrator|internal');
	 Route::get('/announcement/{announcement}','Component\AnnouncementController@edit')->name('announcement.edit')->middleware('role:developer|administrator|internal');
	 Route::get('/announcement/{announcement}/show','Component\AnnouncementController@show')->name('announcement.show')->middleware('auth');
	 Route::post('/announcement','Component\AnnouncementController@store')->name('announcement.store')->middleware('role:developer|administrator|internal');
	 Route::put('/announcement','Component\AnnouncementController@update')->name('announcement.update')->middleware('role:developer|administrator|internal');
	 Route::put('/announcement/{id}','Component\AnnouncementController@publish')->name('announcement.publish')->middleware('role:developer|administrator|internal');
	 Route::delete('/announcement/delete/{id}','Component\AnnouncementController@destroy')->name('announcement.destroy')->middleware('role:developer|administrator|internal');

	 //Logs
	 Route::get('/log','LogController@index')->name('log.index')->middleware('role:developer|administrator|internal');
	 Route::get('/log/backup','LogController@backup')->name('log.backup')->middleware('role:developer|administrator|internal');

	//Kompetensi
	Route::get('/kompetensi','KompetensiController@index')->name('kompetensi.index')->middleware('role:developer|administrator|internal');
	Route::get('/kompetensi/create','KompetensiController@create')->name('kompetensi.create')->middleware('role:developer|administrator|internal');
	Route::get('/kompetensi/edit/{kompetensi}','KompetensiController@edit')->name('kompetensi.edit')->middleware('role:developer|administrator|internal');
	Route::post('/kompetensi/store','KompetensiController@store')->name('kompetensi.store')->middleware('role:developer|administrator|internal');
	Route::PUT('/kompetensi/{id}/update','KompetensiController@update')->name('kompetensi.update')->middleware('role:developer|administrator|internal');
	Route::delete('/kompetensi/{id}/delete','KompetensiController@destroy')->name('kompetensi.delete')->middleware('role:developer|administrator|internal');

	// Journey
	Route::get('/journey','JourneyController@index')->name('journey.index')->middleware('role:peserta_mitra|peserta_internal');
	Route::post('/journey/{pesertaId}/assign','JourneyController@assign')->name('journey.assign')->middleware('auth');
	Route::get('/journey/{id}/peserta','JourneyController@peserta')->name('journey.peserta')->middleware('role:developer|administrator|internal');
	Route::get('/journey/create','JourneyController@create')->name('journey.create')->middleware('role:developer|administrator|internal');
	Route::get('/journey/edit/{journey}','JourneyController@edit')->name('journey.edit')->middleware('role:developer|administrator|internal');
	Route::post('/journey/store','JourneyController@store')->name('journey.store')->middleware('role:developer|administrator|internal');
	Route::PUT('/journey/{id}/update','JourneyController@update')->middleware('role:developer|administrator|internal');
	Route::delete('/journey/{id}/delete','JourneyController@destroy')->name('journey.delete')->middleware('role:developer|administrator|internal');

	 //Journey Kompetensi
	Route::get('/journey/kompetensi/{journey}/create','JourneyKompetensiController@create')->name('journeyKompetensi.create')->middleware('role:developer|administrator|internal');
	Route::get('/journey/kompetensi/{id}/edit','JourneyKompetensiController@edit')->name('journeyKompetensi.edit')->middleware('role:developer|administrator|internal');
	Route::post('/journey/kompetensi/store','JourneyKompetensiController@store')->name('journeyKompetensi.store')->middleware('role:developer|administrator|internal');
	Route::PUT('/journey/kompetensi/{id}/update','JourneyKompetensiController@update')->name('journeyKompetensi.update')->middleware('role:developer|administrator|internal');
	Route::delete('/journey/kompetensi/{id}/delete','JourneyKompetensiController@destroy')->name('journeyKompetensi.delete')->middleware('role:developer|administrator|internal');

	 //Learning Journey


	  // Statistic
	Route::get('/statistic','Component\StatisticController@index')->name('statistic.index')->middleware('role:developer|administrator|internal');

	/** Frontend Component */
	// Inquiry
	// Route::get('/inquiry','InquiryController@index')->name('inquiry.index');
	// Route::get('/inquiry/create','InquiryController@create')->name('inquiry.create');
	// Route::get('/inquiry/{id}','InquiryController@detail')->name('inquiry.detail');
	// Route::post('/inquiry','InquiryController@store')->name('inquiry.store');
	// Route::delete('/inquiry/{id}','InquiryController@destroy')->name('inquiry.destroy');

	//fullcalender
	Route::get('kalender','EventController@index')->name('kalender.index')->middleware('auth');
	Route::get('event/list','EventController@list')->name('event.list')->middleware('auth');
	Route::get('event/export/{media}','EventController@generateLink')->name('event.generate')->middleware('role:developer|administrator|internal');
	Route::post('event/store','EventController@store')->name('event.store')->middleware('role:developer|administrator|internal');
	Route::post('event/update','EventController@update')->name('event.update')->middleware('role:developer|administrator|internal');
	Route::post('event/delete','EventController@destroy')->name('event.delete')->middleware('role:developer|administrator|internal');

	// report
	Route::get('report/activity/{materiId}','Course\Log\ActivityTrackController@index')->name('report.activity')->middleware('role:developer|administrator|internal');
	Route::post('report/activity/publish/{id}','Course\Log\ActivityTrackController@publish')->name('report.activity.publish')->middleware('role:developer|administrator|internal');
	Route::post('report/activity/submit/{userId}/{bahanId}','Course\Log\ActivityTrackController@submit')->name('report.activity.submit')->middleware('role:developer|administrator|internal');
	Route::get('report/compare/{materiId}','ReportController@compare')->name('report.compare')->middleware('role:developer|administrator|internal');

	// badge
	Route::get('badges/{mataID}/list','BadgeController@list')->name('badge.list')->middleware('role:developer|administrator|internal');
	Route::get('badges/myList','BadgeController@myBadge')->name('badge.my.index')->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
	Route::get('badges/{mataID}/create','BadgeController@create')->name('badge.create')->middleware('role:developer|administrator|internal');
	Route::get('badges/{badge}/edit','BadgeController@edit')->name('badge.edit')->middleware('role:developer|administrator|internal');
	Route::post('badges/store','BadgeController@store')->name('badge.store')->middleware('role:developer|administrator|internal');
	Route::put('badges/update/{id}','BadgeController@update')->name('badge.update')->middleware('role:developer|administrator|internal');
	Route::delete('badges/delete/{id}','BadgeController@destroy')->name('badge.delete')->middleware('role:developer|administrator|internal');

	//notifikasi
	Route::get('notifikasi/{id}', [NotificationController::class, 'index'])
		->name('notification.show')
		->middleware('auth');

	//logout
	Route::post('/logout', [LoginController::class, 'logout'])
		->name('logout');

	// user 
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
        Route::get('/akses/{id}/pelatihan', [PesertaController::class, 'detailAKses'])
            ->name('detailAkses');
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
            Route::put('/peserta/{id}/khusus', [PesertaController::class, 'updatePesertaKhusus'])
			->name('editPelatiahanKhusus');
            

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

	Route::get('/pelatihan','Pelatihan\PelatihanController@index')->name('platihan.index');
	Route::get('/detail/{id}/pelatihan','Pelatihan\PelatihanController@show')->name('pelatihan.detail');
	Route::get('/pelatihan/{id}/detail', 'Pelatihan\PelatihanController@courseDetail')
	->name('pelatihan.mata')
	->middleware('auth');
	Route::get('/pelatihan/{orderBy}','Pelatihan\PelatihanController@filterBy')
	->name('platihan.filter');

    Route::get('/minta/{mataId}/{id}/akses', [PesertaController::class, 'mintaAkses_pelatihan'])
            ->name('peserta.MintaAkses');

   

