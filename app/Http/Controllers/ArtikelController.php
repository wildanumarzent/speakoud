<?php

namespace App\Http\Controllers;

use App\Http\Livewire\Notification;
use App\Http\Requests\ArtikelRequest;
use Illuminate\Http\Request;
use App\Services\ArtikelService;
use App\Services\Component\NotificationService;
use App\Services\Component\TagsService;
use App\Services\KonfigurasiService;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $service, $serviceTags, $serviceKonfig;

    public function __construct(
        ArtikelService $service,
        NotificationService $notifikasi,
        TagsService $serviceTags,
        KonfigurasiService $serviceKonfig
    )
    {
        $this->service = $service;
        $this->serviceTags = $serviceTags;
        $this->serviceKonfig = $serviceKonfig;
    }

    public function index(Request $request)
    {
        $p = '';
        $q = '';
        if (isset($request->p) || isset($request->q)) {
            $p = '?p='.$request->p;
            $q = '&q='.$request->q;
        }

        $data['artikel'] = $this->service->getArtikelList($request);
        $data['number'] = $data['artikel']->firstItem();
        $data['artikel']->withPath(url()->current().$p.$q);

        return view('backend.artikel.index', compact('data'), [
            'title' => 'Artikel',
            'breadcrumbsBackend' => [
                'Artikel' => ''
            ],
        ]);
    }

    public function list()
    {
        $data['artikel'] = $this->service->getArtikel();

        return view('frontend.artikel.index', compact('data'), [
            'title' => 'Artikel',
            'breadcrumbsFrontend' => [
                'Artikel' => 'javascript:;',
                'List' => '',
            ],
        ]);
    }

    public function read($id, $slug)
    {
        $this->service->viewer($id);

        $data['read'] = $this->service->findArtikel($id);
        $data['recent'] = $this->service->getRecentArtikel($id);

        //check publish
        if ($data['read']->publish == 0 || empty($data['read'])) {
            return redirect()->route('home');
        }

        //meta data
        $data['meta_title'] = $data['read']->judul;
        if (!empty($data['read']->meta_data['title'])) {
            $data['meta_title'] = $data['read']->meta_data['title'];
        }

        $data['meta_description'] = $this->serviceKonfig->getValue('meta_description');
        if (!empty($data['read']->meta_data['description'])) {
            $data['meta_description'] = $data['read']->meta_data['description'];
        } elseif (empty($data['read']->meta_data['description']) && !empty($data['read']->intro)) {
            $data['meta_description'] = $data['read']->intro;
        } elseif (empty($data['read']->meta_data['description']) && empty($data['read']->intro) && !empty($data['read']->content)) {
            $data['meta_description'] = $data['read']->content;
        }

        $data['meta_keywords'] = $this->serviceKonfig->getValue('meta_keywords');
        if (!empty($data['read']->meta_data['keywords'])) {
            $data['meta_keywords'] = $data['read']->meta_data['keywords'];
        }

        $data['creator'] = $data['read']->userCreated['name'];
        if (!empty($data['read']->cover['filename'])) {
            $data['cover'] = $data['read']->getCover($data['read']->cover['filename']);
        }

        if ($id == null) {
            return abort(404);
        }

        if (request()->segment(4) != $data['read']->slug) {
            return redirect()->route('artikel.read', ['id' => $id, 'slug' => $data['read']->slug]);
        }

        return view('frontend.artikel.detail', compact('data'), [
            'title' => 'Artikel - '.$data['read']->judul,
            'breadcrumbsFrontend' => [
                'Artikel' => 'javascript:;',
                $data['read']->judul => '',
            ],
        ]);
    }

    public function create()
    {
        return view('backend.artikel.form', [
            'title' => 'Artikel - Tambah',
            'breadcrumbsBackend' => [
                'Artikel' => route('artikel.index'),
                'Tambah' => '',
            ],
        ]);
    }

    public function store(ArtikelRequest $request)
    {
        $this->service->storeArtikel($request);
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['artikel'] = $this->service->findArtikel($id);

        return view('backend.artikel.form', compact('data'), [
            'title' => 'Artikel - Edit',
            'breadcrumbsBackend' => [
                'Artikel' => route('artikel.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(ArtikelRequest $request, $id)
    {
        $this->service->updateArtikel($request, $id);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil diedit');
    }

    public function publish($id)
    {
        $this->service->statusArtikel($id);
        return back()->with('success', 'Status berhasil diubah');
    }

    public function destroy($id)
    {
        $this->service->deleteArtikel($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    // public function index(Request $request)
    // {
    //     $q = '';
    //     if (isset($request->q)) {
    //         $q = '?q='.$request->q;
    //     }

    //     $data['artikel'] = $this->artikel->list($request);
    //     $data['number'] = $data['artikel']->firstItem();
    //     $data['artikel']->withPath(url()->current().$q);
    //     return view('backend.artikel.index', compact('data'), [
    //         'title' => 'Artikel',
    //         'breadcrumbsBackend' => [
    //             'Artikel' => '',
    //         ],
    //     ]);
    // }

    // public function list(Request $request){
    //     $data['artikel'] = $this->artikel->listAll();
    //     return view('frontend.artikel.index', compact('data'), [
    //         'title' => 'Artikel',
    //         'breadcrumbsFrontend' => [
    //             'List Artikel' => '',
    //         ],
    //     ]);
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     $data['mode'] = 'create';
    //     return view('backend.artikel.form', compact('data'), [
    //         'title' => 'Artikel',
    //         'breadcrumbsBackend' => [
    //             'Artikel' => route('artikel.index'),
    //             'Tambah' => '',
    //         ],
    //     ]);
    // }
    // public function edit(Artikel $id)
    // {
    //     $data['mode'] = 'edit';
    //     $data['artikel'] = $this->artikel->get($id['id']);
    //     return view('backend.artikel.form', compact('data'), [
    //         'title' => 'Artikel',
    //         'breadcrumbsBackend' => [
    //             'Artikel' => route('artikel.index'),
    //             'Edit' => '',
    //         ],
    //     ]);

    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     if($request->mode == 'edit'){
    //         $this->artikel->update($request);
    //     }else{
    //         $this->artikel->save($request);
    //     }
    //     return redirect()->route('artikel.index')
    //     ->with('success', 'Artikel Telah Disimpan');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Artikel  $artikel
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Artikel $id)
    // {
    //     $this->artikel->viewer($id['id']);
    //     $data['artikel'] = $this->artikel->get($id['id']);
    //     $data['recent'] = $this->artikel->recent($id);
    //     $data['bannerless'] = true;
    //     return view('frontend.artikel.detail', compact('data'), [
    //         'title' => 'Artikel - '.$id['title'],
    //     ]);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Artikel  $artikel
    //  * @return \Illuminate\Http\Response
    //  */


    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Artikel  $artikel
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Artikel $artikel)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Artikel  $artikel
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $this->artikel->delete($id);
    //     return redirect()->route('artikel.index')
    //     ->with('success', 'Artikel Telah Dihapus');
    // }
}
