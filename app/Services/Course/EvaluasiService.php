<?php

namespace App\Services\Course;

use App\Models\Course\ApiEvaluasi;
use App\Services\Course\Bahan\BahanService;

class EvaluasiService
{
    private $model, $mata, $bahan;

    public function __construct(
        ApiEvaluasi $model,
        MataService $mata,
        BahanService $bahan
    )
    {
        $this->model = $model;
        $this->mata = $mata;
        $this->bahan = $bahan;
    }

    //penyelenggara
    public function preview($kodeEvaluasi)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('addon.api.evaluasi.end_point').'/preview/'.$kodeEvaluasi;
        $response = $client->request('GET', $url, [

        ]);

        $data = $response->getBody()->getContents();
        $json = json_decode($data);

        return $json;
    }

    public function result($kodeEvaluasi)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('addon.api.evaluasi.end_point').'/result/'.$kodeEvaluasi;
        $response = $client->request('GET', $url, [

        ]);

        $data = $response->getBody()->getContents();
        $json = json_decode($data);

        return $json->data;
    }

    public function register($mataId, $kodeEvaluasi, $bahanId = null)
    {
        $client = new \GuzzleHttp\Client();
        $url = config('addon.api.evaluasi.end_point').'/register/'.$kodeEvaluasi;
        $parameter = [
            'nama' => auth()->user()->name,
            'kode_peserta' => auth()->user()->peserta->nip,
            'email' => auth()->user()->email,
            'kode_instansi' => auth()->user()->peserta->instansi(auth()->user()->peserta)->kode_instansi,
            'unit_kerja' => auth()->user()->peserta->unit_kerja,
            'deputi' => auth()->user()->peserta->kedeputian,
        ];

        $response = $client->request('POST', $url, [
            'form_params' => $parameter,
        ]);

        $data = $response->getBody()->getContents();
        $json = json_decode($data);

        if ($json->success == true) {
            $api = new ApiEvaluasi;
            $api->mata_id = $mataId;
            $api->bahan_id = ($bahanId != null) ? $bahanId : null;
            $api->user_id = auth()->user()->id;
            $api->token = $json->data->token;
            $api->evaluasi = $json->data->evaluasi;
            $api->waktu_mulai = $json->data->evaluasi->waktu_mulai;
            $api->waktu_selesai = $json->data->evaluasi->waktu_selesai;
            $api->lama_jawab = $json->data->evaluasi->lama_jawab;
            $api->save();
        }

        return $json;
    }

    public function checkUserPenyelenggara(int $mataId)
    {
        return $this->model->where('mata_id', $mataId)->where('user_id', auth()->user()->id);
    }

    public function checkUserPengajar(int $mataId, int $bahanId)
    {
        return $this->model->where('mata_id', $mataId)->where('bahan_id', $bahanId)
            ->where('user_id', auth()->user()->id);
    }

    public function recordUserPenyelenggara(int $mataId)
    {
        $record = $this->checkUserPenyelenggara($mataId)->update([
                'start_time' => now(),
            ]);

        return $record;
    }

    public function recordUserPengajar(int $mataId, int $bahanId)
    {
        $record = $this->checkUserPengajar($mataId, $bahanId)->update([
                'start_time' => now(),
            ]);

        return $record;
    }

    public function submitAnswerPenyelenggara($request, int $mataId)
    {
        $mata = $this->mata->findMata($mataId);
        $token = $this->checkUserPenyelenggara($mataId)->first();

        $client = new \GuzzleHttp\Client();
        $instrumen = [];
        foreach ($request->instrumen as $key) {
            $instrumen[$key] = $request->input('opsi-'.$key);
        }
        $parameter = [
            'token' => $token->token,
            'instrumen' => $instrumen
        ];
        $url = config('addon.api.evaluasi.end_point').'/submit-answers/'.$mata->kode_evaluasi;
        $response = $client->request('POST', $url, [
            'form_params' => $parameter,
        ]);

        $data = $response->getBody()->getContents();
        $json = json_decode($data);

        if ($json->success == true) {
            $record = $this->checkUserPenyelenggara($mataId)->update([
                'is_complete' => 1,
            ]);

            return true;
        } else {
            return false;
        }
    }

    public function submitAnswerPengajar($request, int $mataId, int $bahanId)
    {
        $mata = $this->mata->findMata($mataId);
        $bahan = $this->bahan->findBahan($mataId);
        $token = $this->checkUserPengajar($mataId, $bahanId)->first();

        $client = new \GuzzleHttp\Client();
        $instrumen = [];
        foreach ($request->instrumen as $key) {
            $instrumen[$key] = $request->input('opsi-'.$key);
        }
        $parameter = [
            'token' => $token->token,
            'instrumen' => $instrumen
        ];
        $url = config('addon.api.evaluasi.end_point').'/submit-answers/'.$bahan->evaluasiPengajar->mataInstruktur->kode_evaluasi;
        $response = $client->request('POST', $url, [
            'form_params' => $parameter,
        ]);

        $data = $response->getBody()->getContents();
        $json = json_decode($data);

        if ($json->success == true) {
            $record = $this->checkUserPengajar($mataId, $bahanId)->update([
                'is_complete' => 1,
            ]);

            return true;
        } else {
            return false;
        }
    }
}
