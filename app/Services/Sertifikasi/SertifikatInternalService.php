<?php

namespace App\Services\Sertifikasi;

use App\Models\Sertifikasi\SertifikatInternal;
use App\Services\Course\MataService;
use clsTinyButStrong;

class SertifikatInternalService
{
    private $model, $mata;

    public function __construct(
        SertifikatInternal $model,
        MataService $mata
    )
    {
        $this->model = $model;
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

    public function cetakSertifikat(int $mataId)
    {
        $mata = $this->mata->findMata($mataId);

        $TBS = new clsTinyButStrong; // new instance of TBS
        $TBS->Plugin(TBS_INSTALL, 'clsOpenTBS'); // load the OpenTBS plugin

        $GLOBALS['nomor'] = $mata->sertifikatInternal->nomor;
        $GLOBALS['nama'] = auth()->user()->name;
        $GLOBALS['program'] = $mata->judul;
        $GLOBALS['jam'] = '92 hours';
        $GLOBALS['start'] = $mata->publish_start->format('F jS');
        $GLOBALS['end'] = $mata->publish_end->format('F jS, Y');
        $GLOBALS['tanggal'] = $mata->sertifikatInternal->tanggal->format('d F Y');
        $GLOBALS['nama_pimpinan'] = $mata->sertifikatInternal->nama_pimpinan;
        $GLOBALS['jabatan'] = $mata->sertifikatInternal->jabatan;

        $template = public_path('userfile\certificate\template-A.docx');
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

        $name = str_replace(' ', '-', auth()->user()->name);
        $TBS->Show(OPENTBS_DOWNLOAD, 'Certificate-'.$name.'.docx');
    }
}
