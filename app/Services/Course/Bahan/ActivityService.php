<?php

namespace App\Services\Course\Bahan;

use App\Events\ActivitySaved;
use App\Models\Course\Bahan\ActivityCompletion;

class ActivityService
{
    private $model, $bahan;

    public function __construct(
        ActivityCompletion $model,
        BahanService $bahan
    )
    {
        $this->model = $model;
        $this->bahan = $bahan;
    }

    public function getActivityByMata(int $mataId)
    {
        $query = $this->model->query();

        $query->where('mata_id', $mataId);

        return $query->get();
    }

    public function findActivity(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function restrict(int $bahanId)
    {
        $query = $this->model->query();

        $query->where('bahan_id', $bahanId)->where('user_id', auth()->user()->id);
        $query->whereNotNull('track_end');

        return $query->count();
    }

    public function recordActivity(int $bahanId)
    {
        $bahan = $this->bahan->findBahan($bahanId);

        return $this->model->updateOrCreate([
            'program_id' => $bahan->program_id,
            'mata_id' => $bahan->mata_id,
            'materi_id' => $bahan->materi_id,
            'bahan_id' => $bahanId,
            'user_id' => auth()->user()->id,
        ], [
            'program_id' => $bahan->program_id,
            'mata_id' => $bahan->mata_id,
            'materi_id' => $bahan->materi_id,
            'bahan_id' => $bahanId,
            'user_id' => auth()->user()->id,
            'track_start' => now(),
        ]);
    }

    public function complete(int $bahanId)
    {
        $bahan = $this->bahan->findBahan($bahanId);

        $complete = $this->model->where('program_id', $bahan->program_id)
            ->where('mata_id', $bahan->mata_id)->where('materi_id', $bahan->materi_id)
            ->where('bahan_id', $bahanId)->where('user_id', auth()->user()->id)->first();
        $complete->track_end = now();
        if (auth()->user()->hasRole('peserta_internal|peserta_mitra')) {
            $status = 1;
        } else {
            $status = 0;
        }
        $complete->status = $status;
        $complete->completed_by = auth()->user()->id;
        $complete->save();
        event(new ActivitySaved($complete));
        return $complete;
    }

    public function status(int $id)
    {
        $activity = $this->findActivity($id);
        if (!empty($activity->track_end)) {
            $activity->status = null;
            $activity->track_end = null;
            $activity->completed_by = null;
        } else {
            $activity->status = 0;
            $activity->track_end = now();
            $activity->completed_by = auth()->user()->id;
        }
        $activity->save();

        return $activity;
    }

    public function completeByAdmin(int $bahanId, int $userId)
    {
        $bahan = $this->bahan->findBahan($bahanId);

        $activity = new ActivityCompletion;
        $activity->program_id = $bahan->program_id;
        $activity->mata_id = $bahan->mata_id;
        $activity->materi_id = $bahan->materi_id;
        $activity->bahan_id = $bahanId;
        $activity->user_id = $userId;
        $activity->track_start = now();
        $activity->track_end = now();
        $activity->status = 0;
        $activity->completed_by = auth()->user()->id;
        $activity->save();
        event(new ActivitySaved($activity));
        return $activity;
    }
}
