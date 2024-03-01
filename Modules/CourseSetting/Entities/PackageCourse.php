<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class PackageCourse extends Model
{
    protected $fillable = [];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class)->withoutGlobalScope('withoutsubscription')->where('is_subscription', 1);
    }
}
