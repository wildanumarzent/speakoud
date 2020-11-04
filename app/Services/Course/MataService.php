<?php

namespace App\Services\Course;

use App\Models\Course\MataPelatihan;
use Illuminate\Support\Facades\File;

class MataService
{
    private $model;

    public function __construct(MataPelatihan $model)
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

        $result = $query->orderBy('urutan', 'ASC')->paginate(9);

        return $result;
    }

    public function findMata(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeMata($request, int $programId)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', $request->file('cover_file')
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

        return $mata;
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
        $mata->intro = $request->intro ?? null;
        $mata->content = $request->content ?? null;
        $mata->cover = [
            'filename' => $fileName ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $mata->publish = (bool)$request->publish;
        $mata->publish_start = $request->publish_start ?? null;
        $mata->publish_end = $request->publish_end ?? null;
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

    public function deleteMata(int $id)
    {
        $mata = $this->findMata($id);

        if (!empty($mata->cover['filename'])) {
            $this->deleteCoverFromPath($mata->cover['filename']);
        }
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
