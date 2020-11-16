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

    public function filemanDirectory($request)
    {
        $global = Storage::disk('bank_data')->directories('global/'.$request->path);
        $personal = Storage::disk('bank_data')->directories('personal/'.
            auth()->user()->id.'/'.$request->path);
        $type = ['global/'.$request->path, 'personal/'.auth()->user()->id.'/'.$request->path];

        $directories = array_merge($global, $personal);

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

    public function filemanFile($request, $type = null)
    {
        $global = Storage::disk('bank_data')->files('global/'.$request->path);
        $personal = Storage::disk('bank_data')->files('personal/'.
            auth()->user()->id.'/'.$request->path);

        $directories = array_merge($global, $personal);

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

            if ($type != null) {
                $this->typeOfFile($type, $query);
            }

            $files[$key] = $value;
            $data = $query->whereIn('file_path', $files)->get();
        }

        return $data;
    }

    public function typeOfFile($type, $query)
    {
        //link
        if ($type == 'link') {
            $query->where('is_video', 0);
        }
        //audio
        if ($type == 'audio') {
            $query->where('file_type', 'mp3');
        }
        //video
        if ($type == 'video') {
            $query->where('is_video', 1);
        }
        //file
        if ($type == 'pdf') {
            $query->where('file_type', 'pdf');
        }
        if ($type == 'ppt') {
            $query->where('file_type', 'ppt');
        }
        if ($type == 'pptx') {
            $query->where('file_type', 'pptx');
        }
        if ($type == 'doc') {
            $query->where('file_type', 'doc');
        }
        if ($type == 'docx') {
            $query->where('file_type', 'docx');
        }

        //all file
        if ($type == 'dokumen') {
            $query->where('file_type', 'pdf')
                ->orWhere('file_type', 'ppt')
                ->orWhere('file_type', 'pptx');
        }

        return $query;
    }

    //directory
    public function getDirectoryList($request)
    {
        if (request()->segment(3) == 'global') {
            $type = 'global';
        }

        if (request()->segment(3) == 'personal') {
            $type = 'personal/'.auth()->user()->id;
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
            Storage::disk('bank_data')->delete($key->thumbnail);
            $key->delete();
        }

        $directory = Storage::disk('bank_data')->deleteDirectory($name);

        return $directory;
    }

    //files
    public function getFileByDirectoryList($request)
    {
        if (request()->segment(3) == 'global') {
            $type = 'global';
        }

        if (request()->segment(3) == 'personal') {
            $type = 'personal/'.auth()->user()->id;
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

            if (!empty($request->thumbnail) && $request->hasFile('thumbnail')) {
                $fileThumb = $request->file('thumbnail');
                $replaceThumb = str_replace(' ', '-', $fileThumb->getClientOriginalName());
                $generateThumb = Str::random(5).'-'.$replaceThumb;
                $pathThumb = 'thumbnail/'.auth()->user()->id.'/';
            }

            $upload = new BankData;
            $upload->file_path = $path.$generate;
            $upload->thumbnail = !empty($request->thumbnail) ? $pathThumb.$generateThumb : null;
            $upload->file_type = $extesion;
            $upload->file_size = $file->getSize();
            $upload->filename = $upload->filename ?? null;
            $upload->keterangan = $upload->keterangan ?? null;
            $upload->owner_id = auth()->user()->id;
            if ($extesion == 'webm' || $extesion == 'mp4') {
                $upload->is_video = 1;
            }
            $upload->save();

            Storage::disk('bank_data')->put($path.$generate, file_get_contents($file));
            if (!empty($request->thumbnail)) {
                Storage::disk('bank_data')->put($pathThumb.$generateThumb, file_get_contents($fileThumb));
            }

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
            $pathThumb = 'thumbnail/'.auth()->user()->id.'/';
        }

        $upload->thumbnail = !empty($request->thumbnail) ? $pathThumb.$generate : null;
        $upload->filename = $request->filename ?? null;
        $upload->keterangan = $request->keterangan;
        $upload->save();

        if (!empty($request->thumbnail)) {
            Storage::disk('bank_data')->delete($request->old_thumbnail);
            Storage::disk('bank_data')->put($pathThumb.$generate, file_get_contents($file));
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
        } else {
            $directory = 'personal/'.auth()->user()->id.'/'.$path.'/';
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
        } else {
            $dir = 'personal/'.auth()->user()->id.$directory;
        }

        return $dir;
    }
}
