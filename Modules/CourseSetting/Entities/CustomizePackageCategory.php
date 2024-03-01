<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class CustomizePackageCategory extends Model
{
    protected $fillable = [];

    public function package()
    {
        return $this->belongsTo(CustomizePackages::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
