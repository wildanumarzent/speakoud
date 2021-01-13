<?php

namespace App\Services\Course\Template;

use App\Models\BankData;
use App\Models\Course\Template\Bahan\TemplateBahanScorm;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Madnest\Madzipper\Madzipper;
use Orchestra\Parser\Xml\Facade as XmlParser;

class TemplateBahanScormService
{
    private $model;

    public function __construct(TemplateBahanScorm $model)
    {
        $this->model = $model;
    }

    public function storeTemplateScorm($request, $materi, $bahan)
    {
        if ($request->hasFile('package')) {
            $fileName = str_replace(' ', '-', Carbon::now()->format('ymd-His').'-'.$request->file('package')->getClientOriginalName());
            $fileSize = $request->file('package')->getSize();
            $filePath = 'userfile/scorm/template/'.$materi->id;
            $scormPath = $filePath.'/'.basename($fileName, ".zip");
            $request->file('package')->move(public_path($filePath).'/zip', $fileName);

            //extract
            $zip = new Madzipper;
            $zip->make($filePath.'/zip/'.$fileName)->extractTo($scormPath);

            if(File::exists($scormPath.'/imsmanifest.xml')) {

                $xml = XmlParser::load($scormPath.'/imsmanifest.xml');
                $parse = $xml->parse([
                    'version' => ['uses' => 'metadata.schemaversion'],
                    'resource' => ['uses' => 'resources.resource::href'],
                ]);
            } else {
                $oldFile = public_path('userfile/template/scorm/'.$materi->id.'/zip/'.$fileName);
                File::deleteDirectory($scormPath);
                File::delete($oldFile);
                return false;
            }

            $xmlPath =  $scormPath.'/'.$parse['resource'];

            $bankData = new BankData;
            $bankData->file_path = $xmlPath;
            $bankData->file_type = 'scorm';
            $bankData->file_size = $fileSize;
            $bankData->owner_id = auth()->user()->id;
            $bankData->is_video = 0;
            $bankData->save();

            $scorm = new TemplateBahanScorm;
            $scorm->template_mata_id = $materi->template_mata_id;
            $scorm->template_materi_id = $materi->id;
            $scorm->template_bahan_id = $bahan->id;
            $scorm->creator_id = auth()->user()->id;
            $scorm->bank_data_id = $bankData->id;
            $scorm->repeatable = (bool)$request->repeatable;
            $scorm->package = $xmlPath;
            $scorm->version = "ver.".$parse['version'];
            $scorm->package_name = basename($request->file('package')->getClientOriginalName(),".zip");
            $scorm->save();

            return $scorm;
        } else {
            return false;
        }
    }

    public function updateTemplateScorm($request, $bahan)
    {
        $scorm = $bahan->scorm;

        $scorm->repeatable = (bool)$request->repeatable;
        $scorm->save();

        return $scorm;
    }
}
