<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Services\KonfigurasiService;
use App\Services\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private $service, $serviceKonfig;

    public function __construct(
        PageService $service,
        KonfigurasiService $serviceKonfig
    )
    {
        $this->service = $service;
        $this->serviceKonfig = $serviceKonfig;
    }

    public function index(Request $request)
    {
        $s = '';
        $q = '';
        if (isset($request->s) || isset($request->q)) {
            $s = '?s='.$request->s;
            $q = '&q='.$request->q;
        }

        $data['pages'] = $this->service->getPageList($request);
        $data['number'] = $data['pages']->firstItem();
        $data['pages']->withPath(url()->current().$s.$q);

        return view('backend.page.index', compact('data'), [
            'title' => 'Pages',
            'breadcrumbsBackend' => [
                'Pages' => ''
            ],
        ]);
    }

    public function read($id, $slug)
    {
        if ($id == 1) {
            return redirect()->route('home');
        }

        $this->service->viewer($id);

        $data['read'] = $this->service->findPage($id);

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

        $data['creator'] = $data['read']->creator['name'];
        if (!empty($data['read']->cover['filename'])) {
            $data['cover'] = $data['read']->getCover($data['read']->cover['filename']);
        }

        if ($id == null) {
            return abort(404);
        }

        if (request()->segment(4) != $data['read']->slug) {
            return redirect()->route('page.read', ['id' => $id, 'slug' => $data['read']->slug]);
        }

        $blade = 'index';
        if (!empty($data['read']->custom_view)) {
            $blade = 'custom.'.$data['read']->custom_view;
        }

        return view('frontend.page.'.$blade, compact('data'), [
            'title' => $data['read']->judul,
            'breadcrumbsFrontend' => [
                'Page' => 'javascript:;',
                $data['read']->judul => '',
            ],
        ]);
    }

    public function create(Request $request)
    {
        $data['null'] = '';
        if ($request->get('parent') != null) {
            $data['parent'] = $this->service->findPage($request->get('parent'));
        }

        return view('backend.page.form', compact('data'), [
            'title' => 'Page - Tambah',
            'breadcrumbsBackend' => [
                'Pages' => route('page.index'),
                'Tambah' => '',
            ],
        ]);
    }

    public function store(PageRequest $request)
    {
        $this->service->storePage($request);

        return redirect()->route('page.index')->with('success', 'Page berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['page'] = $this->service->findPage($id);

        return view('backend.page.form', compact('data'), [
            'title' => 'Page - Edit',
            'breadcrumbsBackend' => [
                'Pages' => route('page.index'),
                'Edit' => ''
            ],
        ]);
    }

    public function update(PageRequest $request, $id)
    {
        $this->service->updatePage($request, $id);

        return redirect()->route('page.index')->with('success', 'Page berhasil diedit');
    }

    public function publish($id)
    {
        $this->service->statusPage($id);

        return back()->with('success', 'Status berhasil diubah');
    }

    public function position($id, $position, $parent)
    {
        $this->service->positionPage($id, $position, $parent);

        return back()->with('success', 'Posisi berhasil diubah');
    }

    public function destroy($id)
    {
        $this->service->deletePage($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
