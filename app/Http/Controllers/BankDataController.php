<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bank\UploadFileRequest;
use App\Services\BankDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankDataController extends Controller
{
    private $service;

    public function __construct(BankDataService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request, $type)
    {
        $data['directories'] = $this->service->getDirectoryList($request);
        $data['files'] = $this->service->getFileByDirectoryList($request);
        $data['roles'] = auth()->user()->hasRole('developer|administrator|internal');

        if (auth()->user()->hasRole('developer|administrator|internal') &&
            $request->segment(3) == 'personal') {
            return abort(404);
        }

        return view('backend.bank_data.index', compact('data'), [
            'title' => 'Bank Data - '.ucfirst($type),
            'breadcrumbsBackend' => [
                'Bank Data' => '',
            ],
        ]);
    }

    public function filemanager(Request $request)
    {
        $data['directories'] = $this->service->filemanDirectory($request);
        $data['files'] = $this->service->filemanFile($request, $request->get('type-file'));

        return view('backend.bank_data.filemanager', compact('data'), [
            'title' => 'Bank Data - Filemanager',
        ]);
    }

    //directory
    public function storeDirectory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'directory' => 'required',
        ], [
            'required' => 'Nama Folder tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator) ->withInput();
        } else {
            $this->service->storeDirectory($request);

            return back()->with('success', 'Folder berhasil ditambahkan');
        }
    }

    public function destroyDirectory(Request $request)
    {
        $delete = $this->service->deleteDirectory($request->path);

        if ($delete == true) {
            
            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {
            
            return response()->json([
                'success' => 0,
                'message' => 'Folder tidak bisa dihapus, karena masih memiliki file'
            ], 200);
        }
    }

    //files
    public function streamFile($filePath)
    {
        return response()->file(storage_path('app/bank_data/'.$filePath));
    }

    public function storeFile(UploadFileRequest $request)
    {
        $this->service->uploadFile($request);

        return back()->with('success', 'File berhasil diupload');
    }

    public function updateFile(UploadFileRequest $request, $id)
    {
        $this->service->updateFile($request, $id);

        return back()->with('success', 'Data file berhasil edit');
    }

    public function destroyFile($id)
    {
        $owner = $this->service->findFile($id)->owner_id;

        if ($owner != auth()->user()->id) {
            return response()->json([
                'success' => 0,
                'message' => 'Anda tidak memiliki akses untuk menghapus file user lain'
            ], 200);
        }

        $delete = $this->service->deleteFile($id);

        if ($delete == true) {
            
            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);

        } else {
            
            return response()->json([
                'success' => 0,
                'message' => 'File masih dipakai di materi pelatihan'
            ], 200);
        }
    }
}
