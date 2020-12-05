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

    public function previewSoal(int $mataId)
    {
        $mata = $this->mata->findMata($mataId);

        $client = new \GuzzleHttp\Client();
        $url = config('addon.api.evaluasi.end_point').'/preview/'.$mata->kode_evaluasi;
        $response = $client->request('GET', $url, [

        ]);

        $data = $response->getBody()->getContents();
        $json = json_decode($data);

        return $json->data->evaluasi;
    }

    public function checkUser(int $mataId)
    {
        return $this->model->where('mata_id', $mataId)->where('user_id', auth()->user()->id);
    }

    public function recordUser(int $mataId)
    {
        $record = $this->checkUser($mataId)->update([
                'start_time' => now(),
            ]);

        return $record;
    }

    public function submitAnswer($request, int $mataId)
    {
        $mata = $this->mata->findMata($mataId);
        $token = $this->checkUser($mataId)->first();

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
            $record = $this->checkUser($mataId)->update([
                'is_complete' => 1,
            ]);
        }
    }
}
