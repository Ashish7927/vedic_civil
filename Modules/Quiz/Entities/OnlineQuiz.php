<?php

namespace Modules\Quiz\Entities;

use Modules\Quiz\Entities\QuizMarking;
use Illuminate\Database\Eloquent\Model;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\SubCategory;
use Illuminate\Database\Eloquent\Builder;

class OnlineQuiz extends Model
{
    protected $fillable = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('quizdata', function (Builder $builder) {
            $builder->where('corporate_id', null);
        });
    }

    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    public function subCategory()
    {

        return $this->belongsTo(Category::class, 'sub_category_id', 'id')->withDefault();
    }

    public function course()
    {

        return $this->belongsTo(Course::class, 'course_id', 'id')->withDefault();
    }

    public function assign()
    {

        return $this->hasMany(OnlineExamQuestionAssign::class, 'online_exam_id', 'id');
    }

    public function assignRand()
    {

        return $this->hasMany(OnlineExamQuestionAssign::class, 'online_exam_id', 'id')->inRandomOrder();
    }

    public function totalMarks()
    {
        $totalMark = 0;
        $assigns = $this->hasMany(OnlineExamQuestionAssign::class, 'online_exam_id')->with('questionBank')->get();
        if (count($assigns) != 0) {
            foreach ($assigns as $assign) {
                $totalMark = $totalMark + $assign->questionBank->marks;
            }
        }

        return $totalMark;
    }

    public function totalQuestions()
    {
        return $this->hasMany(OnlineExamQuestionAssign::class, 'online_exam_id')->count();

    }

    static function getAttendStatus($student_id,$course_id,$quiz_id){
        $quiz_test=QuizTest::where('user_id',$student_id)->where('course_id',$course_id)->where('quiz_id',$quiz_id)->first();
        if ($quiz_test) {
            return true;
        } else {
            return false;
        }
    }
    static function getObtainMarks($student_id,$course_id,$quiz_id){
        $quiz_test=QuizMarking::where('student_id',$student_id)->where('quiz_id',$quiz_id)->first();

        if ($quiz_test) {
            return  $quiz_test;
        } else {
            return 0;
        }
    }

}
