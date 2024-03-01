<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AddCompletionDateToEnrolledCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $courses = \Modules\CourseSetting\Entities\Course::all();
        $courses = \App\LessonComplete::all();

        foreach ($courses as $key => $value) {
            $progress = round($value->course->userTotalPercentage($value->user_id,$value->course_id));
            if($progress){
                if($progress == 100){
                    $course_enrolled = \Modules\CourseSetting\Entities\CourseEnrolled::where('course_id', $value->course_id)->where('user_id', $value->user_id)->first();
                    $lesson_data = \App\LessonComplete::where('course_id', $value->course_id)->where('user_id', $value->user_id)->get()->toArray();
                    if(count($lesson_data)>0){
                        $last = last($lesson_data);
                        $end_date = $last["created_at"];
                    }
                    if($course_enrolled){
                        $course_enrolled->is_completed = 1;
                        $course_enrolled->completion_date = $end_date;
                        $course_enrolled->save();
                    }
                }
            }
        }
        
    }
}
