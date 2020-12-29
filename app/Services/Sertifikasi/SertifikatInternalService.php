<?php

namespace App\Services\Sertifikasi;

use App\Models\Sertifikasi\SertifikatInternal;
use App\Models\Sertifikasi\SertifikatPeserta;
use App\Services\Course\MataService;
use clsTinyButStrong;
use Illuminate\Support\Facades\Storage;

class SertifikatInternalService
{
    private $model, $modelPeserta, $mata;

    public function __construct(
        SertifikatInternal $model,
        SertifikatPeserta $modelPeserta,
        MataService $mata
    )
    {
        $this->model = $model;
        $this->modelPeserta = $modelPeserta;
        $this->mata = $mata;
    }

    public function findSertifikat(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeSertifikat($request, int $mataId)
    {
        $sertifikat = new SertifikatInternal;
        $sertifikat->mata_id = $mataId;
        $sertifikat->creator_id = auth()->user()->id;
        $sertifikat->nomor = $request->nomor;
        $sertifikat->tanggal = $request->tanggal;
        $sertifikat->nama_pimpinan = $request->nama_pimpinan;
        $sertifikat->jabatan = $request->jabatan;
        $sertifikat->save();
    }

    public function updateSertifikat($request, int $id)
    {
        $sertifikat = $this->findSertifikat($id);
        $sertifikat->nomor = $request->nomor;
        $sertifikat->tanggal = $request->tanggal;
        $sertifikat->nama_pimpinan = $request->nama_pimpinan;
        $sertifikat->jabatan = $request->jabatan;
        $sertifikat->save();

        return $sertifikat;
    }

    public function cetakSertifikat(int $mataId, int $sertifikatId)
    {
        $mata = $this->mata->findMata($mataId);

        $TBS = new clsTinyButStrong; // new instance of TBS
        $TBS->Plugin(TBS_INSTALL, 'clsOpenTBS'); // load the OpenTBS plugin

        $countPeserta = $this->modelPeserta->where('mata_id', $mataId)->count() + 1;
        $replace = [
            '{no}' => $countPeserta,
            '{bulan}' => $mata->sertifikatInternal->tanggal->format('m'),
            '{tahun}' => $mata->sertifikatInternal->tanggal->format('Y')
        ];
        $generateNomor = strtr($mata->sertifikatInternal->nomor, $replace);

        $GLOBALS['nomor'] = $generateNomor;
        $GLOBALS['nama'] = auth()->user()->name;
        $GLOBALS['program'] = $mata->judul;
        $GLOBALS['jam'] = '92 hours';
        $GLOBALS['start'] = $mata->publish_start->format('F jS');
        $GLOBALS['end'] = $mata->publish_end->format('F jS, Y');
        $GLOBALS['tanggal'] = $mata->sertifikatInternal->tanggal->format('d F Y');
        $GLOBALS['nama_pimpinan'] = $mata->sertifikatInternal->nama_pimpinan;
        $GLOBALS['jabatan'] = $mata->sertifikatInternal->jabatan;
        $GLOBALS['foto'] = public_path('userfile/photo/sertifikat/'.auth()->user()->peserta->foto_sertifikat);

        $template = public_path('userfile\certificate\template-A.docx');
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

        $userName = str_replace(' ', '-', auth()->user()->name);
        $judul = str_replace(' ', '-', $mata->judul);
        $certName = 'Certificate-'.$judul.'.docx';
        $dir = storage_path('/app/bank_data/sertifikat_internal/'.auth()->user()->peserta->id);
        if(!file_exists($dir)){
            Storage::makeDirectory('/bank_data/sertifikat_internal/'.auth()->user()->peserta->id);
        }
        $TBS->Show(OPENTBS_FILE, storage_path('/app/bank_data/sertifikat_internal/'.auth()->user()->peserta->id.'/'.$certName));

        $cetak = new SertifikatPeserta;
        $cetak->sertifikat_id = $sertifikatId;
        $cetak->mata_id = $mataId;
        $cetak->peserta_id = auth()->user()->peserta->id;
        $cetak->file_path = '/sertifikat_internal/'.auth()->user()->peserta->id.'/'.$certName;
        $cetak->save();

        return $cetak;
    }
}
