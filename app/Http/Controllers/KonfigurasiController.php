<?php

namespace App\Http\Controllers;

use App\Http\Requests\KonfigurasiUploadRequest;
use App\Services\KonfigurasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class KonfigurasiController extends Controller
{
    private $service;

    public function __construct(KonfigurasiService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data['upload'] = $this->service->getConfigIsUpload();
        $data['general'] = $this->service->getConfig(2);
        $data['meta'] = $this->service->getConfig(3);
        $data['socmed'] = $this->service->getConfig(4);

        return view('backend.konfigurasi.index', compact('data'), [
            'title' => 'Konfigurasi - Konten',
            'breadcrumbsBackend' => [
                'Konfigurasi' => '',
                'Konten' => ''
            ],
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->name as $key => $value) {
            $this->service->updateConfig($key, $value);
        }

        return back()->with('success', 'Konfigurasi konten berhasil edit');
    }

    public function upload(KonfigurasiUploadRequest $request, $name)
    {
        $this->service->uploadFile($request, $name);

        return back()->with('success', 'File berhasil diupload');
    }

    public function strip(Request $request)
    {
        $lang = 'id';

        if ($request->has('lang')) {
            $data = "<?php \n\nreturn [\n";
            foreach ($request->lang as $key => $value) {
                $data .= "\t'$key' => '$value',\n";
            }
            $data .= "];";
            File::put(base_path('resources/lang/'.$lang.'/strip.php'), $data);
            return back()->with('success', 'Strip text berhasil diedit');
        }

        $data['title'] = 'Strip Text';
        $data['files'] = Lang::get('strip', [], $lang);

        return view('backend.konfigurasi.strip', compact('data'), [
            'title' => 'Konfigurasi - Strip Text',
            'breadcrumbsBackend' => [
                'Konfigurasi' => '',
                'Strip Text' => ''
            ],
        ]);
    }

    public function sertifikat(Request $request)
    {
        $lang = 'id';

        if ($request->has('lang')) {
            $data = "<?php \n\nreturn [\n";
            foreach ($request->lang as $key => $value) {
                $data .= "\t'$key' => '$value',\n";
            }
            $data .= "];";
            File::put(base_path('resources/lang/'.$lang.'/sertifikat.php'), $data);
            return back()->with('success', 'Sertifikat berhasil diedit');
        }

        $data['title'] = 'Sertifikat';
        $data['files'] = Lang::get('sertifikat', [], $lang);

        return view('backend.konfigurasi.sertifikat', compact('data'), [
            'title' => 'Konfigurasi - Sertifikat',
            'breadcrumbsBackend' => [
                'Konfigurasi' => '',
                'Sertifikat' => ''
            ],
        ]);
    }
}
