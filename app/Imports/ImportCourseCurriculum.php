<?php

namespace App\Imports;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Http\Controllers\CourseSettingController;
use Modules\SCORM\Http\Controllers\SCORMController;
use Modules\VdoCipher\Http\Controllers\VdoCipherController;

class ImportCourseCurriculum implements WithStartRow, WithHeadingRow, ToModel
{

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function Model(array $rows)
    {
        $user = Auth::user();
        if ($user->role_id == 1 || $user->role_id == 5 || $user->role_id == 6) {
            $course = Course::where('id', $rows['course_id'])->first();
        } else {
            $course = Course::where('id', $rows['course_id'])->where('user_id', Auth::id())->first();
        }

        $chapter = Chapter::find($rows['chapter_id']);

        if (isset($course) && isset($chapter)) {
            $lesson = new Lesson();
            $lesson->course_id = $rows['course_id'];
            $lesson->chapter_id = $rows['chapter_id'];
            if (isset($rows['name'])) {
                $lesson->name = $rows['name'];
            }

            if (isset($rows['description'])) {
                $lesson->description = $rows['description'];
            }

            if (isset($rows['host'])) {
                $lesson->host = $rows['host'];
            }

            if (isset($rows['duration'])) {
                $lesson->duration = $rows['duration'];
            }

            if (isset($rows['is_lock'])) {
                $lesson->is_lock = $rows['is_lock'];
            }

            $lesson->video_url = "";
            $lesson->save();
            $course->curriculum_tab = 1;
            $course->save();
        }

        return $course;
    }
}
