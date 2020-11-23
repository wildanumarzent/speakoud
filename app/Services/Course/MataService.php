<?php

namespace App\Services\Course;

use App\Models\Course\MataInstruktur;
use App\Models\Course\MataPelatihan;
use App\Models\Course\MataRating;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MataService
{
    private $model;

    public function __construct(
        MataPelatihan $model
    )
    {
        $this->model = $model;
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
        $mata->save();

        $collectInstruktur = $this->collectInstruktur($request);

        foreach ($collectInstruktur->all() as $key => $value) {
            $instruktur = new MataInstruktur();
            $instruktur->mata_id = $mata->id;
            $instruktur->instruktur_id = $value;
            $instruktur->save();
        }

        return $mata;
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
        $mata->save();

        $deleteInstruktur = $mata->instruktur()->delete();

        $collectInstruktur = $this->collectInstruktur($request);

        foreach ($collectInstruktur->all() as $key => $value) {
            $instruktur = new MataInstruktur();
            $instruktur->mata_id = $id;
            $instruktur->instruktur_id = $value;
            $instruktur->save();
        }

        return $mata;
    }

    public function collectInstruktur($request)
    {
        $collectInstruktur = collect($request->instruktur_id);

        return $collectInstruktur;
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

    public function deleteMata(int $id)
    {
        $mata = $this->findMata($id);

        if (!empty($mata->cover['filename'])) {
            $this->deleteCoverFromPath($mata->cover['filename']);
        }
        $mata->instruktur()->delete();
        $mata->materi()->delete();
        $mata->delete();

        return $mata;
    }

    public function deleteCoverFromPath($fileName)
    {
        $path = public_path('userfile/cover/'.$fileName) ;
        File::delete($path);

        return $path;
    }
}
