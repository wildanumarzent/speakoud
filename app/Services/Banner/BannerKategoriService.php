<?php

namespace App\Services\Banner;

use App\Models\Banner\BannerKategori;
use Illuminate\Support\Facades\File;

class BannerKategoriService
{
    private $model;

    public function __construct(BannerKategori $model)
    {
        $this->model = $model;
    }

    public function getBannerKategoriList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%');
            });
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function findBannerKategori(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeBannerKategori($request)
    {
        $kategori = new BannerKategori();
        $kategori->judul = $request->judul;
        $kategori->keterangan = $request->keterangan ?? null;
        $kategori->save();

        return $kategori;
    }

    public function updateBannerKategori($request, int $id)
    {
        $kategori = $this->findBannerKategori($id);
        $kategori->judul = $request->judul;
        $kategori->keterangan = $request->keterangan ?? null;
        $kategori->save();

        return $kategori;
    }

    public function deleteBannerKategori(int $id)
    {
        $kategori = $this->findBannerKategori($id);

        $banner = $kategori->banner;
        foreach ($banner as $key) {
            $path = public_path('userfile/banner/'.$id.'/'.$key->file) ;
            File::delete($path);
        }

        $kategori->banner()->delete();
        $kategori->delete();

        return $kategori;
    }
}
