<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Carbon\Carbon;
use App\Models\User;

class PackageComment extends Model
{
    protected $fillable = [];

    protected $appends =['submittedDate','commentDate'];

    public function getsubmittedDateAttribute()
    {
        return Carbon::parse($this->created_at)->isoformat('Do MMMM Y H:ss a');
    }

    public function getcommentDateAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withDefault();
    }

    public function replies()
    {
        return $this->hasMany(PackageCommentReply::class, 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

}
