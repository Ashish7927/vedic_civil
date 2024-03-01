<?php

use App\LessonComplete;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\Lesson;

class UpdateCompleteCourseProcessingForLearnerLesson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $getAllCourseEnrolledByUserId = CourseEnrolled::select('user_id','course_id')->where('is_completed','=','1')->get();
        foreach ($getAllCourseEnrolledByUserId as $two) {
            $lessonCount = Lesson::where("course_id", $two->course_id)->get();
            foreach ($lessonCount as $one) {
                $lesson = new LessonComplete();
                $lesson->user_id = $two->user_id;
                $lesson->course_id = $two->course_id;
                $lesson->lesson_id = $one->id;
                $lesson->status = 1;
                $lesson->save();
            }
            $checkCertificate = CertificateRecord::select("id")->where('student_id', $two->user_id)->where('course_id', $two->course_id)->first();
            if (!isset($checkCertificate->id)) {
                $certificateReports = new CertificateRecord();
                $certificateReports->certificate_id = random_int(100000, 999999);
                $certificateReports->student_id = $two->user_id;
                $certificateReports->course_id = $two->course_id;
                $certificateReports->created_by = $two->user_id;
                $certificateReports->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
