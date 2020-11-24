<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanLink;
use App\Models\Course\Bahan\BahanLinkPeserta;

class BahanLinkService
{
    private $model, $modelPeserta;

    public function __construct(
        BahanLink $model,
        BahanLinkPeserta $modelPeserta
    )
    {
        $this->model = $model;
        $this->modelPeserta = $modelPeserta;
    }

    public function getPesertaList($request, int $id)
    {
        $query = $this->modelPeserta->query();

        $query->where('link_id', $id);
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
        $query = $this->modelPeserta->join('users', 'link_user_tracker.user_id',
             '=', 'users.id')->select('link_user_tracker.id as id',
                'link_user_tracker.check_in_verified', 'link_user_tracker.join',
                'link_user_tracker.check_in', 'link_user_tracker.check_in_verified',
                'users.name');

        $query->where('link_id', $id);
        $result = $query->orderBy('join', 'ASC')->get();

        return $result;
    }

    public function findLink(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeLink($request, $materi, $bahan)
    {
        $link = new BahanLink;
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

    public function updateLink($request, $bahan)
    {
        $link = $bahan->link;
        $link->tipe = (bool)$request->tipe;
        $link->meeting_link = ($request->tipe == 0) ? $this->generateRandomString() :
            $request->meeting_link;
        $link->save();

        return $link;
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
        $link = $this->findLink($id);
        $link->status = $status;
        $link->save();

        return $link;
    }

    public function checkPesertaJoin(int $id)
    {
        $query = $this->modelPeserta->query();

        $query->where('link_id', $id)->where('user_id', auth()->user()->id);

        $result = $query->count();

        return $result;
    }

    public function trackPesertaJoin(int $id)
    {
        $peserta = new BahanLinkPeserta;
        $peserta->link_id = $id;
        $peserta->user_id = auth()->user()->id;
        $peserta->join = now();
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
