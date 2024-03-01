<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadFileController extends Controller {

    public function upload_image(Request $request){

    	$request->validate([
            'files.*' => [
                'required',
                'image',
                'mimes:jpeg,jpg,bmp,png,svg,gif'
            ],
        ], [], [
            'files.*' => 'File'
        ]);
        if (!file_exists('uploads/editor-image')) {
                    mkdir('uploads/editor-image', 0777, true);
                }
    	$files = $request->files;
    	$image_url = [];
        foreach ($files as $file) {
        	foreach($file as $k => $f){



	            $fileName = $f->getClientOriginalName() . time() . "." . $f->getClientOriginalExtension();
	            $f->move('uploads/editor-image/', $fileName);
	            $image_url[$k] = asset('uploads/editor-image/' . $fileName);

        	}
        }

        return response()->json($image_url);
    }

    /* Vimeo upload in folder demo 3-3-2022 */
    
    public function vimeo_upload_page(){
        return view('video_upload');
    }

    public function vimeo_upload(Request $request){
        if(!auth()->check()){
            return redirect()->route('login');
        }
        $data = vimeo_upload_video_in_folder($request);
        dd($data);
        return $data;
    }
    /* End : Vimeo upload in folder demo 3-3-2022 */
}