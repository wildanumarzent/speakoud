<?php

namespace App\Services;

use App\Models\BankData;
use Dotenv\Store\File\Paths;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BankDataService
{
    private $model;

    public function __construct(BankData $model)
    {
        $this->model = $model;
    }

    //directory
    public function getDirectoryList($request)
    {
        if (auth()->user()->hasRole('developer|administrator|internal') &&
            request()->segment(3) == 'global') {
            $type = 'global';
        }

        $directories = Storage::disk('bank_data')->directories($type.'/'.
            $request->path);

        $data = [];
        foreach ($directories as $key => $value) {
            $explode = explode("/", $value);
            $folderName = end($explode);
            $folderPath = str_replace($type, '', $value);

            $data[$key] = [
                'full_path' => $value,
                'path' => $folderPath,
                'name' => $folderName,
            ];
        }

        return $data;
    }

    public function storeDirectory($request)
    {
        $directory = Storage::disk('bank_data')->makeDirectory(
            $this->pathUploadDirectory($request->path).
            $request->directory
        );

        return $directory;
    }

    public function deleteDirectory($name)
    {
        $files = $this->model->where('file_path', 'like', '%'.$name.'%')
            ->get();

        foreach ($files as $key) {
            Storage::disk('bank_data')->delete($key->file_path);
            $key->delete();
        }

        $directory = Storage::disk('bank_data')->deleteDirectory($name);

        return $directory;
    }

    //files
    public function getFileByDirectoryList($request)
    {
        if (auth()->user()->hasRole('developer|administrator|internal') &&
            request()->segment(3) == 'global') {
            $type = 'global';
        }

        $directories = Storage::disk('bank_data')->files($type.'/'.
            $request->path);

        $files = [];
        $data = [];
        foreach ($directories as $key => $value) {
            $query = $this->model->query();
            $query->when($request->q, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('filename', 'like', '%'.$q.'%');
                    $query->orWhere('file_path', 'like', '%'.$q.'%');
                });
            });

            $files[$key] = $value;
            $data = $query->whereIn('file_path', $files)->get();
        }

        return $data;
    }

    public function findFile(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findFileByPath($filePath)
    {
        return $this->model->where('file_path', $filePath)->first();
    }

    public function uploadFile($request)
    {
        $path = $this->pathUploadFile($request->path);

        if ($request->hasFile('file_path')) {

            $file = $request->file('file_path');
            $replace = str_replace(' ', '-', $file->getClientOriginalName());
            $generate = Str::random(5).'-'.$replace;
            $extesion = $file->getClientOriginalExtension();

            $upload = new BankData;
            $upload->file_path = $path.$generate;
            $upload->file_type = $extesion;
            $upload->file_size = $file->getSize();
            $upload->owner_id = auth()->user()->id;
            if ($extesion == 'webm' || $extesion == 'mp4') {
                $upload->is_video = 1;
            }
            $upload->save();

            Storage::disk('bank_data')->put($path.$generate, file_get_contents($file));

            return $upload;

        } else {
            return false;
        }
    }

    public function updateFile($request, int $id)
    {
        $upload = $this->findFile($id);

        if (!empty($request->thumbnail) && $request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $replace = str_replace(' ', '-', $file->getClientOriginalName());
            $generate = Str::random(5).'-'.$replace;
        }

        $upload->thumbnail = !empty($request->thumbnail) ? 'thumbnail/'.$generate : null;
        $upload->filename = $request->filename ?? null;
        $upload->keterangan = $request->keterangan;
        $upload->save();

        if (!empty($request->thumbnail)) {
            Storage::disk('bank_data')->delete($request->old_thumbnail);
            Storage::disk('bank_data')->put('thumbnail/'.$generate, file_get_contents($file));
        }

        return $upload;
    }

    public function deleteFile(int $id)
    {
        $file = $this->findFile($id);

        Storage::disk('bank_data')->delete($file->file_path);
        if ($file->thumbnail != null) {
            Storage::disk('bank_data')->delete($file->thumbnail);
        }
        $file->delete();

        return $file;
    }

    //path
    public function pathUploadDirectory($path)
    {
        if (auth()->user()->hasRole('developer|administrator|internal')) {
            $directory = 'global/'.$path.'/';
        }

        return $directory;
    }

    public function pathUploadFile($path = null)
    {
        $directory = '/';
        if ($path != null) {
            $directory = $path.'/';
        }

        if (auth()->user()->hasRole('developer|administrator|internal')) {
            $dir = 'global'.$directory;
        }

        return $dir;
    }
}
