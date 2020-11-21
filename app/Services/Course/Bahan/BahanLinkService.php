<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanLink;

class BahanLinkService
{
    private $model;

    public function __construct(BahanLink $model)
    {
        $this->model = $model;
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
}
