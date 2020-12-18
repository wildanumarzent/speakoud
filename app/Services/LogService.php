<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class LogService{


    public function list($request){

        $log = Log::query();
        $log->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->whereDate('created_at', '=', $q);
            });
        });
        $result = $log->orderby('created_at','desc')->paginate(40);
        return $result;
    }
}


