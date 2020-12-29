<?php

namespace App\Http\Controllers\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerKategoriRequest;
use App\Services\Banner\BannerKategoriService;
use Illuminate\Http\Request;

class BannerKategoriController extends Controller
{
    private $service;

    public function __construct(BannerKategoriService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $q = '';
        if (isset($request->q)) {
            $q = '?q='.$request->q;
        }

        $data['kategori'] = $this->service->getBannerKategoriList($request);
        $data['number'] = $data['kategori']->firstItem();
        $data['kategori']->withPath(url()->current().$q);

        return view('backend.banner.kategori.index', compact('data'), [
            'title' => 'Banner - Kategori',
            'breadcrumbsBackend' => [
                'Banner' => '',
                'Kategori' => ''
            ],
        ]);
    }

    public function create()
    {
        return view('backend.banner.kategori.form', [
            'title' => 'Banner - Kategori - Tambah',
            'breadcrumbsBackend' => [
                'Banner' => '',
                'Kategori' => route('banner.index'),
                'Tambah' => ''
            ],
        ]);
    }

    public function store(BannerKategoriRequest $request)
    {
        $this->service->storeBannerKategori($request);

        return redirect()->route('banner.index')
            ->with('success', 'Banner berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['kategori'] = $this->service->findBannerKategori($id);

        return view('backend.banner.kategori.form', compact('data'), [
            'title' => 'Banner - Kategori - Edit',
            'breadcrumbsBackend' => [
                'Banner' => '',
                'Kategori' => route('banner.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(BannerKategoriRequest $request, $id)
    {
        $this->service->updateBannerKategori($request, $id);

        return redirect()->route('banner.index')
            ->with('success', 'Banner berhasil diedit');
    }

    public function destroy($id)
    {
        $delete = $this->service->deleteBannerKategori($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {

            return response()->json([
                'success' => 0,
                'message' => 'Kategori masih memiliki file banner'
            ], 200);
        }
    }
}
