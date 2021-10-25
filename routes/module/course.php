<?php

use App\Http\Controllers\Course\Template\TemplateBahanController;
use App\Http\Controllers\Course\Template\TemplateBahanQuizItemController;
use App\Http\Controllers\Course\Template\TemplateMataController;
use App\Http\Controllers\Course\Template\TemplateMateriController;
use App\Http\Controllers\Course\Template\TemplateSoalController;
use App\Http\Controllers\Course\Template\TemplateSoalKategoriController;
use Illuminate\Support\Facades\Route;

//coursez
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
	->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
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
Route::put('/conference/{id}/{trackId}/penilaian', 'Course\Bahan\BahanConferenceController@penilaian')
	->name('conference.penilaian')
	->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);

//quiz
Route::get('/quiz/{id}/test', 'Course\Bahan\BahanQuizItemController@room')
	->name('quiz.room')
	->middleware(['auth', 'role:peserta_internal|peserta_mitra']);

Route::post('/quiz/{id}/track/jawaban', 'Course\Bahan\BahanQuizItemController@trackJawaban')
	->name('quiz.track.jawaban')
	->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::delete('/quiz/{id}/user/{userId}', 'Course\Bahan\BahanQuizItemController@ulangi')
	->name('quiz.ulangi')
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
Route::put('{quizId}/{userId}/peserta/{id}/cek', 'Course\Bahan\BahanQuizItemController@checkPeserta')
	->name('quiz.peserta.cek')
	->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::get('/quiz/{id}/export', 'Course\Bahan\BahanQuizItemController@exportJawaban')
	->name('quiz.export.jawaban')
	->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
//tugas
Route::post('/tugas/{id}/kirim', 'Course\Bahan\BahanTugasController@sendTugas')
	->name('tugas.send')
	->middleware(['auth', 'role:peserta_internal|peserta_mitra']);
Route::put('/tugas/{id}/respon/{responId}/{status}', 'Course\Bahan\BahanTugasController@approval')
	->name('tugas.approval')
	->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::get('/tugas/{id}/peserta', 'Course\Bahan\BahanTugasController@peserta')
	->name('tugas.peserta')
	->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
Route::put('/tugas/{id}/penilaian/{responId}', 'Course\Bahan\BahanTugasController@penilaian')
	->name('tugas.penilaian')
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
Route::get('/course/{id}/evaluasi/penyelenggara/export', 'Course\EvaluasiController@exportPenyelenggara')
	->name('evaluasi.penyelenggara.export')
	->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
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
Route::get('/course/{id}/bahan/{bahanId}/evaluasi/pengajar/export', 'Course\EvaluasiController@exportPengajar')
	->name('evaluasi.pengajar.export')
	->middleware(['auth', 'role:administrator|internal|mitra|instruktur_internal|instruktur_mitra']);
	
