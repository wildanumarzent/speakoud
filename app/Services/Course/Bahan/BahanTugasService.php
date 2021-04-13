<?php

namespace App\Services\Course\Bahan;

use App\Models\BankData;
use App\Models\Course\Bahan\BahanTugas;
use App\Models\Course\Bahan\BahanTugasRespon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BahanTugasService
{
    private $model, $modelRespon;

    public function __construct(
        BahanTugas $model,
        BahanTugasRespon $modelRespon
    )
    {
        $this->model = $model;
        $this->modelRespon = $modelRespon;
    }

    public function getPesertaList($request, int $tugasId)
    {
        $query = $this->modelRespon->query();

        $query->where('tugas_id', $tugasId);

        $query->when($request->q, function ($query, $q) {
            $query->where(function ($queryA) use ($q) {
                $queryA->whereHas('user', function (Builder $queryB) use ($q) {
                    $queryB->where('name', 'ilike', '%'.$q.'%')
                        ->orWhereHas('peserta', function (Builder $queryC) use ($q) {
                            $queryC->orWhere('nip', 'ilike', '%'.$q.'%');
                        });
                })->orWhere('keterangan', 'like', '%'.$q.'%');
            });
        });

        $result = $query->paginate(20);

        return $result;
    }

    public function findTugas(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findRespon(int $id)
    {
        return $this->modelRespon->findOrFail($id);
    }

    public function storeTugas($request, $materi, $bahan)
    {
        if ($request->hasFile('files')) {

            $tugas = new BahanTugas;
            $tugas->program_id = $materi->program_id;
            $tugas->mata_id = $materi->mata_id;
            $tugas->materi_id = $materi->id;
            $tugas->bahan_id = $bahan->id;
            $tugas->creator_id = auth()->user()->id;

            foreach ($request->file('files') as $file) {

                $fileName = str_replace(' ', '-', $file->getClientOriginalName());
                $extesion = $file->getClientOriginalExtension();

                if (auth()->user()->hasRole('instruktur_internal|instruktur_mitra')) {
                    $path = 'personal/'.auth()->user()->id.'/tugas/'.$materi->judul.'/'.$request->judul.'/';
                } else {
                    $path = 'global/tugas/'.$materi->judul.'/'.$request->judul.'/'.auth()->user()->name.'/';
                }

                $bankData = new BankData;
                $bankData->file_path = $path.$fileName;
                $bankData->file_type = $extesion;
                $bankData->file_size = $file->getSize();
                $bankData->owner_id = auth()->user()->id;
                $bankData->is_video = 0;
                $bankData->save();

                $bankDataId[] = $bankData->id;

                Storage::disk('bank_data')->put($path.$fileName, file_get_contents($file));
            }

            $tugas->bank_data_id = $bankDataId;
            $tugas->approval = (bool)$request->approval;
            $tugas->tanggal_mulai = $request->tanggal_mulai ?? null;
            $tugas->tanggal_selesai = $request->tanggal_selesai ?? null;
            $tugas->after_due_date = (bool)$request->after_due_date;
            $tugas->save();

            return $tugas;

        } else {
            return false;
        }
    }

    public function updateTugas($request, $bahan)
    {
        $tugas = $bahan->tugas;
        $tugas->approval = (bool)$request->approval;
        $tugas->tanggal_mulai = $request->tanggal_mulai ?? null;
        $tugas->tanggal_selesai = $request->tanggal_selesai ?? null;
        $tugas->after_due_date = (bool)$request->after_due_date;
        $tugas->save();

        return $tugas;
    }

    public function sendTugas($request, int $tugasId)
    {
        $tugas = $this->findTugas($tugasId);

        $telat = 0;
        if (!empty($tugas->tanggal_selesai) && now()->format('Y-m-d H:is') > $tugas->tanggal_selesai) {
            $telat = 1;
        }

        if ($request->hasFile('files')) {

            if ($request->reupload == 'yes') {
                $bankData = BankData::whereIn('id', $tugas->responByUser->bank_data_id)->get();
                foreach ($bankData as $file) {
                    Storage::disk('bank_data')->delete($file->file_path);
                }
                $tugas->responByUser()->delete();
            }

            $respon = new BahanTugasRespon($request->only(['keterangan']));
            $respon->tugas_id = $tugasId;
            $respon->user_id = auth()->user()->id;
            foreach ($request->file('files') as $file) {

                $fileName = str_replace(' ', '-', $file->getClientOriginalName());
                $extesion = $file->getClientOriginalExtension();

                if ($tugas->creator->roles[0] == 'instruktur_internal' || $tugas->creator->roles[0] == 'instruktur_mitra') {
                    $path = 'personal/'.$tugas->creator->id.'/tugas/'.$tugas->materi->judul.'/'.auth()->user()->name.'/'.$tugas->bahan->judul.'/';
                } else {
                    $path = 'global/tugas/'.$tugas->materi->judul.'/'.$tugas->creator->name.'/'.auth()->user()->name.'/'.$tugas->bahan->judul.'/';
                }

                $bankData = new BankData;
                $bankData->file_path = $path.$fileName;
                $bankData->file_type = $extesion;
                $bankData->file_size = $file->getSize();
                $bankData->owner_id = $tugas->creator->id;
                $bankData->is_video = 0;
                $bankData->save();

                $bankDataId[] = $bankData->id;

                Storage::disk('bank_data')->put($path.$fileName, file_get_contents($file));
            }

            $respon->bank_data_id = $bankDataId;
            $respon->telat = $telat;
            $respon->save();

        } else {
            return false;
        }
    }

    public function approval(int $responId, $status)
    {
        $tugas = $this->findRespon($responId);
        $tugas->approval = $status;
        if ($status == 1) {
            $tugas->approval_time = now();
        }
        $tugas->approval_by = auth()->user()->id;
        $tugas->save();

        return $tugas;
    }

    public function penilaian($request, int $responId)
    {
        $tugas = $this->findRespon($responId);
        $tugas->nilai = $request->nilai;
        $tugas->komentar = $request->komentar ?? null;
        $tugas->save();

        return $tugas;
    }
}
