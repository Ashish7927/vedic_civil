<?php

namespace Modules\CourseSetting\Entities;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class CourseFeedback extends Model
{
    //protected $table = 'course_feedback';
    protected $fillable = [];

    public function course()
    {

        return $this->belongsTo(Course::class, 'course_id')->withDefault();
    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
