<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
use App\Traits\Blameable;
class Artikel extends Model
{
    use Blameable; // auto created_by & updated_by
    protected $table = 'artikel';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function userUpdate(){
        return $this->belongsTo(User::class,'updated_by');
    }
}
