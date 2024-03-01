<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class CustomizePackageCourse extends Model
{
    protected $fillable = [];

    public function CustomizePackages()
    {
        return $this->belongsTo(CustomizePackages::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
}
