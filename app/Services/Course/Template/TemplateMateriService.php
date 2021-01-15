<?php

namespace App\Services\Course\Template;

use App\Models\Course\Template\Bahan\TemplateBahan;
use App\Models\Course\Template\TemplateMateri;

class TemplateMateriService
{
    private $model;

    public function __construct(
        TemplateMateri $model
    )
    {
        $this->model = $model;
    }

    public function getTemplateMateriList($request, int $mataId)
    {
        $query = $this->model->query();

        $query->where('template_mata_id', $mataId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'ilike', '%'.$q.'%');
            });
        });

        $result = $query->orderBy('urutan', 'ASC')->paginate(10);

        return $result;
    }

    public function templateMateriJump(int $mataId, int $id)
    {
        $query = $this->model->query();

        $query->where('template_mata_id', $mataId);
        $query->whereNotIn('id', [$id]);

        $result = $query->orderBy('urutan', 'ASC')->get();

        return $result;
    }

    public function findTemplateMateri(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTemplateMateri($request, int $mataId)
    {
        $materi = new TemplateMateri($request->only(['judul']));
        $materi->template_mata_id = $mataId;
        $materi->creator_id = auth()->user()->id;
        $materi->keterangan = $request->keterangan ?? null;
        $materi->urutan = ($this->model->where('template_mata_id', $mataId)->max('urutan') + 1);
        $materi->save();

        return $materi;
    }

    public function updateTemplateMateri($request, int $id)
    {
        $materi = $this->findTemplateMateri($id);
        $materi->fill($request->only(['judul']));
        $materi->keterangan = $request->keterangan ?? null;
        $materi->save();

        return $materi;
    }

    public function positionTemplateMateri(int $id, $urutan)
    {
        if ($urutan >= 1) {

            $materi = $this->findTemplateMateri($id);
            $this->model->where('urutan', $urutan)->update([
                'urutan' => $materi->urutan,
            ]);
            $materi->urutan = $urutan;
            $materi->save();

            return $materi;
        } else {
            return false;
        }
    }

    public function sortTemplateMateri(int $id, $urutan)
    {
        $find = $this->findTemplateMateri($id);

        $materi = $this->model->where('id', $id)
                ->where('template_mata_id', $find->template_mata_id)->update([
            'urutan' => $urutan
        ]);

        return $materi;
    }

    public function deleteTemplateMateri(int $id)
    {
        $materi = $this->findTemplateMateri($id);

        $bahan = TemplateBahan::where('template_materi_id', $id)->count();

        if ($bahan > 0) {

            return false;
        } else {

            $materi->delete();

            return true;
        }
    }
}