//template
Route::prefix('template')->name('template.')->middleware('role:developer|administrator|internal')
	->group(function () {

	//mata
	Route::prefix('mata')->name('mata.')->group(function () {
		
		Route::get('/', [TemplateMataController::class, 'index'])
			->name('index');
		Route::get('/create', [TemplateMataController::class, 'create'])
			->name('create');
		Route::post('/', [TemplateMataController::class, 'store'])
			->name('store');
		Route::get('/{id}/edit', [TemplateMataController::class, 'edit'])
			->name('edit');
		Route::put('/{id}', [TemplateMataController::class, 'update'])
			->name('update');
		Route::put('/{id}/position/{position}', [TemplateMataController::class, 'position'])
			->name('position');
		Route::put('/{id}/publish', [TemplateMataController::class, 'publish'])
			->name('publish');
		Route::post('/sort', [TemplateMataController::class, 'sort'])
			->name('sort');
		Route::delete('/{id}', [TemplateMataController::class, 'destroy'])
			->name('destroy');

	});

	/**bank soal */
	Route::prefix('mata/{id}/soal/kategori')->name('soal.')->group(function () {

		//kategori
		Route::get('/', [TemplateSoalKategoriController::class, 'index'])
			->name('kategori');
		Route::get('/create', [TemplateSoalKategoriController::class, 'create'])
			->name('kategori.create');
		Route::post('/', [TemplateSoalKategoriController::class, 'store'])
			->name('kategori.store');
		Route::get('/{kategoriId}/edit', [TemplateSoalKategoriController::class, 'edit'])
			->name('kategori.edit');
		Route::put('/{kategoriId}', [TemplateSoalKategoriController::class, 'update'])
			->name('kategori.update');
		Route::delete('/{kategoriId}', [TemplateSoalKategoriController::class, 'destroy'])
			->name('kategori.destroy');
		
		//soal
		Route::get('/{kategoriId}', [TemplateSoalController::class, 'index'])
			->name('index');
		Route::get('/json/{quizId}', [TemplateSoalController::class, 'soalByKategori'])
			->name('json');
		Route::get('/{kategoriId}/create', [TemplateSoalController::class, 'create'])
			->name('create');
		Route::post('/{kategoriId}', [TemplateSoalController::class, 'store'])
			->name('store');
		Route::get('/{kategoriId}/edit/{soalId}', [TemplateSoalController::class, 'edit'])
			->name('edit');
		Route::put('/{kategoriId}/{soalId}', [TemplateSoalController::class, 'update'])
			->name('update');
		Route::delete('/{kategoriId}/{soalId}', [TemplateSoalController::class, 'destroy'])
			->name('destroy');
		
	});

	//materi
	Route::prefix('mata/{id}/materi')->name('materi.')->group(function () {

		Route::get('/', [TemplateMateriController::class, 'index'])
			->name('index');
		Route::get('/create', [TemplateMateriController::class, 'create'])
			->name('create');
		Route::post('/', [TemplateMateriController::class, 'store'])
			->name('store');
		Route::get('/{materiId}/edit', [TemplateMateriController::class, 'edit'])
			->name('edit');
		Route::put('/{materiId}', [TemplateMateriController::class, 'update'])
			->name('update');
		Route::put('/{materiId}/position/{position}', [TemplateMateriController::class, 'position'])
			->name('position');
		Route::post('/sort', [TemplateMateriController::class, 'sort'])
			->name('sort');
		Route::delete('/{materiId}', [TemplateMateriController::class, 'destroy'])
			->name('destroy');
		
	});

	//bahan
	Route::prefix('materi/{id}/bahan')->name('bahan.')->group(function () {

		Route::get('/', [TemplateBahanController::class, 'index'])
			->name('index');
		Route::get('/create', [TemplateBahanController::class, 'create'])
			->name('create');
		Route::post('/', [TemplateBahanController::class, 'store'])
			->name('store');
		Route::get('/{bahanId}/edit', [TemplateBahanController::class, 'edit'])
			->name('edit');
		Route::put('/{bahanId}', [TemplateBahanController::class, 'update'])
			->name('update');
		Route::delete('/{bahanId}', [TemplateBahanController::class, 'destroy'])
			->name('destroy');

	});

	//quiz
	Route::prefix('quiz/{id}/item')->name('quiz.')->group(function () {
		
		Route::get('/', [TemplateBahanQuizItemController::class, 'index'])
			->name('item');
		Route::get('/create', [TemplateBahanQuizItemController::class, 'create'])
			->name('item.create');
		Route::post('/store', [TemplateBahanQuizItemController::class, 'store'])
			->name('item.store');
		Route::post('/input', [TemplateBahanQuizItemController::class, 'storeFromBank'])
			->name('item.input');
		Route::get('/{itemId}/edit', [TemplateBahanQuizItemController::class, 'edit'])
			->name('item.edit');
		Route::put('/{itemId}', [TemplateBahanQuizItemController::class, 'update'])
			->name('item.update');
		Route::delete('/{itemId}', [TemplateBahanQuizItemController::class, 'destroy'])
			->name('item.destroy');

	});

});

