<?php

namespace App\Services\Course\Bahan;

use App\Models\Course\Bahan\BahanScorm;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Madnest\Madzipper\Madzipper;
use Orchestra\Parser\Xml\Facade as XmlParser;

class BahanScormService
{
    private $model;

    public function __construct(BahanScorm $model)
    {
        $this->model = $model;
    }

    public function get($id){
       $query = $this->model->query();
       $query->find($id);
       $result = $query->first();
       return $result;
    }

    public function storeScorm($request, $materi, $bahan)
    {
        if ($request->hasFile('package')) {

            $fileName = str_replace(' ', '-', Carbon::now()->format('ymd-His').'-'.$request->file('package')->getClientOriginalName());
            $filePath = 'userfile/scorm/'.$materi->id;
            $scormPath = $filePath.'/'.basename($fileName, ".zip");
            $request->file('package')->move(public_path($filePath).'/zip', $fileName);
            //extract
            $zip = new Madzipper;
            $zip->make($filePath.'/zip/'.$fileName)->extractTo($scormPath);

            //parsing
            $xml = XmlParser::load($scormPath.'/imsmanifest.xml');
            $resource = $xml->parse([
                'resource' => ['uses' => 'resources.resource::href'],
            ]);

            $xmlPath =  $scormPath.'/'.$resource['resource'];


            $scorm = new BahanScorm;
            $scorm->program_id = $materi->program_id;
            $scorm->mata_id = $materi->mata_id;
            $scorm->materi_id = $materi->id;
            $scorm->bahan_id = $bahan->id;
            $scorm->creator_id = auth()->user()->id;
            $scorm->package = $xmlPath;
            $scorm->package_name = basename($fileName,".zip");
            $scorm->save();

            return $scorm;
        } else {
            return false;
        }
    }

    public function updateScorm($request, $bahan)
    {

        $scorm = $bahan->scorm;
        if ($request->hasFile('package')) {
            $fileName = str_replace(' ', '-', Carbon::now()->format('ymd-His').'-'.$request->file('package')->getClientOriginalName());
            $filePath = 'userfile/scorm/'.$bahan->materi_id;
            $scormPath = $filePath.'/'.basename($fileName, ".zip");
            $oldFile = public_path('userfile/scorm/'.$scorm->materi_id.'/zip/'.$request->old_package.'.zip') ;
            $oldDir =  public_path('userfile/scorm/'.$scorm->materi_id.'/'.$request->old_package) ;
            File::delete($oldFile);
            File::deleteDirectory($oldDir);
            $request->file('package')->move(public_path('userfile/scorm/'.$scorm->materi_id.'/zip'), $fileName);
              //extract
              $zip = new Madzipper;
              $zip->make($filePath.'/zip/'.$fileName)->extractTo($scormPath);

              //parsing
              $xml = XmlParser::load($scormPath.'/imsmanifest.xml');
              $resource = $xml->parse([
                  'resource' => ['uses' => 'resources.resource::href'],
              ]);

              $xmlPath =  $scormPath.'/'.$resource['resource'];
              $scorm->package = $xmlPath;
              $scorm->package_name = basename($fileName,".zip");
             $scorm->save();

            return $scorm;
        } else {
            return false;
        }
    }
}
