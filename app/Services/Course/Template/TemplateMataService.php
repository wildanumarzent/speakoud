<?php

namespace App\Services\Course\Template;

use App\Models\Course\MataPelatihan;
use App\Models\Course\Template\TemplateMata;
use App\Models\Course\Template\TemplateMataBobot;
use App\Models\Course\Template\TemplateMateri;

class TemplateMataService
{
    private $model, $modelBobot;

    public function __construct(
        TemplateMata $model,
        TemplateMataBobot $modelBobot
    )
    {
        $this->model = $model;
        $this->modelBobot = $modelBobot;
    }

    public function getTemplateMataList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'ilike', '%'.$q.'%');
            });
        });

        $limit = 10;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('urutan', 'ASC')->paginate($limit);

        return $result;
    }

    public function findTemplateMata(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeTemplateMata($request)
    {
        $mata = new TemplateMata($request->only(['judul']));
        $mata->creator_id = auth()->user()->id;
        $mata->intro = $request->intro ?? null;
        $mata->content = $request->content ?? null;
        $mata->pola_penyelenggaraan = $request->pola_penyelenggaraan ?? null;
        $mata->sumber_anggaran = $request->sumber_anggaran ?? null;
        $mata->show_feedback = (bool)$request->show_feedback;
        $mata->show_comment = (bool)$request->show_comment;
        $mata->urutan = ($this->model->max('urutan') + 1);
        $mata->save();

        $bobot = new TemplateMataBobot;
        $bobot->template_mata_id = $mata->id;
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

    public function updateTemplateMata($request, int $id)
    {
        $mata = $this->findTemplateMata($id);
        $mata->fill($request->only(['judul']));
        $mata->intro = $request->intro ?? null;
        $mata->content = $request->content ?? null;
        $mata->pola_penyelenggaraan = $request->pola_penyelenggaraan ?? null;
        $mata->sumber_anggaran = $request->sumber_anggaran ?? null;
        $mata->show_feedback = (bool)$request->show_feedback;
        $mata->show_comment = (bool)$request->show_comment;
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

    public function positionTemplateMata(int $id, $urutan)
    {
        if ($urutan >= 1) {

            $mata = $this->findTemplateMata($id);
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

    public function sortTemplateMata(int $id, $urutan)
    {
        $find = $this->findTemplateMata($id);

        $mata = $this->model->where('id', $id)->update([
            'urutan' => $urutan
        ]);

        return $mata;
    }

    public function publishTemplateMata(int $id)
    {
        $mata = $this->findTemplateMata($id);
        $mata->publish = !$mata->publish;
        $mata->save();
    }

    public function deleteTemplateMata(int $id)
    {
        $mata = $this->findTemplateMata($id);

        $program = MataPelatihan::where('template_id', $id)->count();
        $materi = TemplateMateri::where('template_mata_id', $id)->count();

        if ($materi > 0 || $program > 0) {

            return false;
        } else {

            $mata->delete();

            return true;
        }
    }
}
