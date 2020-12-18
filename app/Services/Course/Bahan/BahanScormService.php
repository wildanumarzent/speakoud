<?php

namespace App\Services\Course\Bahan;

use App\Models\Scorm;
use App\Models\Course\Bahan\BahanScorm;
use App\Models\Course\Bahan\ScormCheckpoint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Madnest\Madzipper\Madzipper;
use Orchestra\Parser\Xml\Facade as XmlParser;

class BahanScormService
{
    private $model;

    public function __construct(BahanScorm $model,ScormCheckpoint $checkpoint,Scorm $scorm)
    {
        $this->model = $model;
        $this->scorm = $scorm;
        $this->checkpoint = $checkpoint;
    }

    public function getMaster(){
        $query = $this->scorm->query();
        if (auth()->user()->hasRole('developer|administrator|internal')){
        }else{
        $query->where('creator_id',auth()->user()->id);
        }
        $result = $query->orderby('package_name','asc')->get();
        return $result;
    }

    public function get($id){
       $query = $this->model->query();
       $query->find($id);
       $result = $query->first();
       return $result;
    }
    public function getScorm($id){
        $query = $this->scorm->query();
        $query->find($id);
        $result = $query->first();
        return $result;
     }
    public function checkpoint($userId,$scormId){
        $query = $this->checkpoint->query();
        $query->where('user_id',$userId);
        $query->where('bahan_scorm_id',$scormId);
        $result = $query->first();
        return $result;
     }

    public function storeScorm($request, $materi, $bahan)
    {

        if(!isset($request->scorm_id)){
        if ($request->hasFile('package')) {
            $fileName = str_replace(' ', '-', Carbon::now()->format('ymd-His').'-'.$request->file('package')->getClientOriginalName());
            $filePath = 'userfile/scorm/'.$materi->id;
            $scormPath = $filePath.'/'.basename($fileName, ".zip");
            $request->file('package')->move(public_path($filePath).'/zip', $fileName);
            //extract
            $zip = new Madzipper;
            $zip->make($filePath.'/zip/'.$fileName)->extractTo($scormPath);

            //parsing
            if(File::exists($scormPath.'/imsmanifest.xml')){

            $xml = XmlParser::load($scormPath.'/imsmanifest.xml');
            $parse = $xml->parse([
                'version' => ['uses' => 'metadata.schemaversion'],
                'resource' => ['uses' => 'resources.resource::href'],
            ]);
            }else{
                $oldFile = public_path('userfile/scorm/'.$materi->id.'/zip/'.$fileName);
                File::deleteDirectory($scormPath);
                File::delete($oldFile);
                return false;
            }
            $xmlPath =  $scormPath.'/'.$parse['resource'];
            $masterScorm = new Scorm;
            $masterScorm->package = $xmlPath;
            $masterScorm->version = "ver.".$parse['version'];
            $masterScorm->package_name = basename($request->file('package')->getClientOriginalName(),".zip");
            $masterScorm->save();
            $scormID = $masterScorm->id;
        }
        }else{
            $scormID = $request->scorm_id;
        }
        $scorm = new BahanScorm;
        $scorm->program_id = $materi->program_id;
        $scorm->mata_id = $materi->mata_id;
        $scorm->materi_id = $materi->id;
        $scorm->bahan_id = $bahan->id;
        $scorm->creator_id = auth()->user()->id;
        $scorm->scorm_id = $scormID;
        $scorm->repeatable = (bool)$request->repeatable;
        $scorm->save();

        return $scorm;
    }

    public function updateScorm($request, $bahan)
    {

        $scorm = $bahan->scorm;
        if(!isset($request->scorm_id)){
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
              if(File::exists($scormPath.'/imsmanifest.xml')){
                $xml = XmlParser::load($scormPath.'/imsmanifest.xml');
                $resource = $xml->parse([
                    'version' => ['uses' => 'metadata.schemaversion'],
                    'resource' => ['uses' => 'resources.resource::href'],
                ]);
                }else{
                    File::deleteDirectory($scormPath);
                    return false;
                }

              $xmlPath =  $scormPath.'/'.$resource['resource'];
              $masterScorm = new Scorm;
              $masterScorm->version = "ver.".$resource['version'];
              $masterScorm->package = $xmlPath;
              $masterScorm->package_name = basename($request->file('package')->getClientOriginalName(),".zip");
              $masterScorm->save();
              $scormID = $masterScorm->id;
        }
    }else{
        $scormID = $request->scorm_id;
    }
        $scorm->scorm_id = $scormID;
        $scorm->repeatable = (bool)$request->repeatable;
        $scorm->save();
        return $scorm;
    }

    public function savePoint($data){
        $cp = new ScormCheckPoint;
        $cp->updateOrCreate([
            'bahan_scorm_id' => $data['bahan_scorm_id'],
            'user_id' => $data['user_id']],
            ['bahan_scorm_id' => $data['bahan_scorm_id'],
            'checkpoint' => json_encode($data['checkpoint']),
            'user_id' => $data['user_id']]

            );
        return $cp;
    }
}
