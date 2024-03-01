<?php

namespace Modules\SCORM\Http\Controllers;

use App\Traits\Filepond;
use App\Traits\UploadTheme;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class SCORMController extends Controller
{
    use UploadTheme, Filepond;

    public $url = '';
    public $path = '';
    public $host = '';

    public function getScormUrl($path, $host, $sco_vendor_type ='other')
    {

        $uniqId = uniqid();
        try {
            $zip = new ZipArchive;
            $res = $zip->open($path);

            if ($res === true) {
                $zip->extractTo(storage_path('app/tempScorm/' . $uniqId));
                $zip->close();

            } else {
                abort(500, 'Error! Could not open File');
            }
            $src = storage_path('app/tempScorm/' . $uniqId);
            $folder = '/public/uploads/scorm/' . $uniqId . '/';
            $temp_folder = 'storage/app/tempScorm/' . $uniqId . '/';
            $dst = base_path($folder);

            $imsmanifest = base_path($temp_folder . 'imsmanifest.xml');
            $index = 'index.html';
            if (file_exists($imsmanifest)) {
                $result = simplexml_load_file($imsmanifest)[0];
                $index = $result->resources->resource['href'];
                if($sco_vendor_type == 'storyline'){
                    $index = 'story.html';
                }
            }

            if ($host == "SCORM-AwsS3") {
                $files = Storage::allFiles('tempScorm/' . $uniqId . '/');
                foreach ($files as $object) {
                    $path_info = pathinfo($object);
                    $file_name = $path_info['filename'] . '.' . $path_info['extension'];
                    $dirname = str_replace('tempScorm/', '', $path_info['dirname']);
                    $fullname = $dirname . '/' . $file_name;
                    Storage::disk('s3')->put($fullname, file_get_contents(storage_path('app/' . $object), 'public'));
                }
                $link = Storage::disk('s3')->url($uniqId);
                $link .= '/' . $index;
                $return = $link;
            } else {
                $this->recurse_copy($src, $dst);
                $return = $folder . $index;
            }
            $this->deleteFile($host, $path);
            return $return;
        } catch (\Exception $e) {
            $this->deleteFile($host, $path);
        }
        return null;
    }


    public function deleteFile($host, $path = null)
    {
        if (storage_path('app/tempScorm')) {
            $this->delete_directory(storage_path('app/tempScorm'));
        }
        if ($path){
            File::delete($path);
        }
    }


}
