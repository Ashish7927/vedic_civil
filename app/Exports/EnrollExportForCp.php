<?php

namespace App\Exports;

use Modules\CourseSetting\Entities\CourseEnrolled;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Modules\Quiz\Entities\QuizTest;
use App\LessonComplete;

class EnrollExportForCp implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct($start_date, $end_date, $status, $name) {
            $this->start_date = $start_date;
            $this->end_date = $end_date;
            $this->status = $status;
            $this->name = $name;
    }

    public function headings():array{
        return[
            'Name',
            'User Status',
            'Courses Enrolled',
            'Courses Type',
            'Courses Duration',
            'Course Status',
            // 'Pass',
            'Enrollment Date',
            'End Date'
        ];
    }

    public function map($row): array{

        $pass = '';
        $end_date = '';
        $course_type = '';
        $status = $row->course->status;
        $course_status = $row->is_completed;
        if($course_status == 1)
            $course_status_final = 'Completed';
        else
            $course_status_final = 'In Progress';

        if($row->user->is_active == 1)
            $user_status = 'Active';
        else
            $user_status = 'Inactive';

        if($row->course->type == 1){
            $course_type = 'Course';
        }

        if($row->course->type == 2){
            $course_type = 'Quiz';
            $quiz_test=QuizTest::where('user_id',$row->user_id)->where('course_id',$row->course_id)->where('quiz_id',$row->course->quiz_id)->first();
            if ($quiz_test) {
                if ($quiz_test->pass == 1) {
                    $pass = 'Pass';
                }
            }
        }

        $status_complete_progress = 'In Progress';
        if($row->course->type == 1){
            $progress = round($row->course->userTotalPercentage($row->user_id,$row->course_id));
            if($progress){
                if($progress == 100){
                    $status_complete_progress = 'Completed';
                    // $pass = 'Pass';
                }
            }
        }

        if($status_complete_progress == 'Completed'){
            $course_id = $row->course_id;
            $user_id = $row->user_id;
            $lesson_data = LessonComplete::where('course_id', $course_id)->where('user_id', $user_id)->get()->toArray();
            if(count($lesson_data)>0){
                $last = last($lesson_data);
                $end_date = showDate($last["created_at"]);
                // if($end_date != '' && $course_status == 1)
                    // $pass = 'Pass';
            }
        }

        $date_of_completion = $row->completion_date;
        $end_date_final = '';
        if($date_of_completion != '' && $date_of_completion != null){
            $end_date_final = showDate($date_of_completion);
        }

        $fields = [
            $row->user->name,
            $user_status,
            $row->course->title,
            $course_type,
            $row->course->duration,
            $course_status_final,
            // $pass,
            showDate($row->created_at),
            $end_date_final,
        ];
        return $fields;
    }

    public function styles(Worksheet $sheet)
    {
        return [
           1    => ['font' => ['bold' => true]],
        ];
    }

    public function collection()
    {
        // $enrolled_list = CourseEnrolled::all();
        $user = auth()->user();
        if ($user->role_id == 2 || $user->role_id == 7 || is_partner($user)) {
            $enrolled_list = CourseEnrolled::with('user', 'course')
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })->groupBy('user_id','course_id');

        } else {
            $enrolled_list = CourseEnrolled::with('user', 'course')->groupBy('user_id','course_id');
        }

        if($this->start_date != ''){
            $enrolled_list->whereDate('created_at', '>=', $this->start_date);
        }
        if($this->end_date != ''){

            // $enrolled_list->whereDate('completion_date', '<=', $this->end_date);
            $enrolled_list->whereDate('created_at', '<=', $this->end_date);
            // $end_date = $this->end_date;
            // $enrolled_list->whereHas('course', function ($query2) use ($end_date) {
            //     $query2->whereHas('completeLessons', function ($query3) use ($end_date) {
            //         return $query3->whereDate('created_at',$end_date);
            //     });
            // });
        }

        if (!empty($this->name) && $this->name!="") {
            // $query = $query->where('name', 'like', '%' . $this->name . '%');
            $name = $this->name;
            $enrolled_list->whereHas('user', function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            });
        }

        if($this->status != ''){
            $status = (int)$this->status;
            $enrolled_list->where('is_completed', $status);
            // $enrolled_list->where('status',$this->status);
            // $enrolled_list->whereHas('course', function ($query) use ($status) {
            //     return $query->where('status', $status);
            // });
        }
        $enrolled_list = $enrolled_list->get();
        return $enrolled_list;
    }
}
