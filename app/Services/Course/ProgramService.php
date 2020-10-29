<?php

namespace App\Services\Course;

use App\Models\Course\ProgramPelatihan;

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
        if (isset($request->p)) {
            $query->where('publish', $request->p);
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
        $program = new ProgramPelatihan($request->only(['judul']));
        $program->creator_id = auth()->user()->id;
        $program->keterangan = $request->keterangan ?? null;
        $program->urutan = ($this->model->max('urutan') + 1);
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
        $program = $this->findProgram($id);
        $program->urutan = $urutan;
        $program->save();

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
        $program->delete();

        return $program;
    }
}
