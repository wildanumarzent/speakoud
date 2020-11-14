<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageService
{
    private $model;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function getPageList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('judul', 'like', '%'.$q.'%');
            });
        });

        if (isset($request->s)) {
            $query->where('publish', $request->s);
        }

        $result = $query->where('parent', 0)->orderBy('urutan', 'ASC')->paginate(10);

        return $result;
    }

    public function findPage(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storePage($request)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('cover_file')
                ->getClientOriginalName());
            $request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
        }

        $parent = $request->parent ?? 0;

        $page = new Page($request->only(['judul']));
        $page->creator_id = auth()->user()->id;
        $page->parent = $parent;
        $page->slug = Str::slug($request->slug, '-');
        $page->intro = $request->intro ?? null;
        $page->content = $request->content ?? null;
        $page->cover = [
            'filename' => $fileName ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $page->publish = (bool)$request->publish;
        $page->custom_view = $request->custom_view ?? null;
        if ($request->custom_view != '') {
            $path = resource_path('views/frontend/page/custom/'.
            Str::slug($request->custom_view, '-').'.blade.php');
            File::put($path, '');
        }
        $page->urutan = $this->model->where('parent', (int)$parent)->max('urutan') + 1;
        $page->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];
        $page->save();

        return $page;
    }

    public function updatePage($request,  int $id)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('cover_file')
                ->getClientOriginalName());
            $this->deleteCoverFromPath($request->old_cover_file);
            $request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
        }

        $page = $this->findPage($id);

        $page->fill($request->only(['judul']));
        $page->slug = Str::slug($request->slug, '-');
        $page->intro = $request->intro ?? null;
        $page->content = $request->content ?? null;
        $page->cover = [
            'filename' => $fileName ?? $page->cover['filename'],
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $page->publish = (bool)$request->publish;
        $page->custom_view = $request->custom_view ?? null;
        $page->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];
        $page->save();

        return $page;
    }

    public function statusPage(int $id)
    {
        $page = $this->findPage($id);
        $page->publish = !$page->publish;
        $page->save();

        return $page;
    }

    public function positionPage(int $id, int $urutan, int $parent)
    {
        if ($urutan >= 1) {

            $page = $this->findPage($id);
            if (isset($parent)) {
                $this->model->where('urutan', $urutan)->where('parent', $parent)->update([
                    'urutan' => $page->urutan,
                ]);
            } else {
                $this->model->where('urutan', $urutan)->update([
                    'urutan' => $page->urutan,
                ]);
            }
            $page->urutan = $urutan;
            $page->save();

            return $page;
        }
    }

    public function viewer(int $id)
    {
        $page = $this->findPage($id);
        $page->viewer = ($page->viewer + 1);
        $page->save();

        return $page;
    }

    public function deletePage(int $id)
    {
        $page = $this->findPage($id);

        if (!empty($page->custom_view)) {
            $path = resource_path('views/frontend/page/custom/'.$page->custom_view.'.blade.php');
            File::delete($path);
        }
        if (!empty($page->cover['filename'])) {
            $this->deleteCoverFromPath($page->cover['filename']);
        }

        $child = $this->model->where('parent', $id)->delete();
        $page->delete();

        return $page;
    }

    public function deleteCoverFromPath($fileName)
    {
        $path = public_path('userfile/cover/'.$fileName) ;
        File::delete($path);

        return $path;
    }
}
