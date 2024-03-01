<?php

namespace App\Exports;

use App\Models\User;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CourseExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    function __construct($category, $instructor, $course, $course_status, $status, $from_duration, $to_duration, $start_price, $end_price, $total_rating, $content_provider, $from_submission_date, $to_submission_date) {
        $this->category = $category;
        $this->instructor = $instructor;
        $this->course = $course;
        $this->course_status = $course_status;
        $this->status = $status;
        $this->from_duration = $from_duration;
        $this->to_duration = $to_duration;
        $this->start_price = $start_price;
        $this->end_price = $end_price;
        $this->total_rating = $total_rating;
        $this->content_provider = $content_provider;
        $this->from_submission_date = $from_submission_date;
        $this->to_submission_date = $to_submission_date;
    }

    public function headings():array {
        return[
            'Course Title',
            'Skill Area',
            'CP/Partner',
            'Trainer',
            'Status',
            'Lesson',
            'Enrolled',
            'Published Date',
            'Price'
        ];
    }

    public function map($row): array {
        $status = "";
        if ($row->status == 1) {
            $status ="Published";
        } elseif ($row->status == 2) {
            $status ="Saved";
        } elseif ($row->status == 3) {
            $status ="Approved";
        } elseif ($row->status == 4) {
            $status ="Rejected";
        } else {
            $status ="In Review";
        }

        $priceView = '';
        if ($row->discount_price != null) {
            $priceView = getPriceFormat($row->discount_price);
        } else {
            $priceView =getPriceFormat($row->price);
        }
        if($priceView == ''){
            $priceView="Free";
        }

        $enrollCount = 0;
        if($row->enrollCount!=""){
            $enrollCount = $row->enrollCount;
        }

        $fields = [
            $row->title,
            $row->category->name,
            $row->user->name,
            $row->trainer,
            $status,
            $row->lessons->count(),
            $enrollCount,
            showDate($row->publishedDate),
            $priceView,
        ];
        return $fields;
    }

    public function styles(Worksheet $sheet) {
        return [
           1    => ['font' => ['bold' => true]],
        ];
    }

    public function collection() {
        $query = Course::withoutGlobalScope('withoutsubscription')->whereIn('type', [1, 2])->with('category', 'quiz', 'user');

        if (isCourseReviewer()) {
            $query->whereIn('status', [0, 1, 3, 4]);
        }

        if (check_whether_cp_or_not() || isPartner()) {
            $query->whereHas('user', function ($q) {
                $q->where('id', auth()->user()->id);
            });
        }

        if ($this->course_status != "") {
            if ($this->course_status == 1) { // Active
                $query->whereIn('courses.status', [1, 3]);
            } elseif ($this->course_status == 0) { // Pending
                $query->whereIn('courses.status', [0, 4]);
            } elseif ($this->course_status == 2) { // Saved
                $query->where('courses.status', 2);
            }
        }

        if ($this->status != "") {
            $query->where('courses.status', $this->status);
        }

        $category = $this->category;
        if ($category != "") {
            $query->where(function($q) use($category) {
                $q->where('category_id', $category)->orWhere('category_ids', 'LIKE', '%' . "," . $category . "," . '%');
            });
        }

        if($this->instructor != ""){
            $query->where('user_id', $this->instructor);
        }

        if ($this->from_duration != "" || $this->to_duration != "") {
            if ($this->from_duration != "" && $this->to_duration != "") {
                $query->where('duration', ">=", (int)$this->from_duration)->where("duration", "<=", (int)$this->to_duration);
            } elseif ($this->from_duration != "" && $this->to_duration == "") {
                $query->where('duration', "=", (int)$this->from_duration);
            } elseif ($this->from_duration == "" && $this->to_duration != "") {
                $query->where('duration', "=", (int)$this->to_duration);
            }
        }

        if (!empty($this->start_price)  && $this->start_price != "") {
            $query->where('price', '>=', $this->start_price);
        }

        if (!empty($this->end_price)  && $this->end_price != "") {
            $query->where('price', '<=', $this->end_price);
        }

        if ($this->total_rating != "") {
            $query->where('total_rating', $this->total_rating);
        }

        if ($this->content_provider != "") {
            $query->where('user_id', $this->content_provider);
        }

        if ($this->from_submission_date != "" || $this->to_submission_date != "") {
            if ($this->from_submission_date != "" && $this->to_submission_date != "") {
                $query->whereDate('submitted_at', ">=", $this->from_submission_date)->whereDate("submitted_at", "<=", $this->to_submission_date);
            } elseif ($this->from_submission_date != "" && $this->to_submission_date == "") {
                $query->whereDate('submitted_at', ">=", $this->from_submission_date);
            } elseif ($this->from_submission_date == "" && $this->to_submission_date != "") {
                $query->whereDate('submitted_at', "<=", $this->to_submission_date);
            }
        }

        if (isInstructor()) {
            $query->where('user_id', Auth::id());
        }

        if (isCourseReviewer()) {
            $query->latest('submitted_at');
        }

        $query->select('courses.*');
        $query = $query->get();

        return $query;
    }
}
