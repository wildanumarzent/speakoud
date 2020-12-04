<?php

namespace App\Services;

use App\Models\Artikel;
use App\Services\Component\NotificationService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Services\Component\TagsService;
use Illuminate\Support\Str;
class ArtikelService
{
    private $model, $tags;

    public function __construct(Artikel $model,TagsService $tags,NotificationService $notifikasi)
    {
        $this->model = $model;
        $this->tags = $tags;
        $this->notifikasi = $notifikasi;
    }

    public function getArtikelList($request)
    {
        $query = $this->model->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title', 'like', '%'.$q.'%');
            });
        });

        if (isset($request->p)) {
            $query->where('publish', $request->p);
        }

        $result = $query->orderBy('created_at', 'DESC')->paginate(20);

        return $result;
    }

    public function getArtikel()
    {
        $query = $this->model->query();

        $query->publish();

        $result = $query->orderBy('created_at', 'DESC')->paginate(8);

        return $result;
    }

    public function getRecentArtikel(int $id)
    {
        $query = $this->model->query();

        $query->publish();
        $query->whereNotIn('id', [$id]);

        $result = $query->inRandomOrder()->limit(8)->get();

        return $result;
    }

    public function findArtikel(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeArtikel($request)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('cover_file')
                ->getClientOriginalName());
            $request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
        }

        $artikel = new Artikel($request->only(['judul']));
        $artikel->slug = Str::slug($request->slug, '-');
        $artikel->intro = $request->intro ?? null;
        $artikel->content = $request->content ?? null;
        $artikel->cover = [
            'filename' => $fileName ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $artikel->publish = (bool)$request->publish;
        $artikel->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];
        $artikel->save();

        $this->tags->store($request, $artikel);
        // if($request->publish == 1){
        // $this->notifikasi->make($model = $artikel,
        //                         $title = 'New Article - '.$artikel['judul'],
        //                         $description = $artikel->intro,
        //                         $special = '',
        //                         $to = '');
        // }
        return $artikel;

    }

    public function updateArtikel($request, int $id)
    {
        if ($request->hasFile('cover_file')) {
            $fileName = str_replace(' ', '-', Str::random(5).'-'.$request->file('cover_file')
                ->getClientOriginalName());
            $this->deleteCoverFromPath($request->old_cover_file);
            $request->file('cover_file')->move(public_path('userfile/cover'), $fileName);
        }

        $artikel = $this->findArtikel($id);
        $artikel->fill($request->only(['title']));
        $artikel->slug = Str::slug($request->slug, '-');
        $artikel->intro = $request->intro ?? null;
        $artikel->content = $request->content ?? null;
        $artikel->cover = [
            'filename' => $fileName ?? $artikel->cover['filename'],
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];
        $artikel->publish = (bool)$request->publish;
        $artikel->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];
        $artikel->save();

        if (isset($request->tags)) {
            $this->tags->store($request, $artikel);
        } else {
            $this->tags->wipeAndUpdate($artikel);
        }

        return $artikel;

    }

    public function statusArtikel(int $id)
    {
        $artikel = $this->findArtikel($id);
        // if($artikel->status == 0){
        //     $this->notifikasi->make($model = $artikel,
        //     $title = 'New Announcement - '.$artikel['title'],
        //     $description = $artikel->sub_content,
        //     $special = '',
        //     $to = '');
        //     }else{
        //          $this->notifikasi->destroy($artikel);
        //     }
        $artikel->publish = !$artikel->publish;
        $artikel->save();

        return $artikel;
    }

    public function viewer(int $id)
    {
        $artikel = $this->findArtikel($id);
        $artikel->viewer = ($artikel->viewer + 1);
        $artikel->save();

        return $artikel;
    }

    public function deleteArtikel(int $id)
    {
        $artikel = $this->findArtikel($id);

        if (!empty($artikel->cover['filename'])) {
            $this->deleteCoverFromPath($artikel->cover['filename']);
        }

        if ($artikel->tags()->count() > 0) {
            $artikel->tags()->delete();
        }
        //  $this->notifikasi->destroy($artikel);
        $artikel->delete();
        return $artikel;
    }

    public function deleteCoverFromPath($fileName)
    {
        $path = public_path('userfile/cover/'.$fileName) ;
        File::delete($path);

        return $path;
    }

    // public function list($request){
    //     $query = $this->artikel->query();

    //     $query->when($request->q, function ($query, $q) {
    //         $query->where(function ($query) use ($q) {
    //             $query->where('content', 'like', '%'.$q.'%')
    //             ->orWhere('title', 'like', '%'.$q.'%')
    //             ->orWhere('intro', 'like', '%'.$q.'%');
    //         });
    //     });
    //     if (auth()->user()->hasRole('developer|administrator|internal') == false) {
    //         $query->where('created_by',auth()->user()->id);
    //     }

    //     $result = $query->orderBy('created_at', 'ASC')->paginate(20);
    //     return $result;

    // }

    // public function recent($data){
    //     $query = $this->artikel->query();
    //     $query->where('id','!=',$data['id']);
    //     $result = $query->orderBy('created_at', 'ASC')->paginate(20);
    //     return $result;
    // }

    // public function listAll(){
    //     $query = $this->artikel->query();
    //     $result = $query->orderBy('created_at', 'ASC')->paginate(20);
    //     return $result;

    // }

    // public function get($id){
    //   $query = $this->artikel->query();
    //   $query->find($id);
    //   $result = $query->first();
    //   return $result;
    // }

    // public function save($request){
    //     $artikel = new Artikel($request->only(['title','intro','content','publish']));
    //    $artikel->meta_data = [
    //     'title' => $request['m_title'] ?? null,
    //     'description' => $request['m_description'] ?? null,
    //     'keywords' => $request['m_keywords'] ?? null,
    //     ];
    //     $slug = str_replace(" ", "-", strtolower($request->title));
    //    $artikel->slug = $slug;

    //    if ($request->hasFile('cover')) {
    //     $fileName = str_replace(' ', '-', $request->file('cover')
    //         ->getClientOriginalName());
    //     $request->file('cover')->move(public_path('userfile/'.auth()->user()->id.'/artikel'), $fileName);
    //     $artikel->cover = 'userfile/'.auth()->user()->id.'/artikel'.'/'.$fileName;
    // }

    // switch ($request->input('action')) {
    //     case 'save':
    //         $artikel->publish = 1;
    //         break;

    //     case 'draft':
    //         $artikel->publish = 0;
    //         break;
    // }
    //    $artikel->save();
    //    if (isset($request->tags)) {
    //     $this->tags->store($request,$artikel);
    //  }
    //     return $artikel;
    // }

    // public function update($request){
    //     $artikel = $this->get($request->id);
    //     $artikel->fill($request->only(['title','intro','content','cover','publish']));
    //     $artikel->meta_data = [
    //         'title' => $request['m_title'] ?? null,
    //         'description' => $request['m_description'] ?? null,
    //         'keywords' => $request['m_keywords'] ?? null,
    //         ];
    //     $slug = str_replace(" ", "-", strtolower($request->title));
    //    $artikel->slug = $slug;

    //    if ($request->hasFile('cover')) {
    //     $fileName = str_replace(' ', '-', $request->file('cover')
    //         ->getClientOriginalName());
    //     $this->deleteCoverFromPath($request->old_cover);
    //     $request->file('cover')->move(public_path('userfile/'.auth()->user()->id.'/artikel'), $fileName);
    //     $artikel->cover = 'userfile/'.auth()->user()->id.'/artikel'.'/'.$fileName;
    // }
    // switch ($request->input('action')) {
    //     case 'save':
    //         $artikel->publish = 1;
    //         break;

    //     case 'draft':
    //         $artikel->publish = 0;
    //         break;
    // }
    //     $artikel->save();
    //     if (isset($request->tags)) {
    //         $this->tags->store($request,$artikel);
    //      }else{
    //          $this->tags->wipeAndUpdate($artikel);
    //      }
    //     return $artikel;
    // }

    // public function delete($id){
    //     $artikel = $this->get($id);
    //     if (!empty($artikel->cover)) {
    //     $this->deleteCoverFromPath($artikel->cover);
    //     }
    //     $artikel->delete();
    //     return $artikel;
    // }

    // public function viewer($id){
    // $query = $this->artikel->query();
    // $query->find($id);
    // $query->increment('viewer');
    // return true;
    // }

    // public function middleware($id){
    // $artikel = $this->get($id);
    // if($artikel->created_by != auth()->user()->id){
    // return false;
    // }
    // return true;
    // }

    // public function deleteCoverFromPath($path){
    //     if(File::exists($path)) {
    //     File::delete($path);
    //     }
    // }
}
