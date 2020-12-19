<?php

namespace App\Services\Course;

use App\Models\Course\JadwalPelatihan;
use App\Models\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class JadwalService
{
    private $model;

    public function __construct(JadwalPelatihan $model)
    {
        $this->model = $model;
    }

    public function getJadwalList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%')
                    ->orWhere('keterangan', 'like', '%'.$q.'%');
            });
        });
        if (auth()->user()->hasRole('internal')) {
            $query->whereHas('mata', function ($queryB) {
                $queryB->whereHas('program', function ($queryC) {
                    $queryC->where('tipe', 0);
                });
            });
        }
        if (auth()->user()->hasRole('mitra')) {
            $query->whereHas('mata', function ($queryB) {
                $queryB->whereHas('program', function ($queryC) {
                    $queryC->where('mitra_id', auth()->user()->id)
                        ->where('tipe', 1);
                });
            });
        }
        if (isset($request->p)) {
            $query->where('publish', $request->p);
        }

        $result = $query->paginate(9);

        return $result;
    }

    public function getJadwal(int $limit)
    {
        $query = $this->model->query();

        $query->whereHas('mata', function ($query) {
            $query->publish();
        });
        $query->publish();

        $result = $query->orderBy('created_at', 'DESC')->paginate($limit);

        return $result;
    }

    public function findJadwal(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeJadwal($request)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('cover_file')
                ->getClientOriginalName());
            $request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
        }

        $jadwal = new JadwalPelatihan($request->only(['judul']));
        $jadwal->mata_id = $request->mata_id;
        $jadwal->creator_id = auth()->user()->id;
        $jadwal->keterangan = $request->keterangan ?? null;
        $jadwal->start_date = $request->start_date;
        $jadwal->end_date = $request->end_date;
        $jadwal->start_time = $request->start_time;
        $jadwal->end_time = $request->end_time;
        $jadwal->lokasi = $request->lokasi ?? null;
        $jadwal->cover = [
            'filename' => $fileName ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $jadwal->publish = (bool)$request->publish;
        $jadwal->save();

        $event = new Event;
        $event->title = $request->judul;
        $event->description = strip_tags($request->keterangan);
        $event->className = 'fc-event-primary';
        $event->start = $request->start_date;
        $event->end = $request->end_date;
        $event->allDay = 1;
        $event->save();

        return $jadwal;
    }

    public function updateJadwal($request, int $id)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('cover_file')
                ->getClientOriginalName());
            $this->deleteCoverFromPath($request->old_cover_file);
            $request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
        }

        $jadwal = $this->findJadwal($id);
        $jadwal->fill($request->only(['judul']));
        $jadwal->mata_id = $request->mata_id;
        $jadwal->keterangan = $request->keterangan ?? null;
        $jadwal->start_date = $request->start_date;
        $jadwal->end_date = $request->end_date;
        $jadwal->start_time = $request->start_time;
        $jadwal->end_time = $request->end_time;
        $jadwal->lokasi = $request->lokasi ?? null;
        $jadwal->cover = [
            'filename' => $fileName ?? $jadwal->cover['filename'],
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $jadwal->publish = (bool)$request->publish;
        $jadwal->save();

        return $jadwal;
    }

    public function publishJadwal(int $id)
    {
        $jadwal = $this->findJadwal($id);
        $jadwal->publish = !$jadwal->publish;
        $jadwal->save();

        return $jadwal;
    }

    public function deleteJadwal(int $id)
    {
        $jadwal = $this->findJadwal($id);

        if (!empty($jadwal->cover['filename'])) {
            $this->deleteCoverFromPath($jadwal->cover['filename']);
        }
        $jadwal->delete();

        return $jadwal;
    }

    public function deleteCoverFromPath($fileName)
    {
        $path = public_path('userfile/cover/'.$fileName) ;
        File::delete($path);

        return $path;
    }
}
