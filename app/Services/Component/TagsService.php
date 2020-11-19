<?php

namespace App\Services\Component;

use App\Models\Component\Tags;
use App\Models\Component\TagsTipe;
class TagsService
{

    private $tagsTipe,$tags;

    public function __construct(TagsTipe $tagsTipe,Tags $tags)
    {
        $this->tagsTipe = $tagsTipe;
        $this->tags = $tags;
    }

    public function list($request){
        $query = $this->tags->query();

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('nama', 'like', '%'.$q.'%')
                ->orWhere('keterangan', 'like', '%'.$q.'%')
                ->orWhere('related', 'like', '%'.$q.'%');
            });
        });
        $result = $query->orderBy('created_at', 'ASC')->paginate(20);
        return $result;
    }

    public function store($request,$model){
        $tagsName = explode(',',$request['tags']);
        $tagsName = array_map('strtolower', $tagsName);
        $tags = new Tags;
        foreach($tagsName as $name){
        $tags->updateOrCreate(
            ['nama' => $name],
            ['nama' => $name]
        );
        }
        $this->wipeAndUpdate($model,$tagsName);

        return true;
    }

    public function wipeAndUpdate($model,$tags = null){
        $tagsTipe = new TagsTipe;
        $model = $tagsTipe->tagable()->associate($model);
        $this->wipe($model);
        if($tags != NULL){
        foreach($tags as $name){
        $tagID = $this->tags->where('nama',$name)->first()->id;
        $tagsTipe->updateOrCreate(
            ["tag_id" => $tagID,"tagable_id" => $model->tagable_id,"tagable_type" => $model->tagable_type],
            ["tag_id" => $tagID,"tagable_id" => $model->tagable_id,"tagable_type" => $model->tagable_type]
        );
        }
        }
        return true;
    }
    public function wipe($model){
        $query = $this->tagsTipe->query();
        $query->where('tagable_id',$model->tagable_id)->where('tagable_type',$model->tagable_type)->get();
        $query->delete();
    }

    public function update($request)
    {
        $tags = $this->tags->query();
        $tags->findorFail($request->id);
        $tags->update($request->only(['keterangan','standar','pantas','related']));
        return true;
    }

    public function destroy($id){
        $tags = $this->tags->findorFail($id);
        $tags->delete();
        return $tags;
    }





}
