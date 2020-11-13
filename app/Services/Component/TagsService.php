<?php

namespace App\Services\Component;

use App\Models\Component\Tags;
use App\Models\Component\TagsTipe;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
class TagsService
{

    private $tagsTipe,$tags;

    public function __construct(TagsTipe $tagsTipe,Tags $tags)
    {
        $this->tagsTipe = $tagsTipe;
        $this->tags = $tags;
    }

    public function store($request,$data){
        $tagsName = explode(',',$request['tags']);
        $tagsName = array_map('strtolower', $tagsName);
        $tagsName = array_map('ucwords', $tagsName);
        $tags = new Tags;
        $tagsTipe = new TagsTipe;
        foreach($tagsName as $name){
        $tags->updateOrCreate(
            ['nama' => $name],
            ['nama' => $name]
        );
        $tagsTipe->tag_id = $this->tags->latest()->first()->id;
        $tagsTipe->tagable()->associate($data);
        $tagsTipe->save();
        }
        return true;
    }

    public function update($request,$data){
        $tagsName = explode(',',$request['tags']);
        $tagsName = array_map('strtolower', $tagsName);
        $tagsName = array_map('ucwords', $tagsName);
        $tags = new Tags;
        $tagsTipe = new TagsTipe;
        foreach($tagsName as $name){
        $tags->updateOrCreate(
            ['nama' => $name],
            ['nama' => $name]
        );
        $tagsTipe->tag_id = Tags::latest()->first()->id;
        $tagsTipe->tagable()->associate($data)->save();
        }
        return true;
    }





}
