<?php

namespace App\Services\Course;

use App\Models\Course\ProgramPelatihan;
use Illuminate\Support\Facades\File;

class ProgramService
{
    private $model;

    public function __construct(ProgramPelatihan $model)
    {
        $this->model = $model;
    }

    public function getProgramList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%')
                    ->orWhere('keterangan', 'like', '%'.$q.'%');
            });
        });

        //cek role
        if (auth()->user()->hasRole('internal|instruktur_internal')) {
            $query->where('tipe', 0);
        }
        if (auth()->user()->hasRole('mitra')) {
            $query->where('mitra_id', auth()->user()->id)
                ->orWhere('tipe', 1);
        }
        if (auth()->user()->hasRole('instruktur_mitra')) {
            $query->where('mitra_id', auth()->user()->instruktur->mitra_id)
                ->orWhere('tipe', 1);
        }

        if (isset($request->p)) {
            $query->where('publish', $request->p);
        }
        if (isset($request->t)) {
            $query->where('tipe', $request->t);
        }

        $result = $query->orderBy('urutan', 'ASC')->paginate(9);

        return $result;
    }

    public function findProgram(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeProgram($request)
    {
        if (auth()->user()->hasRole('mitra')) {
            $tipe = 1;
        }
        if (auth()->user()->hasRole('internal')) {
            $tipe = 0;
        }
        if (auth()->user()->hasRole('developer|administrator')) {
            $tipe = $request->tipe;
        }

        $program = new ProgramPelatihan($request->only(['judul']));
        $program->creator_id = auth()->user()->id;
        $program->mitra_id = $request->mitra_id ?? null;
        $program->keterangan = $request->keterangan ?? null;
        $program->urutan = ($this->model->max('urutan') + 1);
        $program->tipe = $tipe;
        $program->save();

        return $program;
    }

    public function updateProgram($request, int $id)
    {
        $program = $this->findProgram($id);
        $program->fill($request->only(['judul']));
        $program->keterangan = $request->keterangan ?? null;
        $program->save();

        return $program;
    }

    public function positionProgram(int $id, $urutan)
    {
        if ($urutan >= 1) {

            $program = $this->findProgram($id);
            $this->model->where('urutan', $urutan)->update([
                'urutan' => $program->urutan,
            ]);
            $program->urutan = $urutan;
            $program->save();

            return $program;
        } else {
            return false;
        }
    }

    public function sortProgram(int $id, $urutan)
    {
        $program = $this->model->where('id', $id)->update([
            'urutan' => $urutan
        ]);

        return $program;
    }

    public function publishProgram(int $id)
    {
        $program = $this->findProgram($id);
        $program->publish = !$program->publish;
        $program->save();

        return $program;
    }

    public function deleteProgram(int $id)
    {
        $program = $this->findProgram($id);

        $program->materi()->delete();
        if ($program->mata()->count() > 0) {
            foreach ($program->mata as $value) {
                $path = public_path('userfile/cover/'.$value->cover['filename']) ;
                File::delete($path);
            }
        }
        $program->mata()->delete();
        $program->delete();

        return $program;
    }

    public function checkInstruktur(int $id)
    {
        $program = $this->findProgram($id);

        if (auth()->user()->hasRole('mitra|instruktur_mitra')) {
            if ($program->tipe == 0) {
                return abort(403);
            }

            if (auth()->user()->hasRole('mitra') && $program->mitra_id
                != auth()->user()->mitra->id || auth()->user()->hasRole('instruktur_mitra')
                && $program->mitra_id != auth()->user()->instruktur->mitra_id) {
                return abort(403);
            }
        }

        if (auth()->user()->hasRole('internal|instruktur_internal')) {
            if ($program->tipe == 1) {
                return abort(403);
            }
        }
    }

    public function checkPeserta(int $id)
    {
        $program = $this->findProgram($id);

        if (auth()->user()->hasRole('peserta_internal')) {
            if ($program->tipe == 1) {
                return abort(403);
            }
        }

        if (auth()->user()->hasRole('peserta_mitra')) {
            if ($program->tipe == 0 || $program->mitra_id != auth()->user()->peserta->mitra_id) {
                return abort(403);
            }
        }
    }
}
