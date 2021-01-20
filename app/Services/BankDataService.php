<?php

namespace App\Services;

use App\Models\BankData;
use App\Models\Course\Bahan\BahanAudio;
use App\Models\Course\Bahan\BahanFile;
use App\Models\Course\Bahan\BahanVideo;
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
        $type = ['global', 'personal/'.auth()->user()->id];

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
                    $query->where('file_path', 'ilike', '%'.$q.'%');
                    $query->orWhere('filename', 'ilike', '%'.$q.'%');
                });
            })->when($request->path, function ($query, $path) {
                $query->where(function ($query) use ($path) {
                    $this->typeOfFile($path, $query);
                });
            });

            // if ($type != null) {
            //     $this->typeOfFile($type, $query);
            // }

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
            $query->whereIn('file_type', ['mp3', 'wav']);
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

        // foreach ($files as $key) {
        //     Storage::disk('bank_data')->delete($key->file_path);
        //     Storage::disk('bank_data')->delete($key->thumbnail);
        //     $key->delete();
        // }

        if ($files->count() == 0) {
            $directory = Storage::disk('bank_data')->deleteDirectory($name);
        } else {
            return false;
        }

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
                    $query->where('file_path', 'ilike', '%'.$q.'%');
                    $query->orWhere('filename', 'ilike', '%'.$q.'%');
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
            $fileName = str_replace(' ', '-', $file->getClientOriginalName());
            $extesion = $file->getClientOriginalExtension();

            if (!empty($request->thumbnail) && $request->hasFile('thumbnail')) {
                $fileThumb = $request->file('thumbnail');
                $fileNameThumb = str_replace(' ', '-', $fileThumb->getClientOriginalName());
                $pathThumb = 'thumbnail/'.auth()->user()->id.'/';
            }

            $upload = new BankData;
            $upload->file_path = str_replace('//', '/', $path.$fileName);
            $upload->thumbnail = !empty($request->thumbnail) ? $pathThumb.$fileNameThumb : null;
            $upload->file_type = $extesion;
            $upload->file_size = $file->getSize();
            $upload->filename = $upload->filename ?? null;
            $upload->keterangan = $upload->keterangan ?? null;
            $upload->owner_id = auth()->user()->id;
            if ($extesion == 'webm' || $extesion == 'mp4') {
                $upload->is_video = 1;
            }
            $upload->save();

            Storage::disk('bank_data')->put($path.$fileName, file_get_contents($file));
            if (!empty($request->thumbnail)) {
                Storage::disk('bank_data')->put($pathThumb.$fileNameThumb, file_get_contents($fileThumb));
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
            $fileName = str_replace(' ', '-', $file->getClientOriginalName());
            $pathThumb = 'thumbnail/'.auth()->user()->id.'/';
        }

        $upload->thumbnail = !empty($request->thumbnail) ? $pathThumb.$fileName : null;
        $upload->filename = $request->filename ?? null;
        $upload->keterangan = $request->keterangan;
        $upload->save();

        if (!empty($request->thumbnail)) {
            Storage::disk('bank_data')->delete($request->old_thumbnail);
            Storage::disk('bank_data')->put($pathThumb.$fileName, file_get_contents($file));
        }

        return $upload;
    }

    public function deleteFile(int $id)
    {
        $file = $this->findFile($id);

        $dokumen = BahanFile::where('bank_data_id', $id)->count();
        $audio = BahanAudio::where('bank_data_id', $id)->count();
        $video = BahanVideo::where('bank_data_id', $id)->count();

        if ($dokumen > 0 || $audio > 0 || $video > 0) {

            return false;

        } else {
            Storage::disk('bank_data')->delete($file->file_path);
            if ($file->thumbnail != null) {
                Storage::disk('bank_data')->delete($file->thumbnail);
            }
            $file->delete();

            return true;
        }
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

        if (!empty(request()->get('view'))) {
            if (auth()->user()->hasRole('developer|administrator|internal')) {
                if ($path == null) {
                    $dir = 'global/'.$path;
                } else {
                    $dir = 'global/'.$directory;
                }
            } else {
                if ($path == null) {
                    $dir = 'personal/'.auth()->user()->id.'/'.$path;
                } else {
                    $dir = 'personal/'.auth()->user()->id.'/'.$directory;
                }
            }
        } else {
            if (auth()->user()->hasRole('developer|administrator|internal')) {
                $dir = 'global'.$directory;
            } else {
                $dir = 'personal/'.auth()->user()->id.$directory;
            }
        }

        return $dir;
    }
}
