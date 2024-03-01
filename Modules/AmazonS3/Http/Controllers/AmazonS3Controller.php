<?php

namespace Modules\AmazonS3\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class AmazonS3Controller extends Controller
{
    public function index()
    {
        return view('amazons3::s3setting');

    }

    public function store(Request $request)
    {
        $access_key_id = $request->access_key_id;
        $secret_key = $request->secret_key;
        $default_region = $request->default_region;
        $bucket = $request->bucket;

        if (!empty($access_key_id)) {
            putEnvConfigration('AWS_ACCESS_KEY_ID', $access_key_id);
        }

        if (!empty($secret_key)) {
            putEnvConfigration('AWS_SECRET_ACCESS_KEY', $secret_key);
        }
        if (!empty($default_region)) {
            putEnvConfigration('AWS_DEFAULT_REGION', $default_region);
        }
        if (!empty($bucket)) {
            putEnvConfigration('AWS_BUCKET', $bucket);
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function storeFile($file)
    {
        $filePath = '/';
        $path = $file->store($filePath, 's3');
        $url = Storage::disk('s3')->url($path);
        return $url;
    }
}
