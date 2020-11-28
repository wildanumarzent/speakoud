<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanConference;
use App\Models\Course\Bahan\BahanConferencePeserta;

class BahanConferenceService
{
    private $model, $modelPeserta;

    public function __construct(
        BahanConference $model,
        BahanConferencePeserta $modelPeserta
    )
    {
        $this->model = $model;
        $this->modelPeserta = $modelPeserta;
    }

    public function getPesertaList($request, int $id)
    {
        $query = $this->modelPeserta->query();

        $query->where('conference_id', $id);
        $query->when($request->q, function ($query, $q) {
            return $query->whereHas('user', function ($query) use ($q) {
                $query->where('name', $q);
            });
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function getPesertaCheckIn(int $id)
    {
        $query = $this->modelPeserta->join('users', 'conference_user_tracker.user_id',
             '=', 'users.id')->select('conference_user_tracker.id as id',
                'conference_user_tracker.check_in_verified', 'conference_user_tracker.join',
                'conference_user_tracker.check_in', 'conference_user_tracker.check_in_verified',
                'users.name');

        $query->where('conference_id', $id);
        $result = $query->orderBy('join', 'ASC')->get();

        return $result;
    }

    public function findConference(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeConference($request, $materi, $bahan)
    {
        $link = new BahanConference;
        $link->program_id = $materi->program_id;
        $link->mata_id = $materi->mata_id;
        $link->materi_id = $materi->id;
        $link->bahan_id = $bahan->id;
        $link->creator_id = auth()->user()->id;
        $link->tipe = (bool)$request->tipe;
        $link->meeting_link = ($request->tipe == 0) ? $this->generateRandomString() :
            $request->meeting_link;
        $link->save();

        return $link;
    }

    public function updatuConferece($request, $bahan)
    {
        $conference = $bahan->conference;
        $conference->tipe = (bool)$request->tipe;
        $conference->meeting_link = ($request->tipe == 0) ? $this->generateRandomString() :
            $request->meeting_link;
        $conference->save();

        return $conference;
    }

    public function generateRandomString($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function statusMeet(int $id, $status)
    {
        $link = $this->findConference($id);
        $link->status = $status;
        $link->save();

        return $link;
    }

    public function checkPesertaJoin(int $id)
    {
        $query = $this->modelPeserta->query();

        $query->where('conference_id', $id)->where('user_id', auth()->user()->id);

        $result = $query->count();

        return $result;
    }

    public function trackPesertaJoin(int $id)
    {
        $peserta = new BahanConferencePeserta();
        $peserta->conference_id = $id;
        $peserta->user_id = auth()->user()->id;
        $peserta->join = now();
        $peserta->save();

        return $peserta;
    }

    public function trackPesertaLeave(int $id)
    {
        $peserta = $this->modelPeserta->where('conference_id', $id)
            ->where('user_id', auth()->user()->id)->first();
        $peserta->leave = now();
        $peserta->save();

        return $peserta;
    }

    public function checkInVerified(int $id)
    {
        $peserta = $this->modelPeserta->findOrFail($id);
        $peserta->check_in = now();
        $peserta->check_in_verified = 1;
        $peserta->save();

        return $peserta;
    }
}
