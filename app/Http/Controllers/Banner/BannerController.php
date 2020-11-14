<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Services\Banner\BannerKategoriService;
use App\Services\Banner\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    private $service, $serviceKategori;

    public function __construct(
        BannerService $service,
        BannerKategoriService $serviceKategori
    )
    {
        $this->service = $service;
        $this->serviceKategori = $serviceKategori;
    }

    public function index($kategoriId)
    {
        $data['banner'] = $this->service->getBannerList($kategoriId);
        $data['kategori'] = $this->serviceKategori->findBannerKategori($kategoriId);

        return view('backend.banner.index', compact('data'), [
            'title' => 'Banner',
            'breadcrumbsBackend' => [
                'Kategori' => route('banner.index'),
                'Banner' => '',
            ],
        ]);
    }

    public function create($kategoriId)
    {
        $data['kategori'] = $this->serviceKategori->findBannerKategori($kategoriId);

        return view('backend.banner.form', compact('data'), [
            'title' => 'Banner - Tambah',
            'breadcrumbsBackend' => [
                'Kategori' => route('banner.index'),
                'Banner' => route('banner.media', ['id' => $kategoriId]),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(BannerRequest $request, $kategoriId)
    {
        $this->service->storeBanner($request, $kategoriId);

        return redirect()->route('banner.media', ['id' => $kategoriId])
            ->with('success', 'Banner berhasil ditambahkan');
    }

    public function edit($kategoriId, $id)
    {
        $data['banner'] = $this->service->findBanner($id);
        $data['kategori'] = $this->serviceKategori->findBannerKategori($kategoriId);

        return view('backend.banner.form', compact('data'), [
            'title' => 'Banner - Edit',
            'breadcrumbsBackend' => [
                'Kategori' => route('banner.index'),
                'Banner' => route('banner.media', ['id' => $kategoriId]),
                'Edit' => ''
            ],
        ]);
    }

    public function update(BannerRequest $request, $kategoriId, $id)
    {
        $this->service->updateBanner($request, $id);

        return redirect()->route('banner.media', ['id' => $kategoriId])
            ->with('success', 'Banner berhasil diedit');
    }

    public function publish($kategoriId, $id)
    {
        $this->service->publishBanner($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function sort($kategoriId)
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sortBanner($value, $i);
        }
    }

    public function destroy($kategoriId, $id)
    {
        $this->service->deleteBanner($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
