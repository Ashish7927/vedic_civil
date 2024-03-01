<?php

namespace Modules\Quiz\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Modules\CourseSetting\Entities\Course;
use Illuminate\Database\Eloquent\Builder;

class QuizTest extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('quiztestdata', function (Builder $builder) {
            $builder->whereHas('course', function ($query) {
                    $query->where('corporate_id', null);
                });
        });
    }

    public function details()
    {
        return $this->hasMany(QuizTestDetails::class, 'quiz_test_id');
    }

    public function quiz()
    {
        return $this->belongsTo(OnlineQuiz::class, 'quiz_id')->withDefault();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withDefault();
    }
}
