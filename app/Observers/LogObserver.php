<?php

namespace App\Observers;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
class LogObserver
{
    public function saved($model){
        $log = new Log;
        $nama = $model->judul ?? $model->title ?? $model->nama ?? $model->name;

        if(empty($nama)){
        $nama = 'Sesuatu';
        }
        $data = $log->logable()->associate($model);
        if ($model->wasRecentlyCreated == true) {
            $event = 'created';
            $deskripsi = "Menambahkan {$model->getTable()} : {$nama}";
        } else {
            $oldNama = $model->getOriginal('judul') ?? $model->getOriginal('title') ?? $model->getOriginal('nama') ?? $model->getOriginal('name');
            $event = "updated";
            $deskripsi = "Merubah Data {$model->getTable()} : {$oldNama} new {$event}";
        }

        if (Auth::check()) {
        Log::create([
            'creator' => Auth::user()->name,
            'creator_id' => Auth::user()->id,
            'event' => $event,
            'logable_id' => $data['logable_id'],
            'logable_type' => $data['logable_type'],
            'logable_name' => $model->getTable(),
            'ip_address' => request()->ip(),
            'deskripsi' => $deskripsi,
        ]);
        }
    }
    public function deleting($model){
        $log = new Log;
        $data = $log->logable()->associate($model);
        $nama = $model->judul ?? $model->title ?? $model->nama ?? $model->name;
        $deskripsi = "Menghapus {$model->getTable()} - {$nama}";
        if(empty($nama)){
            $nama = 'Sesuatu';
            }
        if (Auth::check()) {
            Log::create([
                'creator' => Auth::user()->name,
                'creator_id' => Auth::user()->id,
                'event' => 'deleted',
                'logable_id' => $data['logable_id'],
                'logable_type' => $data['logable_type'],
                'logable_name' => $model->getTable(),
                'ip_address' => request()->ip(),
                'deskripsi' => $deskripsi,
            ]);
            }
    }
}
