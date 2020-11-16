<?php

namespace App\Services;

use App\Models\Artikel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Services\Component\TagsService;
class ArtikelService
{
    private $artikel,$tags;

    public function __construct(Artikel $artikel,TagsService $tags)
    {
        $this->artikel = $artikel;
        $this->tags = $tags;
    }

    public function list($request){
        $query = $this->artikel->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('content', 'like', '%'.$q.'%')
                ->orWhere('title', 'like', '%'.$q.'%')
                ->orWhere('intro', 'like', '%'.$q.'%');
            });
        });
        if (auth()->user()->hasRole('developer|administrator|internal') == false) {
            $query->where('created_by',auth()->user()->id);
        }

        $result = $query->orderBy('created_at', 'ASC')->paginate(20);
        return $result;

    }

    public function recent($data){
        $query = $this->artikel->query();
        $query->where('id','!=',$data['id']);
        $result = $query->orderBy('created_at', 'ASC')->paginate(20);
        return $result;
    }

    public function listAll(){
        $query = $this->artikel->query();
        $result = $query->orderBy('created_at', 'ASC')->paginate(20);
        return $result;

    }

    public function get($id){
      $query = $this->artikel->query();
      $query->find($id);
      $result = $query->first();
      return $result;
    }

    public function save($request){
        $artikel = new Artikel($request->only(['title','intro','content','publish']));
       $artikel->meta_data = [
        'title' => $request['m_title'] ?? null,
        'description' => $request['m_description'] ?? null,
        'keywords' => $request['m_keywords'] ?? null,
        ];
        $slug = str_replace(" ", "-", strtolower($request->title));
       $artikel->slug = $slug;

       if ($request->hasFile('cover')) {
        $fileName = str_replace(' ', '-', $request->file('cover')
            ->getClientOriginalName());
        $request->file('cover')->move(public_path('userfile/'.auth()->user()->id.'/artikel'), $fileName);
        $artikel->cover = 'userfile/'.auth()->user()->id.'/artikel'.'/'.$fileName;
    }

    switch ($request->input('action')) {
        case 'save':
            $artikel->publish = 1;
            break;

        case 'draft':
            $artikel->publish = 0;
            break;
    }
       $artikel->save();
       if (isset($request->tags)) {
        $this->tags->store($request,$artikel);
     }
        return $artikel;
    }

    public function update($request){
        $artikel = $this->get($request->id);
        $artikel->fill($request->only(['title','intro','content','cover','publish']));
        $artikel->meta_data = [
            'title' => $request['m_title'] ?? null,
            'description' => $request['m_description'] ?? null,
            'keywords' => $request['m_keywords'] ?? null,
            ];
        $slug = str_replace(" ", "-", strtolower($request->title));
       $artikel->slug = $slug;

       if ($request->hasFile('cover')) {
        $fileName = str_replace(' ', '-', $request->file('cover')
            ->getClientOriginalName());
        $this->deleteCoverFromPath($request->old_cover);
        $request->file('cover')->move(public_path('userfile/'.auth()->user()->id.'/artikel'), $fileName);
        $artikel->cover = 'userfile/'.auth()->user()->id.'/artikel'.'/'.$fileName;
    }
    switch ($request->input('action')) {
        case 'save':
            $artikel->publish = 1;
            break;

        case 'draft':
            $artikel->publish = 0;
            break;
    }
        $artikel->save();
        if (isset($request->tags)) {
            $this->tags->store($request,$artikel);
         }else{
             $this->tags->wipeAndUpdate($artikel);
         }
        return $artikel;
    }

    public function delete($id){
        $artikel = $this->get($id);
        if (!empty($artikel->cover)) {
        $this->deleteCoverFromPath($artikel->cover);
        }
        $artikel->delete();
        return $artikel;
    }

    public function viewer($id){
    $query = $this->artikel->query();
    $query->find($id);
    $query->increment('viewer');
    return true;
    }

    public function middleware($id){
    $artikel = $this->get($id);
    if($artikel->created_by != auth()->user()->id){
    return false;
    }
    return true;
    }

    public function deleteCoverFromPath($path){
        if(File::exists($path)) {
        File::delete($path);
        }
    }





}
