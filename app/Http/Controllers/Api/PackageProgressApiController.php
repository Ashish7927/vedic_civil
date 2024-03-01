<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CourseSetting\Entities\PackageProgress;
use Validator;
use Modules\Certificate\Entities\CertificateRecord;
use App\Http\Controllers\Frontend\WebsiteController;
use App\Models\User;

class PackageProgressApiController extends Controller
{
    public function storePackageProgress(Request $request){
        
        $rules = [
            'learner_email' => 'required|exists:users,email',
            'package_id' => 'required',
            'course_id' => 'required',
            'course_name' => 'required',
            'course_image_url' => 'required',
            'course_url' => 'required',
            'learning_progress' => 'required',
            'status' => 'required'
        ];

        if ($request->status == 'completed') {
            $rules['certificate_url'] = 'required';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $validator->errors();
        }

        $response = array('response' => '', 'success' => false);
        try {
            
            $learner = User::where('email', 'student@demo.com')->first();
            $PackageProgress = PackageProgress::where('learner_id',$learner->id)->where('package_id',$request->package_id)->where('course_id',$request->course_id)->first();

            if(!$PackageProgress){
                $PackageProgress = new PackageProgress();
            }
            $PackageProgress->learner_id = $learner->id;
            $PackageProgress->package_id = $request->package_id;
            $PackageProgress->course_id = $request->course_id;
            $PackageProgress->course_name = $request->course_name;
            $PackageProgress->course_image_url = $request->course_image_url;
            $PackageProgress->course_url = $request->course_url;
            $PackageProgress->learning_progress = $request->learning_progress;
            $PackageProgress->certificate_url = $request->certificate_url;
            $PackageProgress->status = ($request->status == 'completed' || $request->status == 'Completed') ? 1 : 0;
            $PackageProgress->save();

            if ($request->status == 'completed' || $request->status == 'Completed') {
                
                $websiteController = new WebsiteController();
                $certificate_record = CertificateRecord::where('student_id', $learner->id)->where('course_id', $request->course_id)->first();
                if (!$certificate_record) {
                    $certificate_record = new CertificateRecord();
                    $certificate_record->certificate_id = $websiteController->generateUniqueCode();
                    $certificate_record->student_id = $learner->id;
                    $certificate_record->course_id = $request->course_id;
                    $certificate_record->created_by = $learner->id;
                    $certificate_record->is_api_record = 1;
                    $certificate_record->package_id = $request->package_id;
                    $certificate_record->save();
                }
            }

            $response = [
                'success' => true,
                'message' => 'Operation successful'
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => $th->getMessage()
            ];
            return response()->json($response, 500);
        }
    }
}
