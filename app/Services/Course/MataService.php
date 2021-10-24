<?php

namespace App\Services\Course;

use App\Http\Controllers\Course\MataController;
use App\Models\Course\ApiEvaluasi;
use App\Models\Course\Bahan\ActivityCompletion;
use App\Models\Course\Bahan\BahanConferencePeserta   ;
use App\Models\Course\Bahan\BahanEvaluasiPengajar;
use App\Models\Course\Bahan\BahanForumTopik;
use App\Models\Course\Bahan\BahanForumTopikDiskusi;
use App\Models\Course\Bahan\BahanQuizUserTracker;
use App\Models\Course\Bahan\BahanTugasRespon;
use App\Models\Course\MataBobotNilai;
use App\Models\Course\MataInstruktur;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MataPeserta;
use App\Models\Course\MataRating;
use App\Models\Course\MateriPelatihan;
use App\Services\Component\KomentarService;
use App\Services\Course\Bahan\BahanEvaluasiPengajarService;
use App\Services\Users\PesertaService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Services\Component\NotificationService;
use App\Services\KalenderService;
use App\Services\Users\InstrukturService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MataService
{
	private $model, $modelBobot, $modelInstruktur, $modelPeserta, $modelMateri, $komentar,
		$peserta, $bahanEvaluasi;

	public function __construct(
		MataPelatihan $model,
		MataBobotNilai $modelBobot,
		MataInstruktur $modelInstruktur,
		MataPeserta $modelPeserta,
		MateriPelatihan $modelMateri,
		KomentarService $komentar,
		PesertaService $peserta,
		BahanEvaluasiPengajarService $bahanEvaluasi,
		NotificationService $notifikasi,
		InstrukturService $instruktur,
		KalenderService $event
	)
	{
		$this->model = $model;
		$this->modelBobot = $modelBobot;
		$this->modelInstruktur = $modelInstruktur;
		$this->modelPeserta = $modelPeserta;
		$this->modelMateri = $modelMateri;
		$this->komentar = $komentar;
		$this->peserta = $peserta;
		$this->bahanEvaluasi = $bahanEvaluasi;
		$this->notifikasi = $notifikasi;
		$this->instruktur = $instruktur;
		$this->event =$event;

	}

	public function getAllMata()
	{
		$query = $this->model->query();

		$query->whereHas('program', function ($query) {
			$query->publish();
		});
		$query->publish();

		if (auth()->user()->hasRole('internal')) {
			$query->whereHas('program', function ($queryC) {
				$queryC->where('tipe', 0);
			});
		}
		if (auth()->user()->hasRole('mitra')) {
			$query->whereHas('program', function ($queryC) {
				$queryC->where('mitra_id', auth()->user()->id)
					->where('tipe', 1);
			});
		}

		$result = $query->get();

		return $result;
	}

	public function getMataList($request, int $programId)
	{
		$query = $this->model->query();

		$query->where('program_id', $programId);
		// $query->where('publish_end', '>=', now());
		$query->when($request->q, function ($query, $q) {
			$query->where(function ($query) use ($q) {
				$query->where('judul', 'ilike', '%'.$q.'%');
			});
		});
		if (isset($request->p)) {
			$query->where('publish', $request->p);
		}

		if (isset($request->f) && isset($request->t)) {
			$query->whereBetween('publish_start', [$request->f, $request->t]);
		}

		if (auth()->user()->hasRole('internal')) {
			$query->whereHas('program', function ($query) {
				$query->where('tipe', 0);
			});
		}

		if (auth()->user()->hasRole('mitra')) {
			$query->whereHas('program', function ($query) {
				$query->where('mitra_id', auth()->user()->id)
				->where('tipe', 1);
			});
		}

		$result = $query->orderBy('urutan', 'ASC')->paginate(10);

		return $result;
	}

	public function getMata($order, $by, int $limitz)
	{
		$query = $this->model->query();

		$query->publish();
		if (auth()->guard()->check() == true) {

			$query->where('publish_start', '<=', now())
				->where('publish_end', '>=', now());

			if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
				$query->whereHas('instruktur', function ($query) {
					$query->whereIn('instruktur_id', [auth()->user()->instruktur->id]);
				});
			}

			if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {

				$query->whereHas('program', function ($query) {
					$query->publish();
					if (auth()->user()->hasRole('peserta_mitra')) {
						$query->where('tipe', 1)->where('mitra_id', auth()->user()->peserta->mitra_id);
					} else {
						$query->where('tipe', 0);
					}
				});
				$query->whereHas('peserta', function ($query) {
					$query->where('peserta_id', auth()->user()->peserta->id);
				});
			}

		} else {

			$query->whereHas('program', function ($query) {
				$query->publish();
			});
			$query->where('publish_start', '<=', now())
			->where('publish_end', '>=', now());
		}

		$result = $query->orderBy($order, $by)->paginate(20);

		return $result;
	}

	public function getMataFree($order, $by, int $limitz,$request)
	{
		$query = $this->model->query();
        if($request->f == 2)
        {

           $result = $query->join('mata_peserta', 'mata_pelatihan.id', '=', 'mata_peserta.mata_id')
                ->select('mata_pelatihan.id','judul','cover','price','mata_pelatihan.created_at', DB::raw('count(*) as mataPeserta_Count','mata_peserta.mata_id'))
                ->groupBy('mata_peserta.mata_id')
                ->orderBy('mataPeserta_Count', 'DESC')
                ->paginate(12);

            $query->when($request->q, function ($query, $q) {
				$query->where('judul','like', '%'.$q.'%');
			}); 

            
            $result = $query->orderBy($order, $by)->paginate($limitz);
            return $result;
        }else{
            if (auth()->guard()->check() == true) {
			
			// if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
			// 	$query->whereHas('instruktur', function ($query) {
			// 		$query->whereIn('instruktur_id', [auth()->user()->instruktur->id]);
			// 	});
			// }

		} else {

			$query->whereHas('program', function ($query) {
				$query->publish();
			});
			// $query->where('publish_start', '<=', now())
			// ->where('publish_end', '>=', now());
		}
            $query->when($request->q, function ($query, $q) {
				$query->where('judul','like', '%'.$q.'%');
			}); 

            $query->when($request->f == 0, function($query){
                $query->orderBy('id', 'DESC')->paginate(12);
            });
            
            $query->when($request->f == 1, function($query){
                $query->orderBy('judul', 'ASC')->paginate(12);
            });
             $query->when($request->k, function($query, $q){
                $query->where('program_id', $q);    
            });
        
            $result = $query->orderBy($order, $by)->paginate($limitz);
            return $result;

        }
		
	}

	public function getLatestMata()
	{
		$query = $this->model->query();
		$query->where('publish_start', '<=', now())
				->where('publish_end', '>=', now());
		// dd(auth()->user());
		// if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
		// 	$query->whereHas('instruktur', function ($query) {
		// 		$query->whereIn('instruktur_id', [auth()->user()->instruktur->id]);
		// 	});
		// }

		if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {

			$query->whereHas('program', function ($query) {
				$query->publish();
				if (auth()->user()->hasRole('peserta_mitra')) {
					$query->where('tipe', 1)->where('mitra_id', auth()->user()->peserta->mitra_id);
				} else {
					$query->where('tipe', 0);
				}
			});
			$query->whereHas('peserta', function ($query) {
				$query->where('peserta_id', auth()->user()->peserta->id);
			});
		}
		$query->publish();

		$result = $query->where('creator_id', auth()->user()->id)->get();
		return $result;
	}

	public function getOtherMata($id)
	{
		$query = $this->model->query();

		$query->publish();
		$query->where('publish_start', '<=', now())
			->where('publish_end', '>=', now());
	  
		if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
			$query->whereHas('instruktur', function ($query) {
				$query->whereIn('instruktur_id', [auth()->user()->instruktur->id]);
			});
		}

		if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {

			$query->whereHas('program', function ($query) {
				$query->publish();
				if (auth()->user()->hasRole('peserta_mitra')) {
					$query->where('tipe', 1)->where('mitra_id', auth()->user()->peserta->mitra_id);
				} else {
					$query->where('tipe', 0);
				}
			});
			$query->whereHas('peserta', function ($query) {
				$query->where('peserta_id', auth()->user()->peserta->id);
			});
		}

		$query->whereNotIn('id', [$id]);

		$result = $query->get();

		return $result;
	}

	public function getOtherMataNoId($id)
	{
		return $query=$this->model->query();
		$query->whereHas('instruktur', function ($query) {
			$query->whereIn('instruktur_id', [auth()->user()->instruktur->id]);
		});
	}

	public function getMataHistory($request, $limit = 9)
	{
		$query = $this->model->query();
		$query->when($request->q, function ($query, $q) {
			$query->where(function ($query) use ($q) {
				$query->where('judul', 'like', '%'.$q.'%');
			});
		});

        $is_graduade = $request->p;
		if (isset($is_graduade)) {
            $query->when($is_graduade == 1 || $is_graduade == 0, function ($query) use ($is_graduade) {
                $query->whereHas('quiz.trackUser', function($query) use ($is_graduade){
                    $query->where('is_graduaded', $is_graduade);      
                });
            });

            $query->when($is_graduade == 2, function ($query) use ($is_graduade) {
               $query->whereHas('NotComplite', function($query){
                    $query->where('user_id', auth()->user()->id)->where('persentase','<', 100);
                });
            });

            // $query->where('publish', $request->p);
		}

		$query->where('publish_end', '<', now());

		if (isset($request->f) && isset($request->t)) {
			$query->whereBetween('publish_end', [$request->f, $request->t]);
		}

		$query->publish();

		if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
			$query->whereHas('instruktur', function ($query) {
				$query->whereIn('instruktur_id', [auth()->user()->instruktur->id]);
			});
		}

		if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
			$query->whereHas('program', function ($query) {
				$query->publish();
				if (auth()->user()->hasRole('peserta_mitra')) {
					$query->where('tipe', 1)->where('mitra_id', auth()->user()->peserta->mitra_id);
				} else {
					$query->where('tipe', 0);
				}
			});
			$query->whereHas('peserta', function ($query) {
				$query->where('peserta_id', auth()->user()->peserta->id);
			});
		}
		
		$result = $query->with('quiz.trackUser')->paginate($limit);
        // dd($result);
		return $result;
	}

	public function getInstrukturEnroll(int $mataId)
	{
		$instruktur = $this->bahanEvaluasi->getEvaluasiByMata($mataId);
		$collectInstruktur = collect($instruktur);
		$mataInstrukturId = $collectInstruktur->map(function($item, $key) {
			return $item->mata_instruktur_id;
		})->all();

		$query = $this->modelInstruktur->query();

		$query->whereNotNull('kode_evaluasi');
		$query->whereNotIn('id', $mataInstrukturId);

		$result = $query->get();
		return $result;
	}

	public function getInstrukturList($request, int $mataId)
	{
		$query = $this->modelInstruktur->query();

		$query->where('mata_id', $mataId);
		$query->whereHas('instruktur', function ($query) use ($request) {
			$query->when($request->q, function ($query, $q) {
				$query->where(function ($query) use ($q) {
					$query->where('nip', 'like', '%'.$q.'%')
						->orWhere('kedeputian', 'like', '%'.$q.'%');
				});
			});
		});

		$result = $query->paginate(20);

		return $result;
	}

	public function getPesertaList($request, int $mataId , $paginate = true)
	{
		$query = $this->modelPeserta->query();

		$query->where('mata_id', $mataId);
		if(isset($request)){
		$query->whereHas('peserta', function ($query) use ($request) {
			$query->when($request->q, function ($query, $q) {
				$query->where(function ($query) use ($q) {
					$query->where('nip', 'like', '%'.$q.'%')
						->orWhere('kedeputian', 'like', '%'.$q.'%');
				});
			});
		});
		}
		$result = $query->paginate(20);
		if($paginate == false){
		$result = $query->get();
		}
		return $result;
	}

	public function countMata()
	{
		$query = $this->model->query();

		if (auth()->user()->hasRole('internal')) {
			$query->whereHas('program', function ($query) {
				$query->where('tipe', 0);
			});
		}

		if (auth()->user()->hasRole('mitra')) {
			$query->whereHas('program', function ($query) {
				$query->where('mitra_id', auth()->user()->id)
				->where('tipe', 1);
			});
		}

		$result = $query->count();

		return $result;
	}

	public function countMataPeserta($pesertaID){
		$query = $this->model->query();
		if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {

			$query->where('publish_start', '<=', now())
				->where('publish_end', '>=', now());

			$query->whereHas('program', function ($query) {
				$query->publish();
				if (auth()->user()->hasRole('peserta_mitra')) {
					$query->where('tipe', 1)->where('mitra_id', auth()->user()->peserta->mitra_id);
				} else {
					$query->where('tipe', 0);
				}
			});
			$query->publish();
			$query->whereHas('peserta', function ($query) {
				$query->where('peserta_id', auth()->user()->peserta->id);
			});
		}
		$result = $query->count();
		return $result;
	}

	public function getMataPeserta($pesertaID){

		$query = $this->modelPeserta->query();
		$query->where('peserta_id',$pesertaID);
		$result = $query->get();
		return $result;
	}

	public function findMata($id)
	{
		return $this->model->with('creator')->findOrFail($id);
	}


    public function getMataByInstruktur($request, $programId)
    {
        $query = $this->model->query();

		$query->where('program_id', $programId);
		// $query->where('publish_end', '>=', now());
		$query->when($request->q, function ($query, $q) {
			$query->where(function ($query) use ($q) {
				$query->where('judul', 'ilike', '%'.$q.'%');
			});
		});
		if (isset($request->p)) {
			$query->where('publish', $request->p);
		}

		if (isset($request->f) && isset($request->t)) {
			$query->whereBetween('publish_start', [$request->f, $request->t]);
		}

		$result = $query->where('creator_id', Auth()->user()->id)->orderBy('urutan', 'ASC')->paginate(10);

		return $result;
    }

	public function storeMata($request, int $programId, $templateId = null)
	{
		if ($request->hasFile('cover_file')) {
			$fileName = str_replace(' ', '-', $request->file('cover_file')
				->getClientOriginalName());
			$request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
		}

		$mata = new MataPelatihan($request->only(['judul']));
		if ($templateId != null) {
			$mata->template_id = $templateId;
		}
		$mata->program_id = $programId;
		$mata->creator_id = auth()->user()->id;
		$mata->kode_evaluasi = $request->kode_evaluasi ?? null;
		$mata->intro = $request->intro ?? null;
		$mata->content = $request->content ?? null;
		$mata->cover = [
			'filename' => $fileName ?? null,
			'title' => $request->cover_title ?? null,
			'alt' => $request->cover_alt ?? null,
		];
		$mata->pola_penyelenggaraan = $request->pola_penyelenggaraan ?? null;
		$mata->sumber_anggaran = $request->sumber_anggaran ?? null;
		$mata->publish = (bool)$request->publish;
		$mata->publish_start = $request->publish_start ?? null;
		$mata->publish_end = ($request->enable == 1 ? $request->publish_end : null);
		$mata->jam_pelatihan = $request->jam_pelatihan ?? null;
		$mata->urutan = ($this->model->where('program_id', $programId)->max('urutan') + 1);
		$mata->show_feedback = (bool)$request->show_feedback;
		$mata->show_comment = (bool)$request->show_comment;
		$mata->price = $request->price;
		$mata->is_sertifikat = $request->is_sertifikat;
		$mata->is_penilaian = $request->is_penilaian;
        $mata->type_pelatihan = $request->type_pelatihan;
		$mata->save();

		$bobot = new MataBobotNilai;
		$bobot->mata_id = $mata->id;
		$bobot->join_vidconf = $request->join_vidconf;
		$bobot->activity_completion = $request->activity_completion;
		$bobot->forum_diskusi = $request->forum_diskusi;
		$bobot->webinar = $request->webinar;
		$bobot->progress_test = (bool)$request->enable_progress == 1 ? $request->progress_test : null;
		$bobot->quiz = $request->quiz;
		$bobot->tugas_mandiri = (bool)$request->enable_tugas == 1 ? $request->tugas_mandiri : null;
		$bobot->post_test = $request->post_test;
		$bobot->save();


		return $mata;
	}

	public function storeInstruktur($request, int $mataId)
	{
        // dd($request->instruktur_id);
		$collectUser = [];
		$collectInstruktur = collect($request->instruktur_id);
		$mata = $this->findMata($mataId);
		$url = action([MataController::class, 'courseDetail'], ['id' => $mataId]);
		foreach ($collectInstruktur->all() as $key => $value) {
			$instruktur = new MataInstruktur;
			$instruktur->mata_id = $mataId;
			$instruktur->instruktur_id = $value;
			$instruktur->save();
			$userId = $this->instruktur->findInstruktur($value)->user->id;
			array_push($collectUser,$userId);
		}
		$this->notifikasi->make(
			$model = $mata,
			$title = 'Menjadi Instruktur Dalam Program '.$mata->judul,
			$description = 'Selamat! Anda DItunjuk Menjadi Instruktur Dalam Program '.$mata->judul,
			$to = $collectUser,
			$url);
	}

	public function kodeEvaluasiInstruktur($request, int $mataId, int $id)
	{
		$instruktur = $this->modelInstruktur->findOrFail($id);
		$instruktur->kode_evaluasi = $request->kode_evaluasi ?? null;
		$instruktur->save();
		return $instruktur;
	}

	public function storePeserta($request, int $mataId)
	{
		$collectPeserta = collect($request->peserta_id);
		$collectUser = [];
		$mata = $this->findMata($mataId);
		$url = action([MataController::class, 'courseDetail'], ['id' => $mataId]);
		foreach ($collectPeserta->all() as $key => $value) {
			$peserta = new MataPeserta;
			$peserta->mata_id = $mataId;
			$peserta->peserta_id = $value;
			$peserta->save();
			$userId = $this->peserta->findPeserta($value)->user->id;
			array_push($collectUser,$userId);
		}
		$this->notifikasi->make(
			$model = $mata,
			$title = 'Terdaftar Dalam Program '.$mata->judul,
			$description = 'Selamat! Anda Terdaftar Dalam Program '.$mata->judul,
			$to = $collectUser,
			$url);
	}

	public function updateMata($request, int $id)
	{
		if ($request->hasFile('cover_file')) {
			$fileName = str_replace(' ', '-', $request->file('cover_file')
				->getClientOriginalName());
			$this->deleteCoverFromPath($request->old_cover_file);
			$request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
		}

		$mata = $this->findMata($id);
		$mata->fill($request->only(['judul']));
		$mata->kode_evaluasi = $request->kode_evaluasi ?? null;
		$mata->intro = $request->intro ?? null;
		$mata->content = $request->content ?? null;
		$mata->cover = [
			'filename' => $fileName ?? $mata->cover['filename'],
			'title' => $request->cover_title ?? null,
			'alt' => $request->cover_alt ?? null,
		];
		// $mata->publish = (bool)$request->publish;
		$mata->pola_penyelenggaraan = $request->pola_penyelenggaraan ?? null;
		$mata->sumber_anggaran = $request->sumber_anggaran ?? null;
		$mata->publish_start = $request->publish_start ?? null;
		$mata->publish_end = $request->publish_end ?? null;
		$mata->jam_pelatihan = $request->jam_pelatihan ?? null;
		$mata->show_feedback = (bool)$request->show_feedback;
		$mata->show_comment = (bool)$request->show_comment;
		$mata->price = $request->price;
		$mata->is_sertifikat = $request->is_sertifikat;
		$mata->is_penilaian = $request->is_penilaian;
        $mata->type_pelatihan = $request->type_pelatihan;
		$mata->save();

		$bobot = $mata->bobot;
		$bobot->join_vidconf = $request->join_vidconf;
		$bobot->activity_completion = $request->activity_completion;
		$bobot->forum_diskusi = $request->forum_diskusi;
		$bobot->webinar = $request->webinar;
		$bobot->progress_test = (bool)$request->enable_progress == 1 ? $request->progress_test : null;
		$bobot->quiz = $request->quiz;
		$bobot->tugas_mandiri = (bool)$request->enable_tugas == 1 ? $request->tugas_mandiri : null;
		$bobot->post_test = $request->post_test;
		$bobot->save();




		return $mata;
	}

	public function positionMata(int $id, $urutan)
	{
		if ($urutan >= 1) {
			$mata = $this->findMata($id);
			$this->model->where('urutan', $urutan)->update([
				'urutan' => $mata->urutan,
			]);
			$mata->urutan = $urutan;
			$mata->save();
			return $mata;
		} else {
			return false;
		}
	}

	public function sortMata(int $id, $urutan)
	{
		$find = $this->findMata($id);

		$mata = $this->model->where('id', $id)
				->where('program_id', $find->program_id)->update([
			'urutan' => $urutan
		]);

		return $mata;
	}

	public function publishMata(int $id)
	{
		$mata = $this->findMata($id);
		$mata->publish = !$mata->publish;
		$mata->save();

		$start = Carbon::parse($mata->publish_start)->format('Y-m-d');
		$end = Carbon::parse($mata->publish_end)->format('Y-m-d');
		$start_time = Carbon::parse($mata->publish_start)->format('H:i');
		$end_time = Carbon::parse($mata->publish_end)->format('H:i');

		if($mata['publish'] == 1){
			$this->event->makeEvent(
				$title = $mata->judul,
				$description = strip_tags($mata->content),
				$start,
				$end,
				$start_time,
				$end_time,
				$link = action('Course\MataController@courseDetail', ['id' => $id]),
			);
			}

		return $mata;
	}

	public function approvalPeserta(int $id, $status)
	{
		$peserta = $this->modelPeserta->findOrFail($id);
		$peserta->status = $status;
		$peserta->save();

		return $peserta;
	}

	public function rating($request, int $mataId)
	{
		$rating = MataRating::updateOrCreate([
			'mata_id' => $mataId,
			'user_id' => auth()->user()->id,
		], [
			'mata_id' => $mataId,
			'user_id' => auth()->user()->id,
			'rating' => $request->rating,
		]);

		return $rating;
	}

	public function comment($request, $mataId)
	{
		$komentar = $this->komentar->store($request->komentar, $this->findMata($mataId));

		return $komentar;
	}

	public function deleteMata(int $id)
	{
		$mata = $this->findMata($id);
		// dd($mata->comment->count());
		if (count($mata->materi)  > 0 || count($mata->instruktur) > 0 ||count($mata->peserta) > 0 ||
			count($mata->soalKategori) > 0 || count($mata->soal) > 0 ||
			count(array($mata->sertifikatInternal)) > 0 || count( array($mata->sertifikatExternal)) > 0 ||
			count($mata->rating) > 0 || count($mata->comment) > 0) {

			return false;
		} else {

			if (!empty($mata->cover['filename'])) {
				$this->deleteCoverFromPath($mata->cover['filename']);
			}
			$mata->delete();

			return true;
		}
	}

	public function deleteInstruktur(int $mataId, $id)
	{
		$mata = $this->findMata($mataId);
		$instruktur = $this->modelInstruktur->findOrFail($id);
		$userInstruktur = $this->instruktur->findInstruktur($instruktur->instruktur_id);


		$materi = $mata->materi->where('instruktur_id', $id)->count();
		$bahan = $mata->bahan()->where('creator_id', $instruktur->instruktur->user_id)->count();
		$evaluasi = BahanEvaluasiPengajar::where('mata_id', $mataId)
			->where('mata_instruktur_id', $id)->count();

		if ($materi > 0 || $bahan > 0 || $evaluasi > 0) {
			return false;
		} else {

			$this->notifikasi->make(
				$model = $mata,
				$title = 'Dikeluarkan Dalam Program '.$mata->judul,
				$description = 'Anda Telah Dikeluarkan Dalam Program '.$mata->judul,
				$to = $userInstruktur->user->id
				);

			$instruktur->delete();

			return true;
		}
	}

	public function deletePeserta(int $mataId, $id)
	{
		$mata = $this->findMata($mataId);
		$peserta = $this->modelPeserta->findOrFail($id);
		$userPeserta = $this->peserta->findPeserta($peserta->peserta_id);


		$activity = ActivityCompletion::where('mata_id', $mataId)
			->where('user_id', $peserta->peserta->user->id)->count();
		$evaluasi = ApiEvaluasi::where('mata_id', $mataId)
			->where('user_id', $peserta->peserta->user->id)->count();
		$topik = BahanForumTopik::where('mata_id', $mataId)
			->where('creator_id', $peserta->peserta->user->id)->count();
		$topikDiskusi = BahanForumTopikDiskusi::where('mata_id', $mataId)
			->where('user_id', $peserta->peserta->user->id)->count();
		$tugas = BahanTugasRespon::whereHas('tugas', function ($queryA) use ($mataId) {
			$queryA->whereHas('mata', function ($queryB) use ($mataId) {
				$queryB->where('id', $mataId);
			});
		})->where('user_id', $peserta->peserta->user->id)->count();
		$conference = BahanConferencePeserta::whereHas('conference', function ($queryA) use ($mataId) {
			$queryA->whereHas('mata', function ($queryB) use ($mataId) {
				$queryB->where('id', $mataId);
			});
		})->where('user_id', $peserta->peserta->user->id)->count();
		$quiz = BahanQuizUserTracker::whereHas('quiz', function ($queryA) use ($mataId) {
			$queryA->whereHas('mata', function ($queryB) use ($mataId) {
				$queryB->where('id', $mataId);
			});
		})->where('user_id', $peserta->peserta->user->id)->count();

		if ($activity > 0 || $evaluasi > 0 || $topik > 0 || $topikDiskusi ||
			$tugas > 0 || $conference > 0 || $quiz > 0) {

			return false;
		} else {

			$this->notifikasi->make(
				$model = $mata,
				$title = 'Dikeluarkan Dalam Program '.$mata->judul,
				$description = 'Anda Telah Dikeluarkan Dalam Program '.$mata->judul,
				$to = $userPeserta->user->id
				);

			$peserta->delete();

			return true;
		}
	}

	public function deleteCoverFromPath($fileName)
	{
		$path = public_path('userfile/cover/'.$fileName) ;
		File::delete($path);

		return $path;
	}

	public function checkUserEnroll(int $id)
	{
		$mata = $this->findMata($id);

		if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
			$query = $this->modelMateri->query();
			$query->where('mata_id', $id);
			// $query->whereIn('instruktur_id', [auth()->user()->instruktur->id]);

			return $query->count();
		}

		if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
			$registerPeserta = $this->modelPeserta->where('mata_id', $id)
				->where('peserta_id', auth()->user()->peserta->id)->count();

			return $registerPeserta;
		}
	}
}
