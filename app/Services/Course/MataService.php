<?php

namespace App\Services\Course;

use App\Models\Course\ApiEvaluasi;
use App\Models\Course\MataInstruktur;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MataPeserta;
use App\Models\Course\MataRating;
use App\Services\Component\KomentarService;
use App\Services\Users\PesertaService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MataService
{
    private $model, $modelInstruktur, $modelPeserta, $komentar, $peserta;

    public function __construct(
        MataPelatihan $model,
        MataInstruktur $modelInstruktur,
        MataPeserta $modelPeserta,
        KomentarService $komentar,
        PesertaService $peserta
    )
    {
        $this->model = $model;
        $this->modelInstruktur = $modelInstruktur;
        $this->modelPeserta = $modelPeserta;
        $this->komentar = $komentar;
        $this->peserta = $peserta;
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
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%')
                    ->orWhere('intro', 'like', '%'.$q.'%');
            });
        });
        if (isset($request->p)) {
            $query->where('publish', $request->p);
        }

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            $query->whereHas('instruktur', function ($query) {
                $query->where('instruktur_id', auth()->user()->instruktur->id);
            });
        }

        $result = $query->orderBy('urutan', 'ASC')->paginate(9);

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

    public function getPesertaList($request, int $mataId)
    {
        $query = $this->modelPeserta->query();

        $query->where('mata_id', $mataId);
        $query->whereHas('peserta', function ($query) use ($request) {
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

    public function getMata($order, $by, int $limit)
    {
        $query = $this->model->query();

        $query->whereHas('program', function ($query) {
            $query->publish();
        });
        $query->publish();

        $result = $query->orderBy($order, $by)->paginate($limit);

        return $result;
    }

    public function findMata(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeMata($request, int $programId)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('cover_file')
                ->getClientOriginalName());
            $request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
        }

        $mata = new MataPelatihan($request->only(['judul']));
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
        $mata->publish = (bool)$request->publish;
        $mata->publish_start = $request->publish_start ?? null;
        $mata->publish_end = ($request->enable == 1 ? $request->publish_end : null);
        $mata->urutan = ($this->model->where('program_id', $programId)->max('urutan') + 1);
        $mata->show_feedback = (bool)$request->show_feedback;
        $mata->show_comment = (bool)$request->show_comment;
        $mata->save();

        return $mata;
    }

    public function storeInstruktur($request, int $mataId)
    {
        $collectInstruktur = collect($request->instruktur_id);
        foreach ($collectInstruktur->all() as $key => $value) {
            $instruktur = new MataInstruktur;
            $instruktur->mata_id = $mataId;
            $instruktur->instruktur_id = $value;
            $instruktur->save();
        }
    }

    public function storePeserta($request, int $mataId)
    {
        $mata = $this->findMata($mataId);

        $collectPeserta = collect($request->peserta_id);
        foreach ($collectPeserta->all() as $key => $value) {
            $peserta = new MataPeserta;
            $peserta->mata_id = $mataId;
            $peserta->peserta_id = $value;
            $peserta->save();

            if (!empty($mata->kode_evaluasi)) {
                $peserta = $this->peserta->findPeserta($value);
                $client = new \GuzzleHttp\Client();
                $url = config('addon.api.evaluasi.end_point').'/register/'.$mata->kode_evaluasi;
                $parameter = [
                    'nama' => $peserta->user->name,
                    'kode_peserta' => $peserta->nip,
                    'email' => $peserta->user->email,
                    'kode_instansi' => '15017',
                    'unit_kerja' => $peserta->unit_kerja,
                    'deputi' => $peserta->kedeputian,
                ];
                $response = $client->request('POST', $url, [
                    'form_params' => $parameter,
                ]);

                $data = $response->getBody()->getContents();
                $json = json_decode($data);

                if ($json->success == true) {
                    $api = new ApiEvaluasi;
                    $api->mata_id = $mataId;
                    $api->user_id = $peserta->user_id;
                    $api->token = $json->data->token;
                    $api->evaluasi = $json->data->evaluasi;
                    $api->waktu_mulai = $json->data->evaluasi->waktu_mulai;
                    $api->waktu_selesai = $json->data->evaluasi->waktu_selesai;
                    $api->lama_jawab = $json->data->evaluasi->lama_jawab;
                    $api->save();
                }
            }
        }
    }

    public function updateMata($request, int $id)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('cover_file')
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
        $mata->publish = (bool)$request->publish;
        $mata->publish_start = $request->publish_start ?? null;
        $mata->publish_end = $request->publish_end ?? null;
        $mata->show_feedback = (bool)$request->show_feedback;
        $mata->show_comment = (bool)$request->show_comment;
        $mata->save();

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

        if (!empty($mata->cover['filename'])) {
            $this->deleteCoverFromPath($mata->cover['filename']);
        }
        $mata->instruktur()->delete();
        $mata->peserta()->delete();
        $mata->materi()->delete();
        $mata->comment()->delete();
        $mata->delete();

        return $mata;
    }

    public function deleteInstruktur(int $mataId, $id)
    {
        $mata = $this->findMata($mataId);
        $instruktur = $this->modelInstruktur->findOrFail($id);

        $checkBahan = $mata->bahan()->where('creator_id', $instruktur->instruktur->user_id)->count();
        if ($checkBahan > 0) {
            return false;
        } else {
            $instruktur->delete();

            return $instruktur;
        }
    }

    public function deletePeserta(int $mataId, $id)
    {
        $mata = $this->findMata($mataId);
        $peserta = $this->modelPeserta->findOrFail($id);
        $peserta->delete();

        return $peserta;
    }

    public function deleteCoverFromPath($fileName)
    {
        $path = public_path('userfile/cover/'.$fileName) ;
        File::delete($path);

        return $path;
    }

    public function checkUser(int $id)
    {
        $mata = $this->findMata($id);

        if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
            $registerInstruktur = $this->modelInstruktur->where('mata_id', $id)
                ->where('instruktur_id', auth()->user()->instruktur->id)->count();

            return $registerInstruktur;
        }

        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $registerPeserta = $this->modelPeserta->where('mata_id', $id)
                ->where('peserta_id', auth()->user()->peserta->id)->count();

            return $registerPeserta;
        }
    }
}
