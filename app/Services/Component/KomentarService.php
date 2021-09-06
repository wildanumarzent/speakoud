<?php

namespace App\Services\Component;

use App\Models\Component\Komentar;
class KomentarService
{
    public function __construct(Komentar $comment)
    {
        $this->comment = $comment;
    }
    public function list($request)
    {
        $comment = $this->comment->query();

        $comment->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('komentar', 'like', '%'.$q.'%');
            });
        });

        $result = $comment->orderby('created_at','asc')->paginate(20);
        return $result;

    }
   public function getKomentar($model)
   {
       $comment = $this->comment->query();
       $model = $this->comment->commentable()->associate($model);
       $comment->where('commentable_id',$model['commentable_id'])->where('commentable_type',$model['commentable_type']);
       $result = $comment->with('user')->get();
       return $result;

   }

   public function store($komentar,$model){
    $komen = new Komentar;
    $model = $komen->commentable()->associate($model);
    $model->create([
        'komentar' => $komentar,
        'commentable_type' => $model['commentable_type'],
        'commentable_id' => $model['commentable_id'],
    ]);
    return true;
   }

   public function destroy($id){
    $comment = $this->comment->findorFail($id);
    $comment->delete();
    return $comment;
    }

}
