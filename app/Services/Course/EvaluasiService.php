<?php

namespace App\Services\Course;

use App\Models\Course\ApiEvaluasi;

class EvaluasiService
{
    private $model, $mata;

    public function __construct(
        ApiEvaluasi $model,
        MataService $mata
    )
    {
        $this->model = $model;
        $this->mata = $mata;
    }

    public function registerPeserta(int $mataId, int $pesertaId)
    {
        $mata = $this->mata->findMata($mataId);

        $peserta = $this->peserta->findPeserta($pesertaId);
        $client = new \GuzzleHttp\Client();
        $url = config('addon.api.evaluasi.end_point').'/register/'.$mata->kode_evaluasi;
        $parameter = [
            'nama' => $peserta->user->name,
            'kode_peserta' => $peserta->nip,
            'email' => $peserta->user->email,
            'kode_instansi' => '15017',
            'unit_kerja' => $peserta->unit_kerja,
            'deputi' => $peserta->kedeputian,
        ];
        $response = $client->request('POST', $url, [
            'form_params' => $parameter,
        ]);

        $data = $response->getBody()->getContents();
        $json = json_decode($data);

        $api = new ApiEvaluasi;
        $api->mata_id = $mataId;
        $api->user_id = $peserta->user_id;
        $api->token = $json->data->token;
        $api->evaluasi = $json->data->evaluasi;
        $api->waktu_mulai = $json->data->evaluasi->waktu_mulai;
        $api->waktu_selesai = $json->data->evaluasi->waktu_selesai;
        $api->lama_jawab = $json->data->evaluasi->lama_jawab;
        $api->save();

        return $api;
    }
}
