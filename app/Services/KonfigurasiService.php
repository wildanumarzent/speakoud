<?php

namespace App\Services;

use App\Models\Konfigurasi;
use Illuminate\Support\Facades\File;

class KonfigurasiService
{
    private $model;

    public function __construct(Konfigurasi $model)
    {
        $this->model = $model;
    }

    public function getConfig($group)
    {
        $query = $this->model->query();

        $query->where('group', $group)->where('is_upload', 0);

        $result = $query->get();

        return $result;
    }

    public function getConfigIsUpload()
    {
        $query = $this->model->query();

        $query->upload();

        $result = $query->get();

        return $result;
    }

    public function getValue($name)
    {
        return $this->model->value($name);
    }

    public function updateConfig($name, $value)
    {
        $config = $this->model->where('name', $name)->first();
        $config->value = $value;
        $config->save();

        return $config;
    }

    public function uploadFile($request, $name)
    {
        if ($request->hasFile($name)) {

            if ($name == 'banner_default') {

                $fileName = 'banner-default-'.now()->format('YmdHis').'.'.
                $request->file('banner_default')->guessExtension();
                $request->file('banner_default')->move(public_path('userfile/banner'), $fileName);

                $loc = public_path('userfile/banner/'.$request->old_banner_default) ;
                File::delete($loc);

            } elseif ($name == 'google_analytics_api') {

                $fileName = 'service-account-credentials.'.
                $request->google_analytics_api->getClientOriginalExtension();
                $request->file('google_analytics_api')->move(storage_path('app/analytics'), $fileName);

            }

            $config = $this->model->where('name', $name)->first();
            $config->value = $fileName;
            $config->save();

            return $config;
        } else {
            return false;
        }
    }
}
