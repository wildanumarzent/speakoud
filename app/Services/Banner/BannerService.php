<?php

namespace App\Services\Banner;

use App\Models\Banner\Banner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BannerService
{
    private $model;

    public function __construct(Banner $model)
    {
        $this->model = $model;
    }

    public function getBannerList(int $kategoriId)
    {
        $query = $this->model->query();

        $query->where('banner_kategori_id', $kategoriId);

        $result = $query->orderBy('urutan', 'ASC')->paginate(6);

        return $result;
    }

    public function findBanner(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeBanner($request, int $kategoriId)
    {
        if ($request->hasFile('file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('file')
                ->getClientOriginalName());
            $request->file('file')->move(public_path('userfile/banner/'.$kategoriId), $fileName);

            $banner = new Banner($request->only(['judul']));
            $banner->banner_kategori_id = $kategoriId;
            $banner->creator_id = auth()->user()->id;
            $banner->file = $fileName;
            $banner->keterangan = $request->keterangan ?? null;
            $banner->publish = (bool)$request->publish;
            $banner->link = $request->link ?? null;
            $banner->urutan = $this->model->where('banner_kategori_id', (int)$kategoriId)->max('urutan') + 1;
            $banner->save();

            return $banner;
        } else {
            return false;
        }
    }

    public function updateBanner($request, int $id)
    {
        $banner = $this->findBanner($id);

        if ($request->hasFile('file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('file')
                ->getClientOriginalName());
            $this->deleteBannerFromPath($request->old_file, $banner->banner_kategori_id);
            $request->file('file')->move(public_path('userfile/banner/'.$banner->banner_kategori_id), $fileName);

        }

        $banner->file = !empty($request->file) ? $fileName : $banner->file;
        $banner->keterangan = $request->keterangan ?? null;
        $banner->publish = (bool)$request->publish;
        $banner->link = $request->link ?? null;
        $banner->save();

        return $banner;
    }

    public function publishBanner(int $id)
    {
        $banner = $this->findBanner($id);
        $banner->publish = !$banner->publish;
        $banner->save();

        return $banner;
    }

    public function sortBanner(int $id, $urutan)
    {
        $find = $this->findBanner($id);

        $banner = $this->model->where('id', $id)
                ->where('banner_kategori_id', $find->banner_kategori_id)->update([
            'urutan' => $urutan
        ]);

        return $banner;
    }

    public function deleteBanner(int $id)
    {
        $banner = $this->findBanner($id);

        $this->deleteBannerFromPath($banner->file, $banner->banner_kategori_id);
        $banner->delete();

        return $banner;
    }

    public function deleteBannerFromPath($fileName, $kategoriId)
    {
        $path = public_path('userfile/banner/'.$kategoriId.'/'.$fileName) ;
        File::delete($path);

        return $path;
    }

}
